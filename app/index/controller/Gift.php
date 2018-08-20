<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
/*
*礼品页面
*/
class Gift extends Base
{
	//默认首页

	public function index()
	{	
		$userary = $this->checkLogin();

		$list = Db::name('GameGift')->where('status=1 and type=1')->select();

		$arr = Db::name('GameGift')->where('status=1 and type=2')->select();
		$this->assign('arr',$arr);
		$this->assign('list',$list);
		$this->assign('userary',$userary);
		return $this->fetch();
	}
	/*
	*兑换油卡记录
	*/
	public function history()
	{	
		//已完成
		$array1 = Db::name('CardOrder')->where('status =5 and userid ='.session('userid'))->select(); 
		//待发货
		$array2 = Db::name('CardOrder')->where('status =1 and userid ='.session('userid'))->select(); 
		//待收货
		$array3 = Db::name('CardOrder')->where('status =2 and userid ='.session('userid'))->select(); 

		$this->assign('ary1',$array1); 
		$this->assign('ary2',$array2);
		$this->assign('ary3',$array3);
		return $this->fetch();
	}
	/*
	*碎片列表
	*/
	public function debris_balance()
	{	
		$det = $this->checkLogin();
		$array = Db::name('ChipLog')->where('status = 1 and userid ='.session('userid'))->order('addtime desc')->select(); 
		$this->assign('ary',$array); 
		$this->assign('userary',$det);
		return $this->fetch();
	}

	/*
	*生成订单页面
	*/
	public function confirm_order($id)
	{	//$cardid
		
		if(!$id){
			return	$this->error('礼品ID不存在',url('gift/index'));
		}
		$address = Db::name('UserAddress')->where('ishidden =0 and isSelect=1 and userid='.session('userid'))->find();

		$cardet = Db::name('GameGift')->field('id,name,examout,image')->where('id',$id)->find();

		$this->assign('address',$address);
		$this->assign('cardet',$cardet);

		return $this->fetch();
	}

