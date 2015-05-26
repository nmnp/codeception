<?php
/**
 * Invalid Section Exception class
 * User: naresh
 * Date: 4/20/15
 * Time: 12:53 PM
 */

namespace library;


class InvalidSectionException extends \Exception
{

    public function __construct($message = "", $code = 0,\Exception $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
} 