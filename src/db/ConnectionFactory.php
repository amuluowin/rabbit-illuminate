<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:29
 */

namespace rabbit\illuminate\db;

use Illuminate\Database\Connection;
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

        $config['pool']->getPoolConfig()->setUri([$driver, $connection, $database, $prefix, $config]);
        $config['pool']->getPoolConfig()->setName($config['name']);
        return $config['pool']->getConnection();
    }
}