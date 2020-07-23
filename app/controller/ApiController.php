<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 18:47
 */

namespace App\Controller;


use App\Model\Contact;
use App\Model\User;

class ApiController extends AbstractController
{
    protected $user;

    public function __construct()
    {
        $this->user = false;
        if(isset($_GET['access-token'])){
            $user = new User();
            $this->user =  $user->checkAccessToken($_GET['access-token']);

        }
    }

    public function getUsers(){
        if(!$this->user['is_admin']){
            json_encode(['status' => 0, 'message' => 'Имя и Email обязательны к заполнению']);
            exit();
        }else{
            $user = new User();
            $data = $user->selectAll();
            return $this->renderPartial('/dashboard/_userProfileTemplate.php',['items' => $data]);
        }
    }

    public function updateProfile(){
        $data = $_POST;
        $data['id'] = $this->user['id'];
        if (empty($data['email']) || empty($data['name'])) {
            $return = ['status' => 0, 'message' => 'Логин и Email обязательны к заполнению'];
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $return = ['status' => 0, 'message' => 'Email указан в неверном формате'];
        } elseif(self::validateLogin($data['name'])){
            $return = ['status' => 0, 'message' => 'Логин указан в неверном формате. (Допустимы только цифры и латинские буквы)'];
        } elseif (!self::validatePassword($data['newPassword'])) {
            $return = ['status' => 0, 'message' => 'Пароль должен содержать цифры и латинские буквы'];
        } elseif ($data['newPassword'] !== $data['confirmNewPassword']) {
            $return = ['status' => 0, 'message' => 'Пароль и подтверждение пароля должны совпадать'];
        } elseif (empty($data['password']) && (!empty($data['newPassword']) || !empty($data['confirmNewPassword']))) {
            $return = ['status' => 0, 'message' => 'Для изменения пароля нужно ввести старый пароль'];
        }elseif(!empty($data['password']) && !password_verify($data['password'], $this->user['password'])) {
            $return = ['status' => 0, 'message' => 'Старый пароль введен неверно'];
        }else{
                $user = new User();
                if(!empty($data['password'])){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                if($user->update($data)){
                    $return = ['status' => 1, 'message' => 'Ваш профиль успешно обновлен'];
                }else{
                    $return = ['status' => 0, 'message' => 'Произошла ошибка'];
                }
        }
        echo json_encode($return);
    }

    public function getProfile(){
        return $this->renderPartial('/dashboard/_profileTemplate.php',['user' => $this->user]);
    }

    public function auth(){
        if(!$this->user) {
            $email = $_POST['email'] ?? false;
            $password = $_POST['password'] ?? false;
            if (!$email || !$password) {
                $return = ['status' => 0, 'message' => 'Все поля обязательны к заполнению'];
            } else {
                $user = new User();
                $token = $user->auth($email, $password);
                $return = !$token ? ['status' => 0, 'message' => 'Неправильно введён логин или пароль'] : ['status' => 1, 'access_token' => $token];
            }
            if(!parent::checkSession()){
                session_start();
            }
            $_SESSION['access-token'] = $token;
            echo json_encode($return);
        }else{
            echo json_encode(['status' => 0, 'message' => 'Вы уже авторизованы']);
        }
    }

    public function register(){
        if(!$this->user) {
            $email = $_POST['email'] ?? false;
            $password = $_POST['password'] ?? false;
            $passwordConfirm = $_POST['passwordConfirm'] ?? false;
            $name = $_POST['name'] ?? false;
            if(!$email || !$password || !$passwordConfirm || !$name) {
                $return = ['status' => 0, 'message' => 'Все поля обязательны к заполнению'];
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $return = ['status' => 0, 'message' => 'Email указан в неверном формате'];
            }elseif (!self::validateLogin($name)) {
                $return = ['status' => 0, 'message' => 'Логин указан в неверном формате. (Допустимы только цифры и латинские буквы)'];
            }elseif (!self::validatePassword($password)) {
                $return = ['status' => 0, 'message' => 'Пароль должен содержать цифры и латинские буквы'];
            }elseif ($passwordConfirm !== $password) {
                $return = ['status' => 0, 'message' => 'Пароль и подтверждение пароля должны совпадать'];
            } else {
                $user = new User();
                $token = $user->register($name, $email, $password);
                $return = !$token ? ['status' => 0, 'message' => 'Произошла ошибка'] : ['status' => 1, 'message' => 'Вы успешно зарегистрировались, теперь можете авторизоваться используя указанный email и пароль'];
            }
            echo json_encode($return);
        }else{
            echo json_encode(['status' => 0, 'message' => 'Вы уже авторизованы']);
        }
    }

    public function contact(){
        if(!$this->user) {
            echo json_encode(['status' => 0, 'message' => 'Вы не авторизованы']);
            exit();
        }
        $id = (int)$_POST['id'];
        $contact = new Contact();
        $contact = $contact->selectOneById($id);
        if($contact['user'] !== $this->user['id']){
            echo json_encode(['status' => 0, 'message' => 'У вас нет прав для выполнения этой операции']);
            exit();
        }
        echo json_encode($contact);
    }
    public function updateContact(){
        if(!$this->user) {
            echo json_encode(['status' => 0, 'message' => 'Вы не авторизованы']);
            exit();
        }
        $data = $_POST;
        $contactModel = new Contact();
        $contact = $contactModel->selectOneById((int)$data['id']);
        if($contact['user'] !== $this->user['id']){
            echo json_encode(['status' => 0, 'message' => 'У вас нет прав для выполнения этой операции']);
            exit();
        }
        $data['image'] = $contact['image'];
        if(!empty($_FILES['contactImage']['name'])){
            $data['image'] = (new \App\Model\Contact)->saveFile($_FILES['contactImage']);
            if(!$data['image']){
                echo json_encode(['status' => 0, 'message' => 'Произошла ошибка при сохрании изображения']);
                exit();
            }
            if($contact['image'] !== 'default.png') {
                unlink(FILE_PATH . $contact['image']);
            }
        }
        if(!$contactModel->update($data)){
            echo json_encode(['status' => 0, 'message' => 'Произошла ошибка при сохрании контакта']);
            exit();
        }
        $newContact = new Contact();
        echo json_encode(['status' => 1, 'message' => 'Контакт успешно сохранён', 'data' => $newContact->selectOneById($contact['id'])]);
    }

    public function getContact(){
        if(!$this->user) {
            echo json_encode(['status' => 0, 'message' => 'Вы не авторизованы']);
            exit();
        }
        if(!isset($_POST['id'])){
            echo json_encode(['status' => 0, 'message' => 'Произошла ошибка']);
        }
        $contactModel = new Contact();
        $contact[] = $contactModel->selectOneById((int)$_POST['id']);
        if($contact[0]['user'] !== $this->user['id']){
            echo json_encode(['status' => 0, 'message' => 'У вас нет прав для выполнения этой операции']);
            exit();
        }
        return $this->renderPartial('dashboard/_contactTemplate.php',['items' => $contact]);
    }
    public function addContact(){
        if(!$this->user) {
            echo json_encode(['status' => 0, 'message' => 'Вы не авторизованы']);
            exit();
        }
        $data = $_POST;
        $data['user'] =  $this->user['id'];
        if(!empty($_FILES['contactImage']['name'])){
            $data['image'] = (new \App\Model\Contact)->saveFile($_FILES['contactImage']);
            if(!$data['image']){
                echo json_encode(['status' => 0, 'message' => 'Произошла ошибка при сохрании изображения']);
                exit();
            }
        }
        $contact = new Contact();
        if($id = $contact->insert($data)){
            $return = ['status' => 1, 'message' => 'Контакт успешно добавлен','id' => $id];
        }else{
            $return = ['status' => 0, 'message' => 'Произошла ошибка при добавлении контакта'];
        }

        echo json_encode($return);
    }
    public function contacts(){
        if(!$this->user) {
            echo json_encode(['status' => 0, 'message' => 'Вы не авторизованы']);
            exit();
        }
        $page = $_POST['page'] ?? 1;

        $search = strlen($_POST['search']) > 0 ? $_POST['search'] : false;
        $contacts = new Contact();
        $items = $contacts->list($page, $this->user,REC_BY_PAGE,$search);
        return $this->renderPartial('dashboard/_contactTemplate.php',  ['items' => $items]);
    }
    private function validateLogin($name){
        return preg_match("/^[A-Za-z0-9]+$/",$name);
    }
    private function validatePassword($password){
        if (preg_match('/[A-zА-я]+/', $password))
            if (preg_match('/[0-9]+/', $password))
                return true; //  содержит как минимум 1 букву и цифру
            else
                return false; //  содержит только 1 букву
        else
            return false; //  не содержит ни букв ни цифр
    }
}