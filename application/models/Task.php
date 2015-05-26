<?php
namespace Models;

/**
 * Model for task table interaction
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: Models
 */

use \Library\DBHandler;

class Task
{
    /**
     * @var DBHandler instance
     */
    private $dbInstance;

    /**
     * constructor function
     */
    public function __construct()
    {
        $this->dbInstance = new DBHandler('arr');
    }

    /**
     * get all the tasks
     *
     * @param string $status
     * @return mixed
     */
    public function getTasks($status = '%')
    {
        $sanitizedVal = htmlentities($status);
        if ($sanitizedVal != $status) {
            throw new \InvalidArgumentException('Invalid Parameter', 403);
        }
        
        $sql = "SELECT ID, TASK, STATUS from tasks where status like :status order by status,id desc;";
        $query = $this->dbInstance->db->prepare($sql);
        $parameters = array(':status' => $status);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    /**
     * add new task
     *
     * @param string $task
     * @return mixed
     */
    public function addTask($task)
    {
        $sanitizedVal = htmlentities($task);
        
        if (empty($task) || $sanitizedVal != $task) {
            throw new \InvalidArgumentException('Invalid Parameter', 403);
        }
        
        $status = "0";
        $created = time();

        $sql = "INSERT INTO tasks(task,status,created_at)  VALUES (:task, :status, :created)";
        $query = $this->dbInstance->db->prepare($sql);
        $parameters = array(':task' => $task, ':status' => $status, ':created' => $created);

        $query->execute($parameters);

        return $this->dbInstance->db->lastInsertId('id');
    }

    /**
     * delete task
     *
     * @param int $taskId
     * @return mixed
     */
    public function deleteTask($taskId)
    {
        $sql = "DELETE FROM tasks WHERE id = :taskId";
        $query = $this->dbInstance->db->prepare($sql);
        $parameters = array(':taskId' => $taskId);

        $query->execute($parameters);

        return $query->rowCount();
    }

    /**
     * update task
     *
     * @param string $status
     * @param int $taskId
     * @return mixed
     */
    public function updateTask($status, $taskId)
    {
        $sql = "UPDATE tasks SET status = :status WHERE id = :taskId";
        $query = $this->dbInstance->db->prepare($sql);
        $parameters = array(':status' => $status, ':taskId' => $taskId);

        $query->execute($parameters);

        return $query->rowCount();
    }
} 