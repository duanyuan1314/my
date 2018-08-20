<?php
namespace app\index\controller;
use think\Db;
use think\Request;
use think\Controller;
/*
*接口控制器
*/
class Wappay extends Controller{
        public function zhifupay()
        {
            header("Content-type:text/html;charset=utf-8");
            include "static/al/config.php";
            include "static/al/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
            include "static/al/wappay/service/AlipayTradeService.php";
            //接收订单编号
            $order_id=input('get.orderid');
            //根据订单编号查询价格
            //如果是续费或者是押金，查询交费金额
            if (!empty($order_id))
            {
                    $arr = db('lebeans_log')->where('orderid',$order_id)->find();
                    //商户订单号，商户网站订单系统中唯一订单号，必填
                    $out_trade_no = $order_id;
                    //订单名称，必填
                    $subject = "乐豆充值";
                    //付款金额，必填
                    $total_amount = $arr['money'];
                   /*  $total_amount =0.01; */
                    //商品描述，可空
                    $body = "";
                    //超时时间
                    $timeout_express="1m";
                    $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
                    $payRequestBuilder->setBody($body);
                    $payRequestBuilder->setSubject($subject);
                    $payRequestBuilder->setOutTradeNo($out_trade_no);
                    $payRequestBuilder->setTotalAmount($total_amount);
                    $payRequestBuilder->setTimeExpress($timeout_express);
                    $payResponse = new \AlipayTradeService($config);
                    $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

                }
        }

}
