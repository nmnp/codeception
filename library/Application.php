<?php
namespace Library;

/**
 * Generic helper class
 *
 * @createdOn: April 17, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: library
 */
use Symfony\Component\HttpFoundation\Request;

class Application
{
    /**
     * constructor function
     */
    public function __construct()
    {
        $router = new Router();
        $router->route();
    }
    /**
     * check if request if type of POST or not
     *
     * @return bool
     */
    public static function isPost()
    {
        $request = Request::createFromGlobals();
        if($request->isMethod('POST')){
            return true;
        }
        return false;
    }

    /**
     * get the POST data
     *
     * @return array|null
     */
    public static function getPost()
    {
        $request = Request::createFromGlobals();
        if($request->isMethod('POST')){
            return $request->request->all();
        }
        return null;
    }

    public static function getParam($key)
    {
        $request = Request::createFromGlobals();

        if($request->request->has($key)){
            return $request->request->get($key);
        }else if($request->query->has($key)){
            return $request->query->get($key);
        }else if($request->cookies->has($key)){
            return $request->cookies->get($key);
        }
        return null;
    }

    public static function getServerParam($key)
    {
        if(empty($key)){
            throw new \InvalidArgumentException('$key cannot be empty.');
        }
        $request = Request::createFromGlobals();
        if($request->server->has($key)){
            return $request->server->get($key);
        }

        return false;
    }

}