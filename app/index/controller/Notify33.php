<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
/*
*充值页面
*/
class Notify extends Common
{
	public function zhifubao()
    {
        header("Content-type:text/html;charset=utf-8");
        include "static/al/config.php";
        include "static/al/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
        include "static/al/wappay/service/AlipayTradeService.php";
        include "static/al/aop/AopClient.php";
        $aop = new \AopClient;
        $post = $_POST;
        $aop->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAytTlHgBI/G9ZwOVbgZZt28HZ59LcFMjDH+eDvtkoYHt5Lp+BRt1+Xtx+4fj/9f2OiH79sEkOI3MSjZ3Q6gT3Pk7U1Wn1AnbfKrQE4iMRIZ/IWnyE4kk7tWVfiBsvEzNiwhq7D0jd6FociwFHYQiD/Keo8L5Yngfi4BN5D48igC4j1N896s4Y4s3QONVM9fs3C5nNzXVd4fY3Mkn6DHT2PU7xDeBbWEqCD1FgeTTk/dS3XnGh50q8pBxh4Cpsz0k3/1jT55Dz5xWSuQBYkphvfNAybvqfw1LuxQEQbMK19f0oLGZw8oLSwtzJP/jxntwOHnhbEMcz78yCyjEwl0kpeQIDAQAB";
        $flag = $aop->rsaCheckV1($post, NULL, "RSA2");
        $trade_status=$post['trade_status'];
        if($flag)
        {
            if($trade_status=='TRADE_SUCCESS' || $trade_status=='TRADE_FINISHED')
            {
                 $out_trade_no=$post["out_trade_no"]; //订单号  
				 $result = $this->order_set($out_trade_no);
                 if($result)
                 {
                    echo 'success';
                 }
            }
            
        }
        else
        {
             echo "error";
        }
    }
    Public function weixin()
    {
        include "static/wxpay/WxPayPubHelper.php";
        include "static/wxpay/log_.php";
        $wxConfig=array(
            "appid"=>"wxee893e7f011a305c",
            "appsecret"=>"d0faa15ea3d5fdeba879310241c805d6",
            "mchid"=>"1490541502",
            "key"=>"ba42905d18e7da6032b82b4260596dbf"
         );
        //使用通用通知接口
        $notify = new \Notify_pub($wxConfig["appid"], $wxConfig["appsecret"], $wxConfig["mchid"], $wxConfig["key"]);
        //存储微信的回调
        //$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $xml = file_get_contents("php://input");
        $notify->saveData($xml);
        if ($notify->checkSign() == FALSE) 
        {
            $notify->setReturnParameter("return_code", "FAIL"); //返回状态码
            $notify->setReturnParameter("return_msg", "签名失败"); //返回信息
        }
        else
        {
            $notify->setReturnParameter("return_code", "SUCCESS"); //设置返回码
        }
        /* //以log文件形式记录回调信息
        $log_ = new \Log_();
        $log_name = "serve.log";
        $log_->log_result($log_name, "【接收到的notify通知】:\n" . $xml . "\n");*/
        $ressss = $notify->checkSign();
        if ($notify->checkSign() == TRUE) 
        {
            if ($notify->data["return_code"] == "FAIL") 
            {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name, "【通信出错】:\n" . $xml . "\n");
            } 
            elseif ($notify->data["result_code"] == "FAIL") 
            {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name, "【业务出错】:\n" . $xml . "\n");
            } 
            elseif ($notify->data["result_code"] == "SUCCESS" && $notify->data["return_code"] == "SUCCESS") 
            {
                 //此处应该更新一下订单状态，商户自行增删操作
                 $xml = $notify->xmlToArray($xml);
                 // 商户订单号
                 $out_trade_no = $xml ['out_trade_no'];
                 $total_fee = $xml ['total_fee']*0.01;
                 /*执行操作方法*/
                 $result = $this->wxorder_set($out_trade_no);
                 if($result)
                 {
                    echo "success";
                 }
            }
        }
    }
	private function order_set($data)
    {
       			/*开启事物*/
				$arr = db('lebeans_log')->where('orderid',$data)->find();
                if($arr['status'] == 0)
                {
                    Db::startTrans();
                    $money   = $arr['num']; /*充值金额*/
                    $user_id = $arr['user_id'];
                    $res = db('lebeans_log')->where('orderid',$data)->setField('status',1);
                    $time =date('Y-m-d H:i:s',time());
                    db('lebeans_log')->where('orderid',$data)->setField('create_time',$time);
                    if(!$res)
                    {
                         Db::rollback();
                         return false;
                    }
					$re = db('user')->where('id',$user_id)->setInc('jifen',$money);
					$dataArr['userid'] = $user_id;
					$dataArr['jifen'] = $money;
					$dataArr['orderid'] = $arr['orderid'];
					$dataArr['type'] = 2;
					$dataArr['beizhu'] = '平台支付宝充值';
					$ress = db('jifen_log')->insert($dataArr);
                    if(!$re)
                    {
                         Db::rollback();
                         return false;
                    }
                    Db::commit();
                    return true;
                }
                return true; 
    }
    private function wxorder_set($data)
    {
       			/*开启事物*/
				$arr = db('lebeans_log')->where('orderid',$data)->find();
                if($arr['status'] == 0)
                {
                    Db::startTrans();
                    $money   = $arr['num']; /*充值金额*/
                    $user_id = $arr['user_id'];
                    $res = db('lebeans_log')->where('orderid',$data)->setField('status',1);
                    $time =date('Y-m-d H:i:s',time());
                    db('lebeans_log')->where('orderid',$data)->setField('create_time',$time);
                    if(!$res)
                    {
                         Db::rollback();
                         return false;
                    }
					$re = db('user')->where('id',$user_id)->setInc('jifen',$money);
					$dataArr['userid'] = $user_id;
					$dataArr['jifen'] = $money;
					$dataArr['orderid'] = $arr['orderid'];
					$dataArr['type'] = 1;
					$dataArr['beizhu'] = '微信充值';
					$ress = db('jifen_log')->insert($dataArr);
                    if(!$re)
                    {
                         Db::rollback();
                         return false;
                    }
                    Db::commit();
                    return true;
                }
                return true; 
    }

}