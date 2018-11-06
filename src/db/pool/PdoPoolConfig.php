<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 9:49
 */

namespace rabbit\illuminate\db\pool;


use rabbit\pool\PoolProperties;

/**
 * Class PdoPoolConfig
 * @package rabbit\illuminate\db\pool
 */
class PdoPoolConfig extends PoolProperties
{
    /**
     * @param array $config
     */
    public function setUri(array $config)
    {
        $this->uri = $config;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}