<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 19:52
 */

namespace rabbit\illuminate\db;


use rabbit\core\Context;
use rabbit\core\ContextTrait;

/**
 * Class DbContext
 * @package rabbit\illuminate\db
 */
class DbContext extends Context
{
    use ContextTrait;

    /**
     *
     */
    public function releaseContext(): void
    {
        foreach ($this->context as $name => $connection) {
            $connection->release();
            unset($this->context[$name]);
        }
    }
}