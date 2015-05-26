<?php

namespace Controllers;

/**
 * Task controller
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: controllers
 */

use Library\ActionController;
use \Models\Task as TaskModel;

class Task extends ActionController
{

    /**
     * @var TaskModel $taskModel task model instance
     */
    private $taskModel;

    /**
     * constructor function
     */
    public function init()
    {
        parent::init();
        $this->taskModel = new TaskModel();
    }

    /**
     * task dashboard action
     */
    public function dashboard()
    {
    }

    /**
     * get all the tasks
     */
    public function getTask()
    {
        $status = !empty(\Library\Application::getParam('status')) ? \Library\Application::getParam('status') : '%';
        $data = $this->taskModel->getTasks($status);
        $this->view->setJsonContent($data);
    }

    /**
     * add new task
     */
    public function addTask()
    {

        $task = \Library\Application::getParam('task');
        if (!empty($task)) {
            $data = $this->taskModel->addTask($task);
            $this->view->setJsonContent($data);
        }
    }

    /**
     * delete a task
     */
    public function deleteTask()
    {
        $taskID = \Library\Application::getParam('taskID');
        if (!empty($taskID)) {
            $data = $this->taskModel->deleteTask($taskID);
            $this->view->setJsonContent($data);
        }
    }

    /**
     * update a task
     */
    public function updateTask()
    {
        $status = \Library\Application::getParam('status');
        $taskID = \Library\Application::getParam('taskID');
        if (isset($status) && isset($taskID)) {
            $data = $this->taskModel->updateTask($status, $taskID);
            $this->view->setJsonContent($data);
        }
    }

}
