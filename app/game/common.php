<?php
use think\Db;
//积分日志
 function jifenlog($orderNum,$userid,$cash = '0.00',$type = '0',$status = '0',$beizhu='',$gamename='',$state)
 {
 
     $data ['orderid'] = $orderNum;
     $data ['userid'] = $userid;//会员id
     $data ['jifen'] = $cash; //变动积分
     $data ['type'] = $type;  //type=1 增加 0减少 2充值
     $data ['status'] = $status; //1成功 0失败
     $data ['beizhu'] =$beizhu;
     $data ['gamename'] =$gamename;
     $data ['state'] =$state;
     $flag = Db::name('jifen_log')->insert( $data );
     return $flag;
     
 }

 function getUser($userid=null)
 {
 	if(!$userid){
 		$ret['code'] = '-1';
        $ret['msg'] = '用户未登录';
        echo  json_encode($ret); 
        die();
 	}
 	$userdet = Db::name('User')->field('id,name,relivetime,jifen,phone,runaddress')->find($userid);
 	
 	return $userdet;
 }	

 function setAppLoginToken($str) {
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str.$phone);
    return $str;
}
function get_order_sn()
{
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);

    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}