<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 14:03
 */

namespace rabbit\illuminate\db;

use rabbit\helper\CoroHelper;

/**
 * Class DatabaseManager
 * @package rabbit\illuminate\db
 */
class DatabaseManager extends \Illuminate\Database\DatabaseManager
{
    /** @var array */
    private $deferList = [];
    /**
     * Get a database connection instance.
     *
     * @param  string $name
     * @return \Illuminate\Database\Connection
     */
    public function connection($name = null)
    {
        [$database, $type] = $this->parseConnectionName($name);

        $name = $name ?: $database;

        // If we haven't created this connection, we'll create it based on the config
        // provided in the application. Once we've created the connections we will
        // set the "fetch mode" for PDO which determines the query return types.
        if (!DbContext::has($name)) {
            DbContext::set($name, $this->configure(
                $this->makeConnection($database), $type
            ));
            if (($cid = CoroHelper::getId()) !== -1 && !array_key_exists($cid, $this->deferList)) {
                defer(function () use ($cid) {
                    DbContext::release();
                    unset($this->deferList[$cid]);
                });
                $this->deferList[$cid] = true;
            }
        }

        return DbContext::get($name);
    }

    /**
     * @param null $name
     */
    public function purge($name = null)
    {
        $name = $name ?: $this->getDefaultConnection();

        $this->disconnect($name);

        DbContext::delete($name);
    }

    /**
     * @param null $name
     */
    public function disconnect($name = null)
    {
        if (DbContext::has($name = $name ?: $this->getDefaultConnection())) {
            DbContext::get($name)->disconnect();
        }
    }

    /**
     * @param null $name
     * @return \Illuminate\Database\Connection
     */
    public function reconnect($name = null)
    {
        $this->disconnect($name = $name ?: $this->getDefaultConnection());

        if (!DbContext::has($name)) {
            return $this->connection($name);
        }

        return $this->refreshPdoConnections($name);
    }

    /**
     * @param string $name
     * @return \Illuminate\Database\Connection
     */
    protected function refreshPdoConnections($name)
    {
        $fresh = $this->makeConnection($name);

        return DbContext::get($name)
            ->setPdo($fresh->getPdo())
            ->setReadPdo($fresh->getReadPdo());
    }

    /**
     * @return array
     */
    public function getConnections()
    {
        return DbContext::getAll();
    }

    /**
     *
     */
    public function release(): void
    {
        DbContext::release();
    }
}