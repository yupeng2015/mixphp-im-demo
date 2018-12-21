<?php

namespace apps\index\controllers;

use apps\common\facades\Redis;
use mix\facades\Token;
use mix\http\Controller;

/**
 * 默认控制器
 * @author 刘健 <coder.liu@qq.com>
 */
class IndexController extends Controller
{

    // 默认动作
    public function actionIndex()
    {
        //Token::set("a","a");
        app()->dump(Token::get('a'),true);
    }

}
