<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:27
 */

namespace rabbit\illuminate\db;
use Illuminate\Container\Container;

/**
 * Class Manager
 * @package rabbit\illuminate\db
 */
class Manager extends \Illuminate\Database\Capsule\Manager
{
    /**
     * Create a new database capsule manager.
     *
     * @param  \Illuminate\Container\Container|null $container
     * @return void
     */
    public function __construct(Container $container = null)
    {
        parent::__construct($container);

        $this->setAsGlobal();

        $this->bootEloquent();
    }

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

    /**
     *
     */
    public function release(): void
    {
        $this->getDatabaseManager()->release();
    }
}