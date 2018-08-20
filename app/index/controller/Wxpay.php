<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Controller;
/*
*接口控制器
*/
class Wxpay extends Controller{
          public function notify(){
            // 导入微信支付sdk
            //import('wxpay/WxPayPubHelper',EXTEND_PATH);
            include "static/wxpay/WxPayPubHelper.php";
            $wxConfig=array(
                "appid"=>"wxee893e7f011a305c",
                "appsecret"=>"d0faa15ea3d5fdeba879310241c805d6",
                "mchid"=>"1490984392",
                "key"=>"ba42905d18e7da6032b82b4260596dbf"
            );
            $order_id=input('get.orderid');
            $count = "充值乐豆";
            $arr = db('lebeans_log')->where('orderid',$order_id)->find();
            
            $dingdanhao = $arr['orderid'];
            $zmoney     = $arr['money']*100;
            //$zmoney     = 1;
            //使用jsapi接口
            $jsApi = new \JsApi_pub($wxConfig["appid"], $wxConfig["appsecret"], $wxConfig["mchid"], $wxConfig["key"]);
            //=========步骤2：使用统一支付接口，获取prepay_id============
            //使用统一支付接口
            $unifiedOrder = new \UnifiedOrder_pub($wxConfig["appid"], $wxConfig["appsecret"], $wxConfig["mchid"], $wxConfig["key"]);
            //设置统一支付接口参数
            //设置必填参数
            //appid已填,商户无需重复填写
            //mch_id已填,商户无需重复填写
            //noncestr已填,商户无需重复填写
            //spbill_create_ip已填,商户无需重复填写
            //sign已填,商户无需重复填写
            $unifiedOrder->setParameter("body", "$count"); //商品描述
            //自定义订单号，此处仅作举例
            $unifiedOrder->setParameter("out_trade_no", $dingdanhao); //商户订单号
            $unifiedOrder->setParameter("total_fee", $zmoney); //总金额
            $unifiedOrder->setParameter('product_id', 1);
            $unifiedOrder->setParameter("spbill_create_ip", $_SERVER["REMOTE_ADDR"]);
            $urls = YILIAN_URL."/index/notify/weixin";
            $unifiedOrder->setParameter("notify_url", $urls); //通知地址

            $unifiedOrder->setParameter("trade_type", "MWEB"); //交易类型
            $urla = YILIAN_URL."/index/index/index";
            $url = $unifiedOrder->getH5Url();
            $url = $url."&redirect_url=".urlencode($urla);
            header("Location:".$url);exit;
    }

}
