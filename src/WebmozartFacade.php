<?php

namespace UnicadeAssert;

class WebmozartFacade extends \Webmozart\Assert\Assert
{
    public function __construct()
    {
    }

    protected function fire($methodName, $args)
    {
        if (method_exists(__CLASS__, $methodName)) {
            return call_user_func_array(array(__CLASS__, $methodName), $args);
        }

        throw new \BadMethodCallException();
    }

    public static function __callStatic($methodName, $args)
    {
        return $this->fire($methodName, $args);
    }
}
