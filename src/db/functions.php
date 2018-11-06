<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 9:25
 */

if (!function_exists('DbRelease')) {
    function DbRelease()
    {
        /** @var Manager $db */
        $db = \rabbit\core\ObjectFactory::get('db');
        $db->release();
    }
}