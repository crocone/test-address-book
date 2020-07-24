<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 16:16
 */

namespace App\Controller;

use App\Model\User;

abstract class AbstractController
{

    protected $user;
    protected $action;

    public function __construct()
    {
        $routeParts = explode('/', ltrim($_SERVER['REQUEST_URI'], '/') ?: HOME);
        $this->user = false;
        $sessionStatus = false;
        $this->action = $routeParts[1];

        if(!self::checkSession()){
            session_start();
        }
        if(isset($_SESSION['access-token'])){
            $user = new User();
            $this->user =  $user->checkAccessToken($_SESSION['access-token']);
        }elseif($routeParts[0] !== 'home'){
            header('Location: /');
        }
    }

    function render($file, $variables = array()) {
        $variables['action'] = $this->action;
        $variables['title'] = isset($variables['title']) ? $variables['title'] : 'Тестовый проект';
        $variables['isAdmin'] = isset( $this->user['is_admin']) ? $this->user['is_admin'] : false;
        extract($variables);
        ob_start();
        include VIEW_PATH.'/header.php';
        include VIEW_PATH.'/'.$file;
        include VIEW_PATH . '/footer.php';
        $renderedView = ob_get_clean();
        return $renderedView;
    }

    function renderPartial($file, $variables = array()) {
        extract($variables);
        ob_start();
        include VIEW_PATH.'/'.$file;
        $renderedView = ob_get_clean();
        return $renderedView;
    }
    function checkSession(){
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }
}