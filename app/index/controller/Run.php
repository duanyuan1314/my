<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Controller;
/*
*接口控制器
*/
class  Run extends Base
{
    public function index(){
         $user = Db::name('user')->where('id',session('userid'))->find();
         $phone  =substr($user['phone'],0,-8)."****".substr($user['phone'],-4);
         $data = db('purse')->where('uid',session('userid'))->order('id desc')->select();
		 $this->assign('data', $data);
         $this->assign('phone',$phone);
		 $this->assign('user',$user);
         return $this->fetch();
    }
    public function runlist(){
         $data = db('purse')->where('uid',session('userid'))->order('id desc')->select();
		 $this->assign('data', $data);
         return $this->fetch();
    }
    public function addlist(){
         return $this->fetch();
    }
    public function runlog(){
         $data = db('purse_log')->where('uid',session('userid'))->order('id desc')->select();
		 $this->assign('data', $data);
         return $this->fetch();
    }
    public function del_list(){
         if($this->request->isPost()) {
                $data = $this->request->post();
                $det = Db::name('user')->where('id',session('userid'))->find();
                $pwd = md5($data['jiaoyi'].'lfcy');
                if($det['jiaoyi'] != $pwd){
                     return $this->error('交易密码错误');
                }else{
                     $log = DB::name('purse')->where('id',$data['id'])->delete();
                     if (!$log) {
                        return $this->error('删除失败！');
                     }
                     return $this->success('删除成功。');
                }
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
			$dataa['phone'] = $phone;
			$dataa['code'] = $rand;
			$dataa['sendtime'] = time();
			$result = sendSMS($phone,'【乐分畅游】:您的验证码为：'.$rand);
			$flag = Db::name('code')->insert($dataa);
			if($flag){
				return $this->success('发送成功');
			}else{
				return $this->error('网络超时！请重新获取');
			}
		}
    }
    public function addsave(){
            if($this->request->isPost()) {
                $data = $this->request->post();
                $det = Db::name('user')->where('id',session('userid'))->find();
                $pwd = md5($data['jiaoyi'].'lfcy');
                if($det['jiaoyi'] != $pwd){
                    return $this->error('交易密码不正确');
                }else{
                    $dataArr['bi_id']=$data['bi_id'];
                    $dataArr['uid']=session('userid');
                    $dataArr['runaddress']=$data['runaddress'];
                    $dataArr['name']=$data['name'];
                    $ress = db('purse')->insert($dataArr);
                    if($ress){
                        return $this->success('添加成功','index/index/index');
                    }
                }
            }
    }
    public function run_log(){
            if($this->request->isPost()) {
                $data = $this->request->post();
                $det = Db::name('user')->where('id',session('userid'))->find();
                $pwd = md5($data['jiaoyi'].'lfcy');
                if($det['jiaoyi'] != $pwd){
                    return $this->error('交易密码不正确');
                }
                Db::startTrans();
                $purse = Db::name('purse')->where('id',$data['purse_id'])->find();
                $dataArr['bamout']=$det['run'];
                $dataArr['amout']=$data['amout'];
                $xamout =$det['run']-$data['amout'];
                $dataArr['xamout']=$xamout;
                $dataArr['uid']=session('userid');
                $dataArr['runaddress']=$purse['runaddress'];
                $dataArr['type']=$purse['bi_id'];
                $dataArr['status']=1;
                $re = db('user')->where('id',session('userid'))->setDec('run',$data['amout']);
                if(!$re){
                         Db::rollback();
                         return false;
                }
                $ress = db('purse_log')->insert($dataArr);
                if(!$ress){
                         Db::rollback();
                         return false;
                }
                Db::commit();
                return $this->success('交易完成');
            }
    }
    public function checkjiaoyi(){
        if($this->request->isPost()) {
                $data = $this->request->post();
                $det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();
                if($det['code'] != $data['code']){
				    return $this->error('验证码不正确');
			    }
                $res =Db::name('user')->field('jiaoyi,run')->where('id',session('userid'))->find();
                $run =$res['run'];
                if($data['amout']>$run){
                    return $this->error('您的资产不足');
                }
                $jiaoyi =$res['jiaoyi'];
                if(empty($jiaoyi)){
                    $result['code'] = 2;
                    return json($result);exit;
                }else{
                    $result['code'] = 1;
                    return json($result);exit;
                }
        }
        
    }
    public function checkpass(){
        $res =Db::name('user')->field('jiaoyi')->where('id',session('userid'))->find();
        $jiaoyi =$res['jiaoyi'];
		if(empty($jiaoyi)){
			 $result['code'] = 2;
			 return json($result);exit;
		}else{
             $result['code'] = 1;
			 return json($result);exit;
        }
    }
}
