<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14 0014
 * Time: 11:27
 */

namespace apps\index\controllers;


use mix\facades\PDO;
use mix\http\Request;

class PublicController extends BaseController{
    public function actionIndex(){
        return 'this is index';
    }

    public function actionPostRegister(){
        $requestData = app()->request->post();

        $userInsertData = [
            'account'       => $requestData['account'],
            'password'      => md5($requestData['password']),
        ];
        $success = PDO::insert('users', $userInsertData)->execute();
// 获得刚插入数据的id
        $insertId = PDO::getLastInsertId();
        return ['errcode' => 0, 'errmsg' => 'ok','res'=>['lastId'=>$insertId]];

    }

}