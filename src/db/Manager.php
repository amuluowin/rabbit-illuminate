<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:27
 */

namespace rabbit\illuminate\db;

use Illuminate\Database\DatabaseManager;

/**
 * Class Manager
 * @package rabbit\illuminate\db
 */
class Manager extends \Illuminate\Database\Capsule\Manager
{
    /**
     * Build the database manager instance.
     *
     * @return void
     */
    protected function setupManager()
    {
        $factory = new ConnectionFactory($this->container);

        $this->manager = new DatabaseManager($this->container, $factory);
    }
}