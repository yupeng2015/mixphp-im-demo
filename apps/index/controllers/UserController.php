<?php

namespace apps\index\controllers;

use apps\common\facades\PDO;
use apps\httpd\models\UserForm;
use apps\index\helpers\Utils;
use mix\facades\Request;
use mix\facades\Token;
use mix\http\Controller;

/**
 * API接口范例
 * @author 刘健 <coder.liu@qq.com>
 */
class UserController extends Controller
{

    // 新增用户
    public function actionCreate()
    {
        app()->response->format = \mix\http\Response::FORMAT_JSON;

        // 使用模型
        $model             = new UserForm();
        $model->attributes = Request::get() + Request::post();
        $model->setScenario('create');
        if (!$model->validate()) {
            return ['code' => 1, 'message' => 'FAILED', 'data' => $model->getErrors()];
        }

        // 执行保存数据库
        // ...

        // 响应
        return ['code' => 0, 'message' => 'OK'];
    }

    function actionGetUserInfo(){
        $user_ids = app()->request->get('user_ids');
        if(!empty($user_ids)){
            return $this->actionGetMeInfo();
        }
        $sql  = "SELECT * FROM `users` WHERE id IN (:id)";
        $rows = PDO::createCommand($sql)->bindParams([
            'id' => $user_ids,
        ])->queryOne();
        return Utils::successResponse(['code'=>1,'msg'=>'获取用户成功！','data'=>$rows]);
    }

    function actionGetMeInfo(){
        $userToken = Token::get('userinfo');
        return Utils::successResponse(['code'=>1,'msg'=>'获取用户成功！','data'=>$userToken]);
    }

    function actionGetMessageUserInfo(){
        $user_id = app()->request->get('user_id');
        $sql  = "SELECT * FROM `users` WHERE id IN (:id)";
        $rows = PDO::createCommand($sql)->bindParams([
            'id' => $user_id,
        ])->queryOne();
        $data = [
            'user' =>  $rows,
            'me'   =>  $userToken = Token::get('userinfo')
        ];

        return Utils::successResponse(['code'=>1,'msg'=>'获取用户成功！','data'=>$data]);
    }

    /**
     * 获取单聊的聊天记录
     * @param $data
     */
    public function actionGetSingleChatRecord(){
        $data = app()->request->get();
        $sql = 'select * from message WHERE im_type = :im_type AND (send_user_id IN (:send_user_id)) AND (receive_user_id IN (:receive_user_id))';
        $data = PDO::createCommand($sql)->bindParams([
            'im_type'      =>  'single',
            'send_user_id'      =>  [$data['send_user_id'],$data['receive_user_id']],
            'receive_user_id'   =>  [$data['send_user_id'],$data['receive_user_id']],
        ])->queryAll();
        return Utils::successResponse(['code'=>1,'msg'=>'获取聊天记录成功！','data'=>$data]);
    }



}
