<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:59
 */

namespace rabbit\illuminate\db;

use rabbit\exception\NotSupportedException;
use rabbit\pool\ConnectionInterface;
use rabbit\pool\PoolInterface;

/**
 * Class MySqlConnection
 * @package rabbit\illuminate\db
 */
class MySqlConnection extends \Illuminate\Database\MySqlConnection implements ConnectionInterface
{
    use ConnectionTrait;

    /**
     * MySqlConnection constructor.
     * @param PoolInterface $connectPool
     * @param $pdo
     * @param string $database
     * @param string $tablePrefix
     * @param array $config
     */
    public function __construct(PoolInterface $connectPool, $pdo, string $database = '', string $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);
        $this->lastTime = time();
        $this->connectionId = uniqid();
        $this->pool = $connectPool;
    }

    public function createConnection(): void
    {
        throw new NotSupportedException('can not call '__METHOD__);
    }

    public function check(): bool
    {
        return true;
    }

    public function receive(float $timeout = null)
    {
        throw new NotSupportedException('can not call '__METHOD__);
    }
}