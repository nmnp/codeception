<?php
namespace Library;

/**
 * View Class to render view 
 *
 * @createdOn April 23, 2015
 * @author Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package CodeceptionDemo
 * @subPackage Library
 */

class View
{
    /**
     * @var bool $disableView disable views for ajax requests
     */
    public $disableView = false;

    /**
     * include template file
     */
    public function render()
    {
        if(PHP_SAPI == 'cli'){
            return "view cannot be rendered in CLI mode";
        }
        if(!$this->disableView){
            require APP . "views/{$this->controller}/{$this->action}.phtml";
        }
    }
    
    public function setJsonContent($data)
    {
        $this->disableView = true;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
} 