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

    function userMsg($userid)
    {
        if(!$userid){
            return 'need userid';
        }
        $token = md5($userid.'changyou');
        $data['userid'] = $userid;
        $data['token'] = $token;
        $url = "http://playgame.hnlfcywlkj.com/Home/Api/userMsg/";
        $temp = post_https($url,$data);
        $ret = json_decode($temp,true);
       
        if($ret['code']==1){
            $ar =$ret['data'];
            if($ret['code']=='1'){
                $ou = db('user');
                $arr['grade']=$ar['grade'];
                /* $arr['haschip']=$ar['haschip']; */
                $arr['chip']=$ar['chip'];
                $arr['exp']=$ar['experience'];
                $flag = $ou->where('id',$userid)->update($arr);
                if($flag){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                    return FALSE;
            }
        }else{
             return FALSE;
        }
    }
    function aliyun($info,$way='',$isunlink=false,$bucket=""){

        vendor('aliyun.autoload');

        $accessKeyId = "LTAIQ77LlwoPvpxF";  //去阿里云后台获取秘钥//LTAIWajudzuWna6P

        $accessKeySecret = "J48IolW7etMSm8r0LoEMmYbS2BSlxp";  //去阿里云后台获取秘钥//WN4m7lVnEeH0Cr6AEZwOAghUlmbIFz

        $endpoint = "oss-cn-beijing.aliyuncs.com"; //你的阿里云OSS地址 //oss-cn-hangzhou.aliyuncs.com

        //oss-cn-beijing.aliyuncs.com

        $bucket ="lfcy";

        $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
        
        // 判断bucketname是否存在，不存在就去创建

        if( !$ossClient->doesBucketExist($bucket)){

             $ossClient->createBucket($bucket);

        }
        $way=empty($way)?$bucket:$way;
        $object = $way.'/'.$info;
        $file = 'public/uploads/'.$info; //文件路径，必须是本地的。
        try{
            $ossClient->uploadFile($bucket,$object,$file);
            unlink($file);
        }catch (OssException $e){
            $e->getErrorMessage();
        }
        $oss="";
        return $oss.$object;
    }

    /*
    *碎片兑换扣除碎片接口
    */

    function subhaschip($userid,$cash)
    {
        if(!$userid){
            return 'need userid';
        }
        $data['userid'] = $userid;
        $data['cash'] = $cash;
        $url = "http://playgame.hnlfcywlkj.com/Home/Api/subhasChip/";
        $temp = post_https($url,$data);
        $ret = json_decode($temp,true);
        if($ret['code'] =='404'){
            return '0';
        }else if($ret['code']=='0'){
            return '0';
        }else if($ret['code']=='1'){
            return '1';
        }
    }

    /*
    *chiplog
    *type =0 减少 =1 增加 =2充值
    *status =0失败 =1 成功
    */
    function add_chip_log($userid,$chip,$ordernum,$type,$beizhu,$gamename)
    {

        $data=array();
        $data['userid'] = $userid;
        $data['chip'] = $chip;
        $data['orderid'] = $ordernum;
        $data['type'] = $type;
        $data['beizhu'] = $beizhu;
        $data['addtime'] = time();
        $data['gamename'] = $gamename;
        $data['status'] = 1;
        $ou = db('ChipLog');
        $flag = $ou->insert($data);
        if($flag){
            return 1;
        }else{
            return 0;
        }
    }

    /*游戏中心更新token*/
    function set_game_token($datas)
    {
        $token = $datas['access_token'];
        $expires_in = $datas['expires_in'];
        $url = YILIAN_ADMIN."open/v1/api.php?c=user/profile&access_token={$token}";
        $arr = get_request($url);
        $userarr = json_decode($arr, TRUE);
        $ar = $userarr['data']; //用户信息
        if($ar)
            {
                    $user_id = $ar['user_id'];
                    $ou = db('user');
                    $oar = $ou->where('id', $user_id)->find();
                    $time = time() + $expires_in;
                    $data['id'] = $ar['user_id'];
                    $data['phone'] = $ar['phone'];
                    $data['name'] = $ar['name'];
                    $data['sex'] = $ar['sex'];
                    $data['user_type'] = 2;
                    $data['avatar'] = "https://img.yilian.lefenmall.com/".$ar['photo'];
                    $data['rank'] = $ar['rank'];
                    $data['referrer'] = $ar['referrer'];
                    $data['user_status'] = $ar['status'];
                    $data['game_token'] = $token;
                    $data['game_refresh_token'] = $datas['refresh_token'];
                    $data['game_token_time'] = date('Y-m-d H:i:s', $time);
                    if(!$oar) 
                    {
                        $res = $ou->insert($data);
                    } 
                    else 
                    {
                        $res = $ou->update($data);
                    }
                    session('userid',$det['user_id']);
            	    session('name',$ar['name']);
                    return TRUE;
            }
            else
            {
                return FALSE;
            }
    }
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
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        //执行请求
        $output = curl_exec($ch);
        curl_close($ch);
        return $output; // 返回数据，json格式
    }
    function curl_post_https($url, $data)
    {  
        // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_USERPWD, "game_center:game_211856");
        $tmpInfo = curl_exec($curl); // 执行操作
        if(curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话

        return $tmpInfo; // 返回数据，json格式
    }
    function get_request($url)
    {
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $url);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        $result = curl_exec($curlObj);
        curl_close($curlObj);
        return $result;
    }
    function curlPost($url,$postFields){
        $postFields = json_encode($postFields);
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url ); 
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'
            )
        );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,1); 
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec ( $ch );
        if (false == $ret) 
        {
            $result = curl_error(  $ch);
        } 
        else 
        {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) 
            {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            }
            else 
            {
                $result = $ret;
            }
        }
        curl_close ( $ch );
        return $result;
    }
        /*
        *短信接口
        */
    function sendSMS($mobile,$msg,$needstatus = 'true') {
            header("Content-type:text/html; charset=UTF-8");
            //创蓝接口参数
            $postArr = array (
                'account'  => 'N034120_N2405732',
                'password' => 'PT5F6iZdJC9c77',
                'msg' => urlencode($msg),
                'phone' => $mobile,
                'report' => $needstatus
            );
            $url = "http://smssh1.253.com/msg/send/json";
            $result = curlPost($url,$postArr);
            return $result;
    }
}
