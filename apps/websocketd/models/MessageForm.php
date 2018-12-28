<?php

namespace apps\websocketd\models;

use mix\validators\Validator;

/**
 * Message 表单模型类
 * @author 刘健 <coder.liu@qq.com>
 */
class MessageForm extends Validator
{

    public $receive_user_id;
    public $content;

    // 规则
    public function rules()
    {
        return [
            'receive_user_id'  => ['integer', 'unsigned' => true, 'minLength' => 1, 'maxLength' => 10],
            'content' => ['string', 'minLength' => 1, 'maxLength' => 300],
        ];
    }

    // 场景
    public function scenarios()
    {
        return [
            'actionEmit' => ['required' => ['receive_user_id', 'content']],
        ];
    }

}