	public function confirmSave()
	{
		//判断条件 碎片是否满足
		$userary = $this->checkLogin();

		if($this->request->isPost()){
			$data = $this->request->post(); //获取数据
			$re = Db::name('user_address')->where('userid',session('userid'))->find();
			/* 实名认证 */
			$res = Db::name('user')->where('id',session('userid'))->find();
			/* 当前油卡等级 */
			$as = Db::name('game_gift')->where('id',$data['cardid'])->find();
		    /* 查询当前用户等级 */
			$grade =$res['grade'];
			if(!$data['addressid']){
				$result['code'] = 1;
				$result['msg'] = '请选择收货地址';
				return json($result);exit;
			}
			if($grade<$as['grade']){
				/* 是否使用兑换道具 */
				if($data['tools'] ==1){
					$es = Db::name('tools_log')->where('type',2)->where('status',0)->where('uid',session('userid'))->order('buy_time desc')->find();
					if(empty($es)){
						$result['code'] = 7;
						$result['msg'] = '您还没有道具哦！';
						return json($result);exit;
					}
				}else{
					$result['code'] = 4;
					$result['msg'] = '当前的等级不足,请前去升级';
					return json($result);exit;
				}
			}
			if($res['isCheck'] != 3){
				$result['code'] = 5;
				$result['msg'] = '前去实名认证';
				return json($result);exit;
			}
			/* 第一段设置 */
			$as = Db::name('game_grade')->where('id',2)->where('status',1)->find();
			if($grade>=$as['gradeup'] && $grade<$as['gradedown']){
				/* 当前时间——天数*24*3600 */
				$datetime =time()-$as['day']*24*3600;
				$map=[];
				$map['userid'] = session('userid');
				$map['addtime']    = ['EGT', "$datetime"];
				$count =Db::name('card_order')->where($map)->count();	
				if($count>=$as['time']){
					$result['code'] = 3;
					$result['msg'] = '兑换次数已用完';
					return json($result);exit;
				}	
			}
			/* 第二段设置 */
			$as1 = Db::name('game_grade')->where('id',3)->find();
			if($grade>=$as1['gradeup'] && $grade<$as1['gradedown']){
				/* 当前时间——天数*24*3600 */
				$datetime =time()-$as1['day']*24*3600;
				$map=[];
				$map['userid'] = session('userid');
				$map['addtime']    = ['EGT', "$datetime"];
				$count =Db::name('card_order')->where($map)->count();	
				if($count>$as1['time']){
					$result['code'] = 3;
					$result['msg'] = '兑换次数已用完';
					return json($result);exit;
				}	
			}
			/* 第三段设置 */
			$as2 = Db::name('game_grade')->where('id',4)->find();
			if($grade>=$as2['gradeup'] && $grade<$as2['gradedown']){
				/* 当前时间——天数*24*3600 */
				$datetime =time()-$as2['day']*24*3600;
				$map=[];
				$map['userid'] = session('userid');
				$map['addtime']    = ['EGT', "$datetime"];
				$count =Db::name('card_order')->where($map)->count();	
				if($count>$as2['time']){
					$result['code'] = 3;
					$result['msg'] = '兑换次数已用完';
					return json($result);exit;
				}	
			}
			/* 第四段设置 */
			$as3 = Db::name('game_grade')->where('id',5)->find();
			if($grade>=$as3['gradeup'] && $grade<$as3['gradedown']){
				/* 当前时间——天数*24*3600 */
				$datetime =time()-$as3['day']*24*3600;
				$map=[];
				$map['userid'] = session('userid');
				$map['addtime']    = ['EGT', "$datetime"];
				$count =Db::name('card_order')->where($map)->count();	
				if($count>$as3['time']){
					$result['code'] = 3;
					$result['msg'] = '兑换次数已用完';
					return json($result);exit;
				}	
			}
			//判断余额是否足够
			if($data['money']>$userary['haschip']){
				$ret['code'] = 6;
				$ret['msg'] = '碎片不足';
				return $ret; 
				die();
			}
			//收货地址
			$address = Db::name('UserAddress')->where('id',$data['addressid'])->find();

			$cardet = Db::name('GameGift')->field('id,name,examout,image')->where('id',$data['cardid'])->find();

			Db::startTrans();

			$dataa['address']=$address['city_ids'].$address['address'];
			$dataa['userid'] = session('userid');
			$dataa['price'] = $data['money'];
			$dataa['num'] = $data['cardnum'];
			$dataa['cash'] = $cardet['examout'];
			$dataa['receiver'] = $address['receiver'];
			$dataa['phone'] = $address['phone'];
			$dataa['addtime'] = time();
			$dataa['cardid'] = $cardet['id'];
			$dataa['cardname'] = $cardet['name'];
			$dataa['status'] = 1;
			$orderNum = date('ymdhis',time()).rand(10000,99999);
			$dataa['orderNum'] =  $orderNum ; //= date('ymdhis',time()).rand(10000,99999);
			$flag = Db::name('user')->where('id',session('userid'))->setDec('haschip',$data['money']);
			if($flag){
				$flg = Db::name('CardOrder')->insert($dataa);
				if($flg){
					Db::commit();
					$ret['code'] = 2;
					$ret['msg'] = '提交成功';
					/* 是否使用道具 */
					if($data['tools'] ==1){
						$zs = Db::name('tools_log')->where('type',2)->where('status',0)->where('uid',session('userid'))->order('buy_time desc')->find();
						if(!empty($zs)){
							Db::name('tools_log')->where('id',$zs['id'])->setField('status',1);
						}
					}
					//调用接口扣除
					$g = subhaschip(session('userid'),$data['money']);
					$gg = add_chip_log(session('userid'),$data['money'],$orderNum,0,'兑换油卡','兑换油卡');
					return $ret;
					die();
				}else{
					Db::rollback();
					$ret['code'] = 1;
					$ret['msg'] = '提交失败';
					return $ret;
					die();
				}
			}else{
					Db::rollback();
					$ret['code'] = 1;
					$ret['msg'] = '订单提交失败';
					return $ret;
					die();
			}
			
		}
		
	}
	function checkLogin()
    {
        if(!session('userid'))
        {
            $this->redirect(url('/index/login/index'));
        }else{
            $det = Db::name('user')->where('id',session('userid'))->find();
            return $det;
        }
	}
	function checkaddress()
    {
		$data = $this->request->post();
		$re = Db::name('user_address')->where('userid',session('userid'))->find();
		/* 实名认证 */
		$res = Db::name('user')->where('id',session('userid'))->find();
		/* 当前油卡等级 */
		$as = Db::name('game_gift')->where('id',$data['id'])->find();
		/* 查询当前用户等级 */
		$grade =$res['grade'];
		if($grade<$as['grade']){
			$result['code'] = 4;
			$result['msg'] = '当前的等级不足,请前去升级';
			return json($result);exit;
		}
		/* 第一段设置 */
		$as = Db::name('game_grade')->where('id',2)->where('status',1)->find();
		if($grade>=$as['gradeup'] && $grade<$as['gradedown']){
			 /* 当前时间——天数*24*3600 */
			 $datetime =time()-$as['day']*24*3600;
			 $map=[];
			 $map['userid'] = session('userid');
			 $map['addtime']    = ['EGT', "$datetime"];
			 $count =Db::name('card_order')->where($map)->count();	
			 if($count>=$as['time']){
				 $result['code'] = 3;
				 $result['msg'] = '兑换次数已用完';
				 return json($result);exit;
			 }	
		}
		/* 第二段设置 */
		$as1 = Db::name('game_grade')->where('id',3)->find();
		if($grade>=$as1['gradeup'] && $grade<$as1['gradedown']){
			 /* 当前时间——天数*24*3600 */
			 $datetime =time()-$as1['day']*24*3600;
			 $map=[];
			 $map['userid'] = session('userid');
			 $map['addtime']    = ['EGT', "$datetime"];
			 $count =Db::name('card_order')->where($map)->count();	
			 if($count>$as1['time']){
				 $result['code'] = 3;
				 $result['msg'] = '兑换次数已用完';
				 return json($result);exit;
			 }	
		}
		/* 第三段设置 */
		$as2 = Db::name('game_grade')->where('id',4)->find();
		if($grade>=$as2['gradeup'] && $grade<$as2['gradedown']){
			 /* 当前时间——天数*24*3600 */
			 $datetime =time()-$as2['day']*24*3600;
			 $map=[];
			 $map['userid'] = session('userid');
			 $map['addtime']    = ['EGT', "$datetime"];
			 $count =Db::name('card_order')->where($map)->count();	
			 if($count>$as2['time']){
				 $result['code'] = 3;
				 $result['msg'] = '兑换次数已用完';
				 return json($result);exit;
			 }	
		}
		/* 第四段设置 */
		$as3 = Db::name('game_grade')->where('id',5)->find();
		if($grade>=$as3['gradeup'] && $grade<$as3['gradedown']){
			 /* 当前时间——天数*24*3600 */
			 $datetime =time()-$as3['day']*24*3600;
			 $map=[];
			 $map['userid'] = session('userid');
			 $map['addtime']    = ['EGT', "$datetime"];
			 $count =Db::name('card_order')->where($map)->count();	
			 if($count>$as3['time']){
				 $result['code'] = 3;
				 $result['msg'] = '兑换次数已用完';
				 return json($result);exit;
			 }	
		}
		if($res['isCheck'] != 3){
			$result['code'] = 2;
			$result['msg'] = '前去实名认证';
			return json($result);exit;
		}
		if($re){
			$result['code'] = 1;
			$result['msg'] = '去兑换';
			return json($result);exit;
		}else{
			$result['code'] = 0;
			$result['msg'] = '前去设置地址';
			return json($result);exit;
		}
    }
}