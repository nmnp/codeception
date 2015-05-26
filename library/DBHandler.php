<?php
namespace Library;

/**
 * Database handler class
 *
 * @createdOn: April 16, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: library
 */

class DBHandler
{
    /**
     * @var object|null $config database configurations object
     */
    private $config = null;

    /**
     * @var string|null $username database username
     */
    private $username = null;

    /**
     * @var string|null $password database password
     */
    private $password = null;

    /**
     * @var string|null $databaseName database name
     */
    private $databaseName = null;

    /**
     * @var string|null $charset charset
     */
    private $charset = null;

    /**
     * @var string|null $databaseType database type
     */
    private $databaseType = null;

    /**
     * @var string|null $host database host
     */
    private $host = null;

    /**
     * @var object|null $db PDO instance
     */
    public $db = null;

    /**
     * @var int $fetchMode fetch mode
     */
    private $fetchMode;

    /**
     * constructor function
     *
     * @param string|null $fetchMode fetch mode
     */
    public function __construct($fetchMode = null)
    {
        $this->fetchMode = (strstr($fetchMode,'arr')) ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;
        $this->getDatabaseConfig();
        $this->openDatabaseConnection();
    }

    /**
     * get database config
     *
     * @throws \Exception
     */
    private function getDatabaseConfig()
    {
        $configObj = new ParseConfig();
        $this->config = $configObj->getConfigSection("db");
        $this->setCredentials();
    }

    /**
     * instantiate PDO instance
     */
    private function openDatabaseConnection()
    {
        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => $this->fetchMode, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING);

        $this->db = new \PDO($this->databaseType . ':host=' . $this->host . ';dbname=' . $this->databaseName . ';charset=' . $this->charset, $this->username, $this->password, $options);
    }

    /**
     * set database credentials
     */
    private function setCredentials()
    {
        $this->setCharset();
        $this->setDatabaseName();
        $this->setDatabaseType();
        $this->setHost();
        $this->setUserName();
        $this->setPassword();
    }

    /**
     * set username
     */
    private function setUserName()
    {
        $this->username = $this->config['username'];
    }

    /**
     * set password
     */
    private function setPassword()
    {
        $this->password = $this->config['password'];
    }

    /**
     * set database name
     */
    private function setDatabaseName()
    {
        $this->databaseName = $this->config['dbname'];
    }

    /**
     * set charset
     */
    private function setCharset()
    {
        $this->charset = $this->config['charset'];
    }

    /**
     * set database type
     */
    private function setDatabaseType()
    {
        $this->databaseType = $this->config['type'];
    }

    /**
     * set database host
     */
    private function setHost()
    {
        $this->host = $this->config['host'];
    }
} 