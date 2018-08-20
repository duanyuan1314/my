<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
/*
*充值页面
*/
class Recharge extends Base
{
	//默认首页
	public function index()
	{	
		if(!session('userid')){
			$this->redirect("login/index");
		}
		/* 用户余额 */
	    $ledou = Db::name('user')->where('id',session('userid'))->find();
		$list = Db::name('recharge')->where('ishidden',0)->order('id asc')->select();
		$this->assign('list',$list);
		$this->assign('ledou',$ledou);
		return $this->fetch();
	}
	/* 兑换 */
	public function exchange()
	{	
		return $this->fetch();
	}
	public function real_name()
	{	
		return $this->fetch();
	}
	public function real_refuse()
	{	
		$user =Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function again_up()
	{	
		if($this->request->isPost()){
			$data = $this->request->post();
			Db::name('real_user')->where('uid',session('userid'))->update($data);
			$re=Db::name('user')->where('id',session('userid'))->setField('isCheck',6);
			return $this->success('提交成功');
		}
		$arr = Db::name('real_user')->where('uid',session('userid'))->find();
		$this->assign('arr',$arr);
		return $this->fetch();
	}
	public function real_card()
	{	
		$arr = Db::name('real_user')->where('uid',session('userid'))->find();
		$user =Db::name('user')->where('id',session('userid'))->find();
		$this->assign('arr',$arr);
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function real_up()
	{	
		if($this->request->isPost()){
			$data = $this->request->post();
			$flag = Db::name('real_user')->where('uid',session('userid'))->update($data);
			if($flag){
				$re=Db::name('user')->where('id',session('userid'))->setField('isCheck',2);
				if($re){
					return $this->success('提交成功');
				}else{
					return $this->error('证件已提交');
				}
			}else{
				return $this->error('网络超时');
			}
		}
		$arr = Db::name('real_user')->where('uid',session('userid'))->find();
		$this->assign('arr',$arr);
		return $this->fetch();
	}
	public function save()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			if($data['phone']==''){
                 return $this->error('手机号不能为空');
            }
			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();
			if($det['code'] != $data['code']){
				return $this->error('验证码不正确');
			}else{
				$re = Db::name('real_user')->where('uid',session('userid'))->find();
				if(!$re){
					$dataa['uid'] =session('userid');
					$dataa['real_phone'] = $data['phone'];
					$dataa['real_name'] = $data['real_name'];
					$dataa['card'] = $data['card'];
					Db::name('user')->where('id',session('userid'))->setField('isCheck',1);
					$flag = Db::name('real_user')->insert($dataa);
					if($flag){
						return $this->success('提交成功');
					}else{
						return $this->error('网络超时！提交失败');
					}
				}else{
					return $this->error('请不要重新提交资料');
				}
			}
			
		}else{
			return $this->error('提交失败');
		}
	}
	public function sendCode()
	{
		if($this->request->isPost()){
			$rand = rand(5000,9999);
			$data = $this->request->post();
			$phone = $data['phone'];
			$dataa['phone'] = $phone;
			$dataa['code'] = $rand;
			$dataa['sendtime'] = time();
			$result = sendSMS($phone,'【乐分畅游】：欢迎注册，验证码为：'.$rand);
			$flag = Db::name('code')->insert($dataa);
			if($flag){
				return $this->success('发送成功');
			}else{
				return $this->error('网络超时！请重新获取');
			}
			
		}

	}
	 public function set_order()
     {
          $user_id = session('userid');
          $order_sn = 'x'.time().rand(10000,90000);
          if($user_id)
          {
               $data = $this->request->post();
               $data['user_id'] = $user_id;
			   $data['orderid'] = $order_sn;
			   $data['status'] = 0;
               $re = db('lebeans_log')->insert($data);
               if($re)
               {
                    $result['status']=1;
                    $result['msg']=$order_sn;
                    return json($result);
               }
          }
          else
          {
               $result['status']=0;
               $result['msg']="未查询到账户信息！请重新登录";
               return json($result);
          }
	 }
	public function zhifu()
    {
        header("Content-type:text/html;charset=utf-8");
        include "static/al/config.php";
        include "static/al/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
        include "static/al/wappay/service/AlipayTradeService.php";
        include "static/al/aop/AopClient.php";
        $aop = new \AopClient;
        $post = $_GET;
        $aop->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAytTlHgBI/G9ZwOVbgZZt28HZ59LcFMjDH+eDvtkoYHt5Lp+BRt1+Xtx+4fj/9f2OiH79sEkOI3MSjZ3Q6gT3Pk7U1Wn1AnbfKrQE4iMRIZ/IWnyE4kk7tWVfiBsvEzNiwhq7D0jd6FociwFHYQiD/Keo8L5Yngfi4BN5D48igC4j1N896s4Y4s3QONVM9fs3C5nNzXVd4fY3Mkn6DHT2PU7xDeBbWEqCD1FgeTTk/dS3XnGh50q8pBxh4Cpsz0k3/1jT55Dz5xWSuQBYkphvfNAybvqfw1LuxQEQbMK19f0oLGZw8oLSwtzJP/jxntwOHnhbEMcz78yCyjEwl0kpeQIDAQAB";
        $flag = $aop->rsaCheckV1($post, NULL, "RSA2");
        if($flag)
        {
                 $out_trade_no=$post["out_trade_no"]; //订单号  
                 $result = $this->order_set($out_trade_no);
                 if($result)
                 {
						$url = YILIAN_URL.'/index/recharge/index.html';
						header('Location:'.$url); exit;
                 }
        }
        else
        {
                 $url = YILIAN_URL.'/index/recharge/index.html';
                 //file_put_contents("./al/url1.txt",$url."\r\n",FILE_APPEND);
                 header('Location:'.$url); exit;
        }
	}
	private function order_set($data)
    {
       			/*开启事物*/
				$arr = db('lebeans_log')->where('orderid',$data)->find();
                if($arr['status'] == 0)
                {
                    Db::startTrans();
                    $money   = $arr['money'];  /*充值乐豆*/
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
					$dataArr['state'] = 2;
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
	/* 秘钥兑换 */
	public function ledou()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$res = db('card')->where('cardid',$data['userkey'])->find();
			if($res['type']==1){
				return $this->error('抱歉秘钥已售出');
			}
			if($res){
				Db::startTrans();
				$user_id = session('userid');
				$order_sn = 'k'.time().rand(10000,90000);
				$re = db('card')->where('id',$res['id'])->setField('type',1);
				if(!$re){
					 Db::rollback();
                     return false;
				}
				$ao =db('user')->where('id',$user_id)->setInc('jifen',$res['money']);
				if(!$ao){
 					 Db::rollback();
                     return false;
				}
				$dataArr['userid'] = $user_id;
				$dataArr['jifen'] = $res['money'];
				$dataArr['orderid'] = $order_sn;
				$dataArr['type'] = 3;
				$dataArr['status'] = 1;
				$dataArr['beizhu'] = '密钥兑换';
				$ress = db('jifen_log')->insert($dataArr);
				if(!$ress){
					  Db::rollback();
                      return false;
				}
				Db::commit();
				$result['code'] = 1;
				$result['msg'] = '兑换成功';
				$result['money'] = $res['money'];
				return json($result);exit;
               /*   return $this->success('兑换成功'); */
			}else{
				return $this->error('抱歉秘钥不存在');
			}
		}
	}

}