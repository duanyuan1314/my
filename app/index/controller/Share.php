<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Controller;
/*
*接口控制器
*/
class  Share extends Controller{
    public function index(){
         //f135eaa31c924cf7eca6e3809418993b
         include "static/share/jssdk.php";
         $jssdk = new \JSSDK("wxee893e7f011a305c", "f135eaa31c924cf7eca6e3809418993b");  
         $signPackage = $jssdk->GetSignPackage();  
         /* var_dump($signPackage); */
         $this->assign('signPackage',$signPackage);
         return $this->fetch();
    }
    public function down(){
         return $this->fetch();
    }
    public function bean_detail()
	{
          header("Access-Control-Allow-Origin:*");
          header("Access-Control-Allow-Credentials: true");
          header("Access-Control-Expose-Headers: FooBar");
          header("content-type:application/json");
          $request = input('request.');
          $page =0;
          if (!empty($request['page'])) 
          {
                $page  = $_REQUEST['page'];
                if($page=='' || $page=='0'){
                    $page =0;
                }else{
                    $startpage =($page-1)*10;
                }
          }
		  $data = db('jifen_log')->where('userid',session('userid'))->limit($startpage,10)->order('id desc')->select();

		  $count = db('jifen_log')->where('userid',session('userid'))->count();

          $res['count'] =$count;

		  $res['data'] =$data;
		  
		  if($count>$page*10){
             $res['imore']= true;
		  }else{
			 $res['imore']= false;
		  }
		  echo json_encode($res);
    }
    public function debris_balance()
	{
          header("Access-Control-Allow-Origin:*");
          header("Access-Control-Allow-Credentials: true");
          header("Access-Control-Expose-Headers: FooBar");
          header("content-type:application/json");
          $request = input('request.');
          $page =0;
          if (!empty($request['page'])) 
          {
                $page  = $_REQUEST['page'];
                if($page=='' || $page=='0'){
                    $page =0;
                }else{
                    $startpage =($page-1)*10;
                }
                $data = db('ChipLog')->where('status',1)->where('userid',session('userid'))->limit($startpage,10)->order('id desc')->select();

                $count = db('ChipLog')->where('status',1)->where('userid',session('userid'))->count();

                $res['count'] =$count;

                $res['data'] =$data;
                
                if($count>$page*10){
                    $res['imore']= true;
                }else{
                    $res['imore']= false;
                }
                echo json_encode($res);
          }else{
                $res['code'] =1;
                $res['msg'] ='参数错误';
                echo json_encode($res);
          }
		 
    }
    public function version(){
         $data = db('game_set')->where('id',1)->find();
         $res['code'] =1;
         $res['version'] =$data['ios'];
         $res['content'] ='<p style="line-height: 1.5em;"><span style="font-size: 12px; color: rgb(89, 89, 89);">1、有的界面可以打开，有的又打不开，有点搞不懂，百度过，</span></p><p style="line-height: 1.5em;"><span style="font-size: 12px; color: rgb(89, 89, 89);">2、有的说什么重新编译下对应的工程，但还是不行，虽然打不开界面，</span></p><p style="line-height: 1.5em;"><span style="font-size: 12px; color: rgb(89, 89, 89);">3、但又不影响运行起来，我想改下界面布局，就不方便</span></p>';
         $res['appurl'] ='http://game.koko360.com/';
         echo json_encode($res);
    }
    public function aversion(){
         $data = db('game_set')->where('id',1)->find();
         $res['code'] =1;
         $res['version'] =$data['version'];
         $res['content'] ='<p>1、有的界面可以打开，有的又打不开，有点搞不懂，百度过，</p><p>2、有的说什么重新编译下对应的工程，但还是不行，虽然打不开界面，</p><p>3、但又不影响运行起来，我想改下界面布局，就不方便</p>';
         $res['appurl'] ='http://game.koko360.com/';
         echo json_encode($res);
    }
}
