<?php

namespace apps\httpd\middleware;

/**
 * 前置中间件
 * @author 刘健 <coder.liu@qq.com>
 */
class BeforeMiddleware
{

    public function handle($callable, \Closure $next)
    {
        app()->response->setHeader('Content-Type', 'application/json;charset=utf-8');
        app()->response->setHeader('Access-Control-Allow-Origin', '*');
        app()->response->setHeader('Access-Control-Allow-Methods', 'POST,GET');
        // 添加中间件执行代码
        list($controller, $action) = $callable;
        // ...
        // 执行下一个中间件
        return $next();
    }

}
