<?php
namespace Library;

/**
 * Auth Helper class
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: library
 */

class Auth
{
    /**
     * check if user is authenticated or not
     *
     * @return bool
     */
    public static function isAuthenticated()
    {
        if(!empty($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true){
            return true;
        }
        return false;
    }

    /**
     * get the name of logged in user
     *
     * @return string|bool
     */
    public static function getName()
    {
        if(self::isAuthenticated()){
            return $_SESSION['name'];
        }
        return false;
    }

    /**
     * get username of the logged in user
     *
     * @return string|bool
     */
    public static function getUsername()
    {
        if(self::isAuthenticated()){
            return $_SESSION['username'];
        }
        return false;
    }
} 