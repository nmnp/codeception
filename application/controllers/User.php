<?php
namespace Controllers;

/**
 * User controller
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: controllers
 */

use Library\ActionController;
use Library\Application;
use Library\Auth;
use \Models\User as UserModel;

class User extends ActionController
{

    /**
     * @var UserModel $userModel user model instance
     */
    private $userModel;

    public function init()
    {
        parent::init();
        $this->userModel = new UserModel();
    }

    /**
     * login action
     */
    public function login()
    {
        if (Application::isPost()) {
            try {
                $this->userModel->login(Application::getPost());
            }catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
        if (Auth::isAuthenticated()) {
            $this->router->redirect(array('controller' => 'task', 'action' => 'dashboard'));
        }
    }

    /**
     * logout action
     */
    public function logout()
    {
        $this->userModel->logout();
        $this->router->redirect(array('controller' => 'user', 'action' => 'login'));
    }
} 