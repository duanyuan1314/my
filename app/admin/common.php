<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.hisiphp.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 橘子俊 <364666827@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
// 后台函数库
if (!function_exists('app_status')) {
    /**
     * 应用状态
     * @param string $v 状态值
     * @author 橘子俊 <364666827@qq.com>
     * @return array|null
     */
    function app_status($v = 0) {
        $arr = [];
        $arr[0] = '未安装';
        $arr[1] = '未启用';
        $arr[2] = '已启用';

        if (isset($arr[$v])) {
            return $arr[$v];
        }
        return '';
    }
    //post 请求数据
    function post_https($url,$data)
    { // 模拟提交数据函数
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, $data);   //请求的数据
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"msg_id":"id007"}');
        //执行请求
        $output = curl_exec($ch);
        curl_close($ch);
        return $output; // 返回数据，json格式
    }
}
