<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 13:42
 */

namespace rabbit\illuminate\db;


use rabbit\exception\NotSupportedException;
use rabbit\illuminate\db\Processors\SqlServerProcessor;
use rabbit\pool\ConnectionInterface;
use rabbit\pool\PoolInterface;

/**
 * Class SqlServerConnection
 * @package rabbit\illuminate\db
 */
class SqlServerConnection extends \Illuminate\Database\SqlServerConnection implements ConnectionInterface
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
    public function __construct(PoolInterface $connectPool)
    {
        $this->lastTime = time();
        $this->connectionId = uniqid();
        $this->pool = $connectPool;
        $this->createConnection();
    }

    /**
     *
     */
    public function reconnect(): void
    {
        if (is_callable($this->reconnector)) {
            $this->pdo = call_user_func($this->reconnector, $this);
        }

        throw new \LogicException('Lost connection and no reconnector available.');
    }

    /**
     *
     */
    public function createConnection(): void
    {
        list($driver, $pdo, $database, $prefix, $config) = $this->pool->getPoolConfig()->getUri();
        parent::__construct($pdo, $database, $prefix, $config);
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return true;
    }

    /**
     * @param float|null $timeout
     * @return mixed|void
     * @throws NotSupportedException
     */
    public function receive(float $timeout = null)
    {
        throw new NotSupportedException('can not call ' . __METHOD__);
    }
}