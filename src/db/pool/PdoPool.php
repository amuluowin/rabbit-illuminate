<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:36
 */

namespace rabbit\illuminate\db\pool;


use rabbit\illuminate\db\MySqlConnection;
use rabbit\illuminate\db\PostgresConnection;
use rabbit\illuminate\db\SQLiteConnection;
use rabbit\illuminate\db\SqlServerConnection;
use rabbit\pool\ConnectionInterface;
use rabbit\pool\ConnectionPool;

/**
 * Class PdoPool
 * @package rabbit\illuminate\db\pool
 */
class PdoPool extends ConnectionPool
{
    public function createConnection(): ConnectionInterface
    {
        list($driver, $pdo, $database, $prefix, $config) = $this->poolConfig->getUri();
        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($this);
            case 'pgsql':
                return new PostgresConnection($this);
            case 'sqlite':
                return new SQLiteConnection($this);
            case 'sqlsrv':
                return new SqlServerConnection($this);
        }
        throw new \InvalidArgumentException("Unsupported driver [{$driver}]");

    }

}