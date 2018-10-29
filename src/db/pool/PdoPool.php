<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:36
 */

namespace rabbit\illuminate\db\pool;


use rabbit\illuminate\db\MySqlConnection;
use rabbit\pool\ConnectionInterface;
use rabbit\pool\ConnectionPool;

/**
 * Class PdoPool
 * @package rabbit\illuminate\db\pool
 */
class PdoPool extends ConnectionPool
{
    public function createConnection(array $config = []): ConnectionInterface
    {
        list($connection, $database, $prefix, $config) = $config;
        return new MySqlConnection($this, $connection, $database, $prefix, $config);
    }

}