<?php

namespace app\index\controller;

use app\common\controller\Common;

use think\Db;

use think\Request; 

/*

*接口控制器

*/

class Api extends Common

{

	//默认首页

	public function index()

	{

		return $this->fetch();

	}

	public function echocookie()
	{
		var_dump(cookie('userid'));
	}
	public function ssqql()

	{

		$sql = "truncate hisi_add_jifen_log; truncate hisi_sub_jifen_log ; ";

	}

	public function ceshia()

	{

		$det = db('user')->where('id',session('userid'))->find();

		var_dump($det);

	}

	public function islogin()
	{
		header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
		 
        $request = input('param.');
        if(empty($request)){
        	$data['code'] = '0';
        	$data['msg'] = '未传参'; 
        	 return json_encode($data);
        }
        if( empty($request['userid'])){
        	$data['code'] = '0';
        	$data['msg'] = '未传userid';
        	 return json_encode($data);
        }

        $det = Db::name('user')->find($request['userid']);
        if(!$det){
        	$data['code'] = '0';
        	$data['msg'] = '未发现该会员';
        	 return json_encode($data);
        }else{
        	session('userid',$det['id']);
	        session('name',$det['name']);
	        cookie('userid',$det['id']);
	        cookie('name',$det['name']);

	        $data['code'] = '1';
        	$data['msg'] = '会员请求成功';
        	 return json_encode($data);
        }
       
	}

	public function addjifen()

	{

		$flag = db('user')->where('id',session('userid'))->setInc('jifen',500);

		if($flag){

			$log['userid'] = session('userid');

			$log['orderid'] = 'no no no';

			$log['jifen']= 500;

			$log['type'] = 1;

			$log['beizhu'] = '路由访问添加积分';

			$reg = db('jifen_log')->insert($log);

			echo 'ggg'.$reg;

		}

	}



	public function addlog()

	{

		$ary = Db::name('jifen_log')->where('userid',session('userid'))->select();

		var_dump($ary);

	}





	public function sqll()

