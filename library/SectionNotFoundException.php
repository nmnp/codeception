<?php
/**
 * Created by PhpStorm.
 * User: naresh
 * Date: 4/20/15
 * Time: 1:00 PM
 */

namespace library;


class SectionNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0,\Exception $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
} 