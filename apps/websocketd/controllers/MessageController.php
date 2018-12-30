<?php

namespace apps\websocketd\controllers;

use apps\common\facades\PDO;
use apps\index\helpers\Utils;
use mix\facades\Redis;
use mix\websocket\Controller;
use apps\websocketd\models\MessageForm;

/**
 * 消息控制器
 * @author 刘健 <coder.liu@qq.com>
 */
class MessageController extends Controller
{

    // 加入房间
    public function actionEmit($data, $userinfo)
    {
        // 使用模型
        $model             = new MessageForm();
        $model->attributes = $data;
        $model->setScenario('actionEmit');
        // 验证失败
        if (!$model->validate()) {
            return;
        }
        $dataJson = json_encode($data,JSON_UNESCAPED_UNICODE);
        // 通过消息队列给指定用户id发消息
        Redis::publish('emit_to_' . $model->receive_user_id, $dataJson);
        $success = PDO::insert('message', $data)->execute();
    }

    public function actionAddMessage($data, $userinfo){
        $success = PDO::insert('message', $data)->execute();
    }



}
