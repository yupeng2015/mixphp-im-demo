<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17 0017
 * Time: 16:12
 */

namespace apps\index\helpers;


class Utils
{
    static function successResponse($data,$statusCode=200){
        return self::setResponse($data,$statusCode);
    }

    static function errorResponse($data,$statusCode=403){
        return self::setResponse($data,$statusCode);
    }

    static function setResponse($data,$statusCode=200){
        app()->response->statusCode = $statusCode;
        return $data;
    }

    static function returnFormat($code=1,$msg='',$statusCode=200,$data=[]){
        return self::setResponse(['code'=>$code,'msg'=>$msg,'data'=>$data],$statusCode);
    }
}