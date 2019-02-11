<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 16:36
 */

namespace apps\index\middleware;


class PublicMiddleware
{
    public function handle($callable, \Closure $next)
    {
        app()->response->setHeader('Access-Control-Allow-Headers','access-token');
        app()->response->setHeader('Content-Type', 'application/json;charset=utf-8');
        app()->response->setHeader('Access-Control-Allow-Origin', '*');
        app()->response->setHeader('Access-Control-Allow-Methods', 'POST,GET,HEAD');
        // 添加中间件执行代码
        list($controller, $action) = $callable;
        // ...
        // 执行下一个中间件
        return $next();
    }
}