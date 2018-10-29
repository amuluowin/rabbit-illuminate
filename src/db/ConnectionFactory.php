<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:29
 */

namespace rabbit\illuminate\db;

use Illuminate\Database\Connection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\SqlServerConnection;
use rabbit\illuminate\db\pool\PdoPool;
use rabbit\pool\PoolInterface;

/**
 * Class ConnectionFactory
 * @package rabbit\illuminate\db
 */
class ConnectionFactory extends \Illuminate\Database\Connectors\ConnectionFactory
{
    /** @var PoolInterface[] */
    private $pool = [];

    /**
     * Create a new connection instance.
     *
     * @param  string $driver
     * @param  \PDO|\Closure $connection
     * @param  string $database
     * @param  string $prefix
     * @param  array $config
     * @return \Illuminate\Database\Connection
     *
     * @throws \InvalidArgumentException
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        if (isset($this->pool[$database])) {
            $this->pool[$database] = $config['pool'];
            unset($config['pool']);
        }

        switch ($driver) {
            case 'mysql':
                return $this->pool[$database]->getConnection();
            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);
            case 'sqlite':
                return new SQLiteConnection($connection, $database, $prefix, $config);
            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }

        throw new \InvalidArgumentException("Unsupported driver [{$driver}]");
    }
}