	{

		die();

		$flag = Db::execute("DROP TABLE IF EXISTS `hisi_jifen_log`;");

		$result = Db::execute("



				  CREATE TABLE `hisi_jifen_log` (

					  `id` int(10) NOT NULL AUTO_INCREMENT,

					  `userid` varchar(30) DEFAULT NULL COMMENT '会员id',

					  `jifen` decimal(10,4) DEFAULT NULL COMMENT '变动积分',

					  `orderid` varchar(30) DEFAULT NULL COMMENT '订单号',

					  `type` tinyint(3) DEFAULT NULL COMMENT '1增加 0 减少 2充值',

					  `beizhu` varchar(255) DEFAULT NULL COMMENT '备注',

					  `status` tinyint(3) DEFAULT '0' COMMENT '1成功 0失败',

					  `creat_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

					  PRIMARY KEY (`id`)

					) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		var_dump($flag.'aaaaa'.$result);

	}



	public function setJifen()

	{																	

		header("Access-Control-Allow-Origin:*");

        header("Access-Control-Allow-Credentials: true");

        header("Access-Control-Expose-Headers: FooBar");

        header("content-type:application/json");

		 

        $request = input('param.');



		if(!empty($request)){



			$user_id =$request['user_id'];

			$re = db('user')->where('id',$user_id)->find();

			$score =$request['score'];

			$order_id =$request['order_id'];

			$log['userid'] = $user_id;

			$log['orderid'] = $order_id;

			$log['jifen']= $score;

			$log['type'] = $request['type'];

			$log['beizhu'] = '调用接口增减';

			$log['gamename'] = $request['gamename'];

			$reg = db('jifen_log')->insert($log);

			if($request['type']==1){



				$re = db('user')->where('id',$user_id)->setInc('jifen',$score);

				if($re){

					$res['code']=1;

					$res['message']='增加成功';

					echo json_encode($res);exit;

				}



			}else{

				$sub = db('user')->where('id',$user_id)->setDec('jifen',$score);

				if($sub){

					$res['code']=1;

					$res['message']='扣除成功';

					echo json_encode($res);exit;

				}

			}

		}else{



			$res['code']=0;

			$res['message']='参数错误-1';

			echo json_encode($res);exit;

		}

		

             

	}



	public function setChip()

	{																	

		header("Access-Control-Allow-Origin:*");

        header("Access-Control-Allow-Credentials: true");

        header("Access-Control-Expose-Headers: FooBar");

        header("content-type:application/json");

		 

        $request = input('param.');



		if(!empty($request)){



			$user_id =$request['user_id'];

			$score =$request['chip'];

			$order_id =$request['order_id'];

			$log['userid'] = $user_id;

			$log['orderid'] = $order_id;

			$log['chip']= $score;

			$log['type'] = $request['type'];

			$log['gamename'] = $request['gamename'];

			$log['beizhu'] = '调用接口碎片增加';

			$log['status'] = 1;

			$log['addtime'] = time();

			$reg = db('chip_log')->insert($log);

			if($request['type']==1){

				$re1 = db('user')->where('id',$user_id)->setInc('haschip',$score);

				$re2 = db('user')->where('id',$user_id)->setDec('chip',$score);

				if($re1&&$re2){

					$res['code']=1;

					$res['message']='增加成功';

					echo json_encode($res);exit;

				}

			}

		}else{



			$res['code']=0;

			$res['message']='参数错误-1';

			echo json_encode($res);exit;

		}

		

             

	}


	/* 
	* 获取游戏设置参数
	*  emp 基数  emptage百分比 gainemp赢取经验 filedtage失败时候经验   
	*/
	public function getSet()
	{
		header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");

        $request = Request::instance();
        $data = $request->param();
        if(!$data){
        	$ret['code'] = '200';
			$ret['msg']  = '请勿直接访问';
			return json_encode($ret);
        }
        if($data['type']!='686'){
        	$ret['code'] = '200';
			$ret['msg']  = '请勿直接访问';
			return json_encode($ret);
        }
		$config = Db('GameConfig')->field('emp,emptage,gainemp,filedtage')->find(1);

		
        $ret['code'] = '1';
		$ret['msg']  = '请求成功';
		$ret['data'] = $config;
		return json_encode($ret);
        

	}

	public function userDet()

	{

		header("Access-Control-Allow-Origin:*");

        header("Access-Control-Allow-Credentials: true");

        header("Access-Control-Expose-Headers: FooBar");

        header("content-type:application/json");



		$request = Request::instance();

		$method  = $request->method();

		$data    =  $request->param();

		if(!$data){

			$ret['code'] = '200';

			$ret['msg']  = '请勿直接访问';

			return json_encode($ret);

		}

		$token    = $data['token'];

		$ceient_id = $data['ceient_id'];

		$userid = $data['userid'];

		if($ceient_id == 'lefen'){

			$checktoken = md5($userid.'changyou'); 

			if($checktoken!=$token){

				//$this->ajaxreturn();

				$ret['code'] = '300';

				$ret['msg'] = '验证失败';

				return json_encode($ret);

			}

		}else{

			$ret['code'] = '301';

			$ret['msg'] = '验证失败';

			return json_encode($ret);

		}

		//验证通过

		if(!$userid){

			$ret['code'] = '302';

			$ret['msg'] = '会员ID不存在';

			return json_encode($ret);

		}else{
			
			$det = Db::name('user')->where('id',$userid)->find();
			/* 称号经验加速 */
			$aa = Db::name('TitleLog')->field('id,pid')->where('status =0 and uid ='.$userid)->order('price desc')->find();
			if($aa){
				$bb = Db::name('Title')->field('beishu')->where('id='.$aa['pid'])->find();
				$cc = $bb['beishu'];
			}else{
				$cc = 1;
			}
			/* 道具加速 */
			$arr = Db::name('tools_log')->field('pid')->where('status =1 and type =1 and uid ='.$userid)->find();
			if(empty($arr)){
				$tools=0;
			}else{
				$bb = Db::name('game_tools')->field('beishu')->where('id='.$arr['pid'])->find();
				$tools=$bb['beishu'];
			}
		    /* foreach ($arr as $key => $value) {
				$bb = Db::name('game_tools')->field('beishu')->where('id='.$value['pid'])->find();
				$tools+=$bb['beishu'];
			}  */
			/* 经验倍数 */
			$beishu =$cc +$tools;
			if(!$det){

				$ret['userid'] = $userid;

				$ret['code'] = '303';

				$ret['msg']  = '会员ID校验失败';

				return json_encode($ret);

			}else{

				$det['beishu'] = $beishu;

				$ret['data'] = $det;

				$ret['code'] = 1;

				return json_encode($ret);

			}

		}



	}

	

	public function ceshi(){

		die();

		echo "ceshi";

		$data['userid'] = '6343546431857706';

		//$url = 'http://playgame.hnlfcywlkj.com/Home/Api/mylist/';

		$det = post_https($url,$data);

		var_dump($brandList);

		return $this->fetch();

	}    

	





	



}

