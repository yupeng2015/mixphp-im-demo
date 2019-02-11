<?php

namespace apps\index\middleware;

use apps\index\helpers\Utils;
use mix\facades\Token;

/**
 * 前置中间件
 * @author 刘健 <coder.liu@qq.com>
 */
class BeforeMiddleware
{

    public function handle($callable, \Closure $next)
    {
        //app()->response->setHeader('Content-Type', 'application/json;charset=utf-8');
        app()->response->setHeader('Access-Control-Allow-Origin', '*');
        app()->response->setHeader('Access-Control-Allow-Methods', 'POST,GET,HEAD');
        app()->response->setHeader('Access-Control-Allow-Headers','access-token');
        if(app()->request->method() != 'OPTIONS'){
            // 添加中间件执行代码
            $userinfo = Token::get('userinfo');
            if (empty($userinfo)) {
                // 返回错误码
                return Utils::returnFormat(0,'登录验证失败！',401);
            }
        }
        // 添加中间件执行代码
        list($controller, $action) = $callable;
        // ...
        // 执行下一个中间件
        return $next();

    }

}
