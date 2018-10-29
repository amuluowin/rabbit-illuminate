<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 14:03
 */

namespace rabbit\illuminate\db;

/**
 * Class DatabaseManager
 * @package rabbit\illuminate\db
 */
class DatabaseManager extends \Illuminate\Database\DatabaseManager
{
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
        }

        return DbContext::get($name);
    }

    /**
     *
     */
    public function release(): void
    {
        DbContext::release();
    }
}