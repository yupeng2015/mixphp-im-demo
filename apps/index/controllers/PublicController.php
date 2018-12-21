<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14 0014
 * Time: 11:27
 */

namespace apps\index\controllers;


use apps\common\facades\Redis;
use apps\index\helpers\Utils;
use mix\facades\PDO;
use mix\facades\Token;
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
            'openid'        =>  time()."soen".rand()
        ];
        $success = PDO::insert('users', $userInsertData)->execute();
// 获得刚插入数据的id
        $insertId = PDO::getLastInsertId();
        return ['errcode' => 0, 'errmsg' => 'ok','res'=>['lastId'=>$insertId]];
    }

    public function actionPostLogin(){
        $account = app()->request->post('account');
        if(!isset($account)){
            return Utils::errorResponse(['code'=>0,'msg'=>'账号不能为空！']);
        }
        $password = app()->request->post('password');
        if(!isset($password)){
            return Utils::errorResponse(['code'=>0,'msg'=>'密码不能为空！']);
        }
        $sql = "SELECT * FROM `users` WHERE account = :account AND password = :password";
        $row = PDO::createCommand($sql)->bindParams([
            'account'  => $account,
            'password' => md5($password),
        ])->queryOne();
        if(!$row){
            return Utils::errorResponse(['code'=>0,'msg'=>'账号或密码错误！']);
        }

        Token::createTokenId();
        // 保存会话信息
        $userinfo = [
            'id'      => $row['id'],
            'openid'   => $row['openid'],
            'account' => $row['account'],
        ];
        Token::set('userinfo', $userinfo);
        // 设置唯一索引
        Token::setUniqueIndex($userinfo['openid']);
        $accessToken = Token::getTokenId();

        // 响应
        return Utils::successResponse([
            'code'=>1,
            'access_token' => $accessToken,
            'expires_in'   => app()->token->expiresIn,
            'msg'=>'登录成功！',
            'data'=>$row
        ]);
    }

    public function actionGetUserInfo(){

    }

    public function actionGetUserList(){
        $userToken = Token::get('userinfo');
        $rows = PDO::createCommand("SELECT * FROM `users` WHERE id <> :id")
            ->bindParams(['id'=>$userToken['id']])
            ->queryAll();
        //$a = \Mix::app()->request->header('access-token');
        return ['code'=>1,'msg'=>'','data'=>$rows];
    }

}