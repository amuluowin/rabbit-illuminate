<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 19:52
 */

namespace rabbit\illuminate\db;


use Illuminate\Database\Connection;
use rabbit\helper\CoroHelper;

/**
 * Class DbContext
 * @package rabbit\illuminate\db
 */
class DbContext
{
    /**
     * @var array
     */
    private static $context = [];

    /**
     * @return array|null
     */
    public static function getAll(): ?array
    {
        return self::$context[CoroHelper::getId()];
    }

    /**
     * @param array $config
     */
    public static function setAll($config = []): void
    {
        foreach ($config as $name => $value) {
            self::set($name, $value);
        }
    }

    /**
     * @param string $name
     * @return null
     */
    public static function get(string $name): Connection
    {
        $id = CoroHelper::getId();
        return self::$context[$id][$name];
    }

    /**
     * @param string $name
     * @param $value
     */
    public static function set(string $name, Connection $value): void
    {
        self::$context[CoroHelper::getId()][$name] = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return isset(self::$context[CoroHelper::getId()][$name]);
    }

    /**
     *
     */
    public static function release(): void
    {
        foreach (self::$context[CoroHelper::getId()] as $name => $connection) {
            $connection->release();
        }
        unset(self::$context[CoroHelper::getId()]);
    }
}