<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Controller;
/*
*接口控制器
*/
class Layer extends Controller{
    public function index(){
          $request = input('param.');
          $id = $request['id'];
          $res = DB::name('real_user')->where('uid', $id)->find();
          $state = $request['state'];
          if($state == 1){
                  $image =$res['zcard'];
          }else{
                  $image =$res['fcard'];
          }
          $this->assign('img', $image); 
          return $this->fetch();
    }
    public function huitie(){
           if($this->request->isPost()){
                  $data = $this->request->post();
                  $data['h_time']=time();
                  $re = Db::name('message')->where('id',$data['id'])->update($data);
                  if($re){
                          $res = Db::name('message')->where('id',$data['id'])->find();
                          $data_info['uid']=$res['uid'];
                          $data_info['content']=$data['huitie'];
                          $data_info['type']=3;
                          $data_info['title']='回帖';
                          db('information')->insert($data_info);
                          return $this->success('应用成功');
                  }
	    }
          $request = input('param.');
          $id = $request['id'];
          $res = DB::name('message')->where('id', $id)->find();
          $this->assign('data', $res);
          return $this->fetch();
    }
    public function agreement(){
          return $this->fetch();
    }
    
   
}
