<?php
if (! function_exists('p')) {
    /**
     * 输出各种类型的数据到客户端，调试程序时打印数据使用。
     * @param    mixed    参数：可以是一个或多个任意变量或值
     */
    function p() {
        $args = func_get_args();  //获取多个参数
        /*	if(count($args)<1){
                Debug::addmsg("<font color='red'>必须为p()函数提供参数!");
                return;
            }*/
        echo '<div style="width:100%;text-align:left"><pre>';
        //多个参数循环输出
        foreach ($args as $arg) {
            if (is_array($arg)) {
                print_r($arg);
                echo '<br>';
            } else if (is_string($arg)) {
                echo $arg . '<br>';
            } else {
                app()->dump($arg,true);
                echo '<br>';
            }
        }
        echo '</pre></div>';
    }
}