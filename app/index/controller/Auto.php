<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
use think\Request; 
/*
*接口控制器
*/
class Auto extends Common
{
	//默认首页
	public function index()
	{
		return $this->fetch();
	}
	
	public function settitle()
	{
		$sql = "SELECT * FROM hisi_title_log WHERE ( (unix_timestamp(now())-addtime) > (3600*24*limittime) );";
		$ary = Db::query($sql);
		$flag =0;
	 	foreach ($ary as $key => $value) {
			# code...
		 	$flag =	$this->checktitle($value['uid'],$value['pid']);	
		} 
		
 	    var_dump($flag);
	}


	public function checktitle($uid,$titleid)
	{
		$det = Db::name('user')->find($uid);
		$ary = explode(',',$det['title']);
		$flag = 0;
		if(in_array($titleid, $ary)){
			$arr = array_merge(array_diff($ary, array($titleid)));	
			$title=implode(',',$arr);
			$del_title = Db::name('title_log')->where('uid',$uid)->where('pid',$titleid)->setField('status',1);
			if($del_title){
				$titleArr = Db::name('title_log')->where('uid',$uid)->where('status',0)->order('price desc')->select();
				if($titleArr){
					$title_top =$titleArr[0]['name'];
				}else{
					$title_top ='';
				}
				$data['title'] = $title;
				$data['title_top'] = $title_top?$title_top:'暂无称号';
			    $flag = Db::name('user')->where('id',$uid)->update($data);
			}else{
				$flag =1;
			}
		}else{
			$flag =0;
		}
		return $flag;
	}
	/*
	*
	*/
	public function autodaylog(){

		$today = strtotime(date("Y-m-d"),time());
		//
		$yesterday = $today-24*3600;
		//购买称号日统计 addtime    sumprice:收入 count 	
		$titary = Db::name('TitleLog')->field('sum(price) as sumprice,count(id) as count')->where('addtime >'.$yesterday.' and addtime <'.$today)->select();
		//购买道具日统计 addtime    sumprice:收入 count  
        $toolsary = Db::name('tools_log')->field('sum(price) as sumprice,count(id) as count')->where('buy_time >'.$yesterday.' and buy_time <'.$today)->select();
		//购买乐豆日统计 create_time 2018-06-09 16:11:10   UNIX_TIMESTAMP(create_time)
		$lebeans = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and ( type=1 or type=2 ) and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();
		$lebeans_card = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and type=3 and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();
		$lebeans_wx = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and  type=1  and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();
		$lebeans_ali = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and type=2 and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();

		//兑换油卡日统计 sumprice 总碎片  sumnum 总数量
		$cardary = Db::name('CardOrder')->field('sum(price) as sumprice,sum(num) as sumnum')->where('addtime >'.$yesterday.' and addtime <'.$today)->select();
		//统计好日志写入autoday_log表中

		$data = array();
		$data['date'] =		date("Y-m-d",$yesterday); //日期

		$data['RMB'] = $lebeans[0]['rmb']?$lebeans[0]['rmb']:0; // 总额 是否包含充值卡
		$data['wxpay'] = $lebeans_wx[0]['rmb']?$lebeans_wx[0]['rmb']:0; //微信
		$data['alipay'] = $lebeans_ali[0]['rmb']?$lebeans_ali[0]['rmb']:0; //支付宝
		$data['cardpay'] = $lebeans_card[0]['sumnum']?$lebeans_card[0]['sumnum']:0; //充值卡充值的乐豆
		$data['jifenout'] = $lebeans[0]['sumnum']? $lebeans[0]['sumnum']:0; // 现金充值乐豆
		$data['titleout'] = $titary[0]['sumprice']?$titary[0]['sumprice']:0; //卖出称号
		$data['toolsout'] = $toolsary[0]['sumprice']?$toolsary[0]['sumprice']:0; //卖出道具
		$data['chipin'] = $cardary[0]['sumprice']?$cardary[0]['sumprice']:0;  //回收碎片
		$data['cardnum'] = $cardary[0]['sumnum']?$cardary[0]['sumnum']:0;  //油卡数量
		$data['addtime'] = time();

		$flag = Db::name('AutodayLog')->insert($data);

		if($flag){
			return $flag;
		}else{
			return $flag;
		}

	}
	public function settools()
	{
		$sql = "SELECT * FROM hisi_tools_log WHERE ( (unix_timestamp(now())-buy_time) > (3600*24*limittime) );";
		$ary = Db::query($sql);
	 	foreach ($ary as $key => $value) {
			# code...
		 	$flag =	$this->checktools($value['uid'],$value['id']);	
		} 
 	    var_dump($flag);
	}
	public function checktools($uid,$id)
	{
		$tools = Db::name('tools_log')->where('type',1)->where('uid',$uid)->where('id',$id)->setField('status',2);
		return $tools;
	}
	

}
