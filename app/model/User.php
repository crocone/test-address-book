<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 17:22
 */

namespace App\Model;


class User extends Model
{
    const TABLE = 'user';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $user
     * @return int
     */
    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare('INSERT INTO ' . self::TABLE .
            '(email, name, password, auth_token, created_at, updated_at) VALUES (:email,:name,:password,:auth_token, :created_at, :updated_at)'
        );
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('name', $user['name'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('auth_token', $user['auth_token'], \PDO::PARAM_STR);
        $statement->bindValue('created_at', $user['created_at'], \PDO::PARAM_INT);
        $statement->bindValue('updated_at', $user['created_at'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }else{
            return  false;
        }
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function register($name, $email, $password){
        $user['email'] = $email;
        $user['name'] = $name;
        $user['password'] = password_hash($password, PASSWORD_DEFAULT);
        $user['auth_token'] = uniqid('U-');
        $user['created_at'] = time();
        if(!$result = $this->insert($user)){
            return false;
        }
        return true;
    }

    public function auth($email,$password){
        $statement = $this->pdo->prepare('SELECT * FROM '. self::TABLE. ' WHERE email=:email');
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        if($statement->execute()) {
            $user = $statement->fetch();
            if ($user && password_verify($password, $user['password'])) {
                return $user['auth_token'];
            } else {
                return false;
            }
        }
        return false;
    }

    private function passwordHash($email,$password, $salt){
        return password_hash($password,PASSWORD_DEFAULT);
    }
    /**
     * @param string $accessToken
     * @return array|bool
     */
    public function checkAccessToken($accessToken){
        $statement = $this->pdo->prepare('SELECT * FROM '. self::TABLE.' WHERE auth_token = :auth_token');
        $statement->bindValue('auth_token', $accessToken, \PDO::PARAM_STR);
        if(!$statement->execute()){
            return  false;
        };
        return  $statement->fetch();
    }

    /**
     * @param array $user
     * @return bool
     */
    public function update(array $user):bool
    {

        // prepared request
        $password =  !empty($user['password']) ? '`password` = :password,' : '';
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `email` = :email, ".$password."`updated_at` = :updated_at WHERE id=:id");
        $statement->bindValue('id', $user['id'], \PDO::PARAM_STR);
        $statement->bindValue('name', $user['name'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        if(!empty($user['password'])) {
            $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        }
        $statement->bindValue('updated_at', time(), \PDO::PARAM_INT);

        return $statement->execute();
    }
}