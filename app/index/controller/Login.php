<?php

namespace app\index\controller;

use app\common\controller\Common;

use think\Db;

/*

*礼品页面

*/

class Login extends Common

{

	//默认首页

	public function index()

	{	

		return $this->fetch();

	}

	public function register()

	{	

		return $this->fetch();

	}

	public function repass()

	{	

		return $this->fetch();

	}
	public function refer()
	{	
		$request = input('request.');
		if(!empty($request['uid'])){
			$uid =$request['uid'];
			$this->assign('uid',$uid);
		}
		return $this->fetch();
	}
	public function refer_save()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			if($data['phone']==''){
                 return $this->error('手机号不能为空');
            }
			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();
       		$a = time()-$det['sendtime'];
       		if($a>180){
       			return $this->error('验证码已过期');
       		}
			if($det['code'] == $data['code']){
				return $this->error('验证码不正确');
			}else{
				$rand = rand(1000,9999);
				$dataa['id'] = time().$rand;
				$dataa['phone'] = $data['phone'];
				$dataa['password'] = md5($data['password'].'lfcy');
				$dataa['addtime'] = time();
				$dataa['name'] = 'lfcy_'.substr($dataa['phone'], 0, 4).substr(time(), -4, 4);
				$dataa['token'] =  md5($dataa['id'].'changyou');
				$dataa['referid'] = $data['referid'] ;
				$flag = Db::name('user')->insert($dataa);
				if($flag){
					return $this->success('注册成功');
				}else{
					return $this->error('网络超时！注册失败');
				}
			}
		}else{
			return $this->error('注册失败');
		}
	}
	/*

	*登录验证

	*/

	public function loginin()

	{

		if($this->request->isPost()) {
            $data = $this->request->post();
            $det = Db::name('user')->where('phone',$data['phone'])->find();
            if(!$det){
            	return $this->error('手机号或用户名不正确');
			}
			if($det['status'] == 2){

            	return $this->error('当前用户已被禁用');

            }
            $pwd = md5($data['password'].'lfcy');

            if($det['password'] != $pwd){

				return $this->error('密码不正确');

            }else{
				$this->getrunaddress($det['id']);
            	session('userid',$det['id']);
            	session('name',$det['name']);
            	cookie('userid',$det['id']);
            	cookie('name',$det['name']);
            	return $this->success('登录成功','index/index/index');
            }

		}

	}
	public function help($name='help',$ary=null){
         include_once "static/client.php";
         $jssdk = new \client("a5c","543","39.104.13.202","31253",5,array());  
         $signPackage = $jssdk->execute($name,$ary);  
         return $signPackage;
	}
	public function lc($name='help',$ary=null){
         include_once "static/client.php";
         $jssdk = new \client("a5c","543","39.104.13.202","31253",5,array());  
         $signPackage = $jssdk->execute($name,$ary);  
         return $signPackage;
	}
	/* 获取钱包地址 */
	public function getrunaddress($uid)
    {
        $userary = Db::name('user')->where('id',$uid)->find();
        if(!$userary['runaddress']){
            $ary = array();
            $ary[] = $uid; 
			$address = $this->lc('getaddressesbyaccount',$ary);
            if(!$address){
                $address = $this->lc('getnewaddress',$ary);
				Db::name('User')->where('id='.$uid)->setField('runaddress',$address);
				return $address;
            }else{
				Db::name('User')->where('id='.$uid)->setField('runaddress',end($address));
				return end($address);
            }
        }else{
            return $userary['runaddress'];
        }

    }

	/*

	*注册保存

	*/

	public function save()

	{

		if($this->request->isPost()){

			$data = $this->request->post();

			if($data['phone']==''){

                 return $this->error('手机号不能为空');

			}
			$temp = Db::name('user')->where('phone',$data['phone'])->find();

			if($temp){
                return $this->error('该手机号已经注册');
			}

			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();

       		$a = time()-$det['sendtime'];

       		if($a>180){

       			return $this->error('验证码已过期');

       		}

			if($det['code'] != $data['code']){

				return $this->error('验证码不正确');

			}else{

				$rand = rand(1000,9999);

				$dataa['id'] = time().$rand;

				$dataa['phone'] = $data['phone'];

				$dataa['password'] = md5($data['password'].'lfcy');

				$dataa['addtime'] = time();

				$dataa['name'] = 'lfcy_'.substr($dataa['phone'], 0, 4).substr(time(), -4, 4);

				$dataa['token'] =  md5($dataa['id'].'changyou');

				$dataa['runaddress'] = $this->getrunaddress($dataa['id']);

				$flag = Db::name('user')->insert($dataa);

				if($flag){
					session('userid',$dataa['id']);
					session('name',$dataa['name']);
	            	cookie('userid',$dataa['id']);
	            	cookie('name',$dataa['name']);
					return $this->success('注册成功');
				}else{
					return $this->error('网络超时！注册失败');
				}

			}

			

		}else{

			return $this->error('注册失败');

		}

	}

	public function sendCode()

	{

		if($this->request->isPost()){

			$start = strtotime(date("Y-m-d"),time()); 

			

			$rand = rand(5000,9999);

			$data = $this->request->post();

			$phone = $data['phone'];



			$count = Db::name('code')->where('sendtime >'.$start.' and phone ='.$phone)->count();

			if($count>10){

				return $this->error('今日短信发送次数过多');

			}

			$temp = Db::name('user')->where('phone',$phone)->find();

			if($temp&&$data['type']=='0'){ //注册

				return $this->error('该手机号已经注册');

			}

			if(!$temp&&$data['type']=='1'){  //重置密码

				return $this->error('该手机号不存在');

			}

			$dataa['phone'] = $phone;

			$dataa['code'] = $rand;

			$dataa['sendtime'] = time();

			$dataa['type'] = $data['type'];

			$result = sendSMS($phone,'【乐分畅游】：您的验证码为：'.$rand);

			$flag = Db::name('code')->insert($dataa);

			if($flag){

				return $this->success('发送成功');

			}else{

				return $this->error('网络超时！请重新获取');

			}

			

		}



	}



	/*

	*重置密码

	*/

	public function setPwd()

	{

		if($this->request->isPost()){

			$data = $this->request->post();

			if($data['phone']==''){

                 return $this->error('手机号不能为空');

            }

            $tem = Db::name('user')->where('phone',$data['phone'])->find();



            if(!$tem){

            	return $this->error('手机号未注册');

            }

			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();

			$a = time()-$det['sendtime'];

       		if($a>180){

       			return $this->error('验证码已过期');

       		}

			if($det['code'] != $data['code']){

				return $this->error('验证码不正确');

			}else{

				

				$flag = Db::name('user')->where('phone',$data['phone'])->setField('password',md5($data['password'].'lfcy'));

				if($flag){

					return $this->success('重置成功');

				}else{

					return $this->error('网络超时！重置失败');

				}

			}

			

		}else{

			return $this->error('重置失败');

		}

	}



	/*

	*退出登录

	*/

	public function logout()

	{

		session('userid',null);

		session('name',null);

		cookie('userid',null);
        cookie('name',null);
        
		return $this->success('退出登录成功'.session('userid'),'index/index/index'); 

	}





}