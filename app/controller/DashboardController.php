<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 22.07.2020
 * Time: 1:22
 */

namespace App\Controller;


use App\Model\Contact;
use App\Model\User;

class DashboardController extends AbstractController
{
    public function index(){
        return $this->render('dashboard/index.php',['title' => 'Контакты']);
    }

    public function profile(){
        return $this->render('dashboard/profile.php',['title' => 'Мой профиль']);
    }

    public function admin(){
        return $this->render('dashboard/admin.php',['title' => 'Пользователи']);
    }
}