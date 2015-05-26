<?php
namespace Models;

/**
 * Class to handle login/logout operation
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: models
 */

use Library\DBHandler;
use Library\Auth;

class User
{
    /**
     * @var DBHandler instance
     */
    private $dbInstance;
    /**
     * @var string|null $username username of the currently logged in user
     */
    private $username;
    /**
     * @var string|null $name name of the currently logged in user
     */
    private $name;

    /**
     * constructor function
     */
    public function __construct()
    {
        $this->dbInstance = new DBHandler();
    }

    /**
     * magic get function
     *
     * @param string $property
     * @throws \Exception
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception($property . " property dosen't exist in " . __CLASS__);
    }

    /**
     * log in into to system with credentials
     *
     * @param array $postData
     * @throws \Exception
     */
    public function login(Array $postData)
    {
        if (!Auth::isAuthenticated()) {

            $userName = !empty($postData['username']) ? $postData['username'] : null;
            $password = !empty($postData['password']) ? $postData['password'] : null;

            if (empty($userName)) {
                throw new \Exception('Invalid Username');
            }
            if (empty($password)) {
                throw new \Exception('Invalid Password');
            }

            $userRow = $this->checkUserCredentails($userName, $password);
            $this->setSessionData($userRow);
        }
        $this->setCredentials();
    }

    /**
     * clear session data upon user log out
     */
    public function logout()
    {
        $_SESSION['is_authenticated'] = false;
        $_SESSION['name'] = null;
        $_SESSION['username'] = null;
    }

    /**
     * check users credentail in the database
     *
     * @param string $userName
     * @param string $password
     * @return mixed
     */
    private function checkUserCredentails($userName, $password)
    {
        $sql = "SELECT * FROM users where username = :username and password = :password;";
        $query = $this->dbInstance->db->prepare($sql);
        $parameters = array(':username' => $userName, ':password' => md5($password));

        $query->execute($parameters);

        return $query->fetch();
    }

    /**
     * set session data for currently logged in user
     *
     * @param object $data
     * @throws \Exception
     */
    private function setSessionData($data)
    {
        if (empty($data)) {
            throw new \Exception('Invalid Username or Password');
        }
        $_SESSION['is_authenticated'] = true;
        $_SESSION['name'] = $data->name;
        $_SESSION['username'] = $data->username;
    }

    /**
     * set class variables for logged in user
     */
    private function setCredentials()
    {
        $this->name = $_SESSION['name'];
        $this->username = $_SESSION['username'];
    }
} 