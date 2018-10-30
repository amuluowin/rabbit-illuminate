<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 9:25
 */

if (!function_exists('dbRelease')) {
    function DbRelease(\Illuminate\Support\Collection $collection = null): ?\Illuminate\Support\Collection
    {
        /** @var Manager $db */
        $db = \rabbit\core\ObjectFactory::get('db');
        $db->release();
        return $collection;
    }
}