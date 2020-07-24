<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 16:18
 */

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Home page
     *
     * @return $string
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     */

    public function index(){
        return $this->renderPartial('home/index.php',['title' => 'Авторизация']);
    }
    public function register(){
        return $this->renderPartial('home/register.php', ['title' => 'Регистрация']);
    }
}