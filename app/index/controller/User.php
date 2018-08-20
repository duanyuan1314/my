<?php
namespace app\index\controller;
use app\common\model\AdminAnnex as AnnexModel;
use app\common\controller\Common;
use think\Image;
use think\Db;
/*
*我的页面
*/
class User extends Base
{
   /* 授权登录 */
    public function client()
	{
		$data = $_GET;
		$code=$data['code'];
		$url = YILIAN_URL."/user/index/get_token?code=$code";
		$this->redirect($url);
	}
	public function get_token()
    {
        $code = $_GET['code'];
        $data['grant_type'] = "authorization_code";
        $data['code'] = $code;
        $url = YILIAN_ADMIN.'oauth/token.php';
        $arr = curl_post_https($url, $data);
        $userarr = json_decode($arr, TRUE);
        $res = set_game_token($userarr);
        if($res) 
        {
            $url = YILIAN_URL."/index/index/index";
            $this->redirect($url);
        }
        else
        {
            $this->error('保存用户信息失败',url('index/login/index'));
		}
		
    }
	//默认首页
	public function index()
	{	
		// 获取游戏后台等级经验等 测试id '15282491098611'
		$re = userMsg(session('userid'));
		$user = Db::name('user')->where('id',session('userid'))->find();
		if(empty($user)){
				session('userid',null);
				session('name',null);
				cookie('userid',null);
				cookie('name',null);
				$this->redirect("login/index");
		}
		/* 参数配置*/
		$gameconfig = Db::name('game_config')->where('id',1)->find();
		/* 经验指数 */
		$emptage =$gameconfig['emptage'];
		$tage =$gameconfig['emptage']/100+1;
		/* 初始经验 */
		$emp =$gameconfig['emp'];
		/* 当前用户经验 */
		$nowexp = $user['exp'];
		/* 当前用户等级 */
		$nowgrade = $user['grade'];
		/* 当前经验增加所需指数 */
		$hasexp =round(pow($tage, $user['grade']-1),2);
		/* 所需经验 */
		$needexp =$emp*$hasexp;
		/* 经验百分比 */
		$percentage =round($nowexp/$needexp,2);
		$user['haschip'] = $user['haschip']?$user['haschip']:0.00;
		$this->assign('percentage',$percentage);
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function change_info()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$res = Db::name('user')->where('name',$data['name'])->where('id!='.session('userid'))->find();
			if($res){
				return $this->error('该昵称已被占用,请更换昵称');exit;
			}
			$dataa['name'] = $data['name'];
			$dataa['avatar'] = $data['avatar'];
			$flag = Db::name('user')->where('id',session('userid'))->update($dataa);
			return $this->success('应用成功');
		}
		$user = Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	/**
     * 附件上传
     * @param string $from 来源
     * @param string $group 附件分组,默认sys[系统]，模块格式：m_模块名，插件：p_插件名
     * @param string $water 水印，参数为空默认调用系统配置，no直接关闭水印，image 图片水印，text文字水印
     * @param string $thumb 缩略图，参数为空默认调用系统配置，no直接关闭缩略图，如需生成 500x500 的缩略图，则 500x500多个规格请用";"隔开
     * @param string $thumb_type 缩略图方式
     * @param string $input 文件表单字段名
     * @author 橘子俊 <364666827@qq.com>
     * @return json
     */
    public function upload($from = 'input', $group = 'sys', $water = '', $thumb = '', $thumb_type = '', $input = 'file')
    {
        return json(AnnexModel::upload($from, $group, $water, $thumb, $thumb_type, $input));
    }
	public function contact()
	{
		return $this->fetch();
	}
	public function title()
	{
		$user = Db::name('user')->where('id',session('userid'))->find();
		$arr =explode(',',$user['title']);
		/* 称号1 */
		$title1 = Db::name('title')->where('ishidden',0)->limit(0,2)->order('id asc')->select();
		$arr_title1 =$this->title_state($title1,$arr);
		/* 称号2 */
		$title2 = Db::name('title')->where('ishidden',0)->limit(2,2)->order('id asc')->select();
		$arr_title2 =$this->title_state($title2,$arr);
		/* 称号3 */
		$title3 = Db::name('title')->where('ishidden',0)->limit(4,2)->order('id asc')->select();
		$arr_title3 =$this->title_state($title3,$arr);
		/* 称号4 */
		$title4 = Db::name('title')->where('ishidden',0)->limit(6,2)->order('id asc')->select();
		$arr_title4 =$this->title_state($title4,$arr);
		/* 称号5 */
		$title5 = Db::name('title')->where('ishidden',0)->limit(8,2)->order('id asc')->select();
		$arr_title5 =$this->title_state($title5,$arr);

		/* 获取称号 */
		$data = $_GET;
		if(!empty($data)){
			$id=$data['id'];
			$title = Db::name('title')->where('id',$id)->find();
			$this->assign('title',$title);
		}
		$this->assign('title1',$arr_title1);
		$this->assign('title2',$arr_title2);
		$this->assign('title3',$arr_title3);
		$this->assign('title4',$arr_title4);
		$this->assign('title5',$arr_title5);

		$this->assign('user',$user);

		return $this->fetch();
	}
	function title_state($title,$arr)
	{
		$ar1 =array();
		foreach($title as $k=>$v){
				if(in_array($v['id'],$arr)){
					$res['state']=1;
				}else{
					$res['state']=0;
				}
				$res['name']=$v['name'];
				$res['ledou']=$v['ledou'];
				$res['id']=$v['id'];
				$ar1[]=$res;
		}
		return $ar1;
	}
	public function title_detail()
	{
		$data = $_GET;
		$id=$data['id'];
		$title = Db::name('title')->where('id',$id)->find();
		$count = Db::name('title_log')->where('pid',$id)->group('uid')->count();
		$this->assign('count',$count);
		$this->assign('title',$title);
		return $this->fetch();
	}
	public function qrcode()
	{
		 include "static/qrcode/phpqrcode.php";
		 $client = new \QRcode();
         $size = "7";
         $errorLevel = "M";
		 $errorLevels = "S";
		 $url = "http://".$_SERVER['HTTP_HOST']."/index/login/refer?uid=".session('userid');
		 $client->png($url,'code.png', $errorLevel, $size);
		 $qrcode = "http://".$_SERVER['HTTP_HOST']."/code.png";
		 $this->assign('qrcode',$qrcode);
		 $user = Db::name('user')->where('id',session('userid'))->find();
		 $this->assign('user',$user);
		 return $this->fetch();
	}
	public function title_honner()
	{
		$data = $_GET;
		$id=$data['id'];
		$title = Db::name('title')->where('id',$id)->find();
		/* 到期时间 */
		$buylog = Db::name('title_log')->where('uid',session('userid'))->where('pid',$id)->find();

		$datetime =$buylog['addtime']+$title['limittime']*24*3600;

		$count = Db::name('title_log')->where('pid',$id)->group('uid')->count();
		$this->assign('count',$count);
		$this->assign('title',$title);
		$this->assign('datetime',$datetime);
		return $this->fetch();
	}
	
	public function title_save()
	{
			if($this->request->isPost()){
				$data = $this->request->post();
				$order_sn = 'z'.time().rand(10000,90000);
				$data['uid'] = session('userid');
				$data['addtime']=time();
				$re = db('user')->where('id',session('userid'))->find();
				$ledou =$data['price'];
				if($re['jifen']<$ledou){
 					return $this->error('您乐豆不足,请前去充值');
				}
				$res = Db::name('title_log')->insert($data);
				if($res){
					  if($re['title']== ''){
						  $as = $data['pid'];
					  }else{
						  $as =$re['title'].','.$data['pid'];
					  }
					  //调用接口增加游戏碎片池
					  $det = db('title')->find($data['pid']);
					  	$data_r['userid'] = session('userid');
				        $data_r['chip'] = $det['chip'];
				        $url = "http://playgame.hnlfcywlkj.com/Home/Api/addChip/";
				        $temp = post_https($url,$data_r);
				        $ret = json_decode($temp,true); 
				       
				        if($ret['code']!='1'){
				        	 return $this->error('网络超时!');
				        }

					  $a = db('user')->where('id',session('userid'))->setField('title',$as);
					  $titleArr = Db::name('title_log')->where('uid',session('userid'))->order('price desc')->select();
					  $title_top =$titleArr[0]['name'];
					  $a = db('user')->where('id',session('userid'))->setField('title_top',$title_top);
					  /* 存储记录 */
					  $ao =db('user')->where('id',session('userid'))->setDec('jifen',$data['price']);
					  if(!$ao){
							return $this->error('网络错误');
					  }
					  $dataArr['userid'] = session('userid');
					  $dataArr['jifen'] = $data['price'];
					  $dataArr['orderid'] = $order_sn;
					  $dataArr['type'] = 4;
					  $dataArr['status'] = 1;
					  $dataArr['beizhu'] = '购买称号';
					  $ress = db('jifen_log')->insert($dataArr);
					  if($ress){
 							return $this->success('购买成功');
					  }
				}else{
					  return $this->error('网络超时!');
				}
				
			}
	}
	public function tools_save()
	{
			if($this->request->isPost()){
				$data = $this->request->post();
				$order_sn = 'd'.time().rand(10000,90000);
				$re = db('user')->where('id',session('userid'))->find();
				$os = db('game_tools')->where('id',$data['id'])->find();
				$data_arr['pid'] =$os['id'];
				$data_arr['type'] =$os['type'];
				$data_arr['uid'] =session('userid');
				$data_arr['price'] =$os['ledou'];
				$data_arr['name'] =$os['name'];
				$data_arr['buy_time'] =time();
				$data_arr['limittime'] =$os['limittime'];
				$ledou =$os['ledou'];
				if($re['jifen']<$ledou){
 					return $this->error('您乐豆不足,请前去充值');
				}
				$res = Db::name('tools_log')->insert($data_arr);
				if($res){
					  /* 存储记录 */
					  $ao =db('user')->where('id',session('userid'))->setDec('jifen',$os['ledou']);
					  if(!$ao){
							return $this->error('网络错误');
					  }
					  $dataArr['userid'] = session('userid');
					  $dataArr['jifen'] = $os['ledou'];
					  $dataArr['orderid'] = $order_sn;
					  $dataArr['type'] = 5;
					  $dataArr['status'] = 1;
					  $dataArr['beizhu'] = '购买道具';
					  $ress = db('jifen_log')->insert($dataArr);
					  if($ress){
 						   return $this->success('购买成功');
					  }
				}else{
					       return $this->error('网络超时!');
				}
				
			}
	}
	public function setting()
	{
		$user = Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function safe()
	{
		$user = Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function login()
	{
		return $this->fetch();
	}
	public function register()
	{
		return $this->fetch();
	}
	public function mypack()
	{
		$arr = Db::name('tools_log')->where('uid',session('userid'))->where('status!=2')->select();
		$this->assign('arr',$arr);
		return $this->fetch();
	}
	public function card_green()
	{
		$id =input('id');

		$res = Db::name('tools_log')->where('id',$id)->find(); 

		$this->assign('arr',$res);

		return $this->fetch();
	}
	public function card_status()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$arr = Db::name('tools_log')->where('status =1 and type =1 and uid ='.session('userid'))->find();
			if(!empty($arr)){
				    return $this->error('当前加倍卡已在使用');
			}else{
					$data['go_time']=time();
					$data['status']=1;
					$flag = Db::name('tools_log')->where('id',$data['id'])->update($data);
					if($flag){
						return $this->success('开启成功');
					}else{
						return $this->error('网络超时！提交失败');
					}
			}
		}
	}
	public function card_red()
	{
		return $this->fetch();
	}
	public function change_phone()
	{
		$user = Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function change_safe()
	{
		$change_phone =input('phone');
		$this->assign('change_phone',$change_phone);
		return $this->fetch();
	}
	public function jiaoyi()
	{
		return $this->fetch();
	}
	public function jiaoyi_pass()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			/* 实名认证 */
			$res = Db::name('user')->where('id',session('userid'))->find();
			$jiaoyi_pass =md5($data['jiaoyi_pass'].'lfcy');
			$repass =$data['repass'];
		
			if(empty($data['jiaoyi_pass'])){
				return $this->error('密码不能为空');
			}
			if(strlen($data['jiaoyi_pass'])!=6){
				return $this->error('请设置六位交易密码');
			}
			if($data['jiaoyi_pass'] != $repass){
				return $this->error('两次密码不一致');
			}
			if($res['isCheck'] != 3){
				return $this->error('您未实名认证');
			}else{
				$flag = Db::name('user')->where('id',session('userid'))->setField('jiaoyi',$jiaoyi_pass); //->find();
				if($flag){
					return $this->success('设置成功');
				}else{
				    return $this->error('网络错误');
				}
			}
		}
	}
	public function bean_blance()
	{
		$user = Db::name('user')->where('id',session('userid'))->find();
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function bean_detail()
	{
		$data = db('jifen_log')->where('userid',session('userid'))->order('id desc')->select();
		$this->assign('data', $data);
		return $this->fetch();
	}
	public function growth()
	{
		$data = db('game_tools')->where('status',1)->order('id desc')->select();
		$this->assign('data', $data);
		return $this->fetch();
	}
	public function about()
	{
		return $this->fetch();
	}
	public function prize()
	{
		//已完成
		$array1 = Db::name('CardOrder')->where('status =5 and userid ='.session('userid'))->order('addtime desc')->select(); 
		//待发货
		$array2 = Db::name('CardOrder')->where('status =1 or status =2')->where('userid ='.session('userid'))->select(); 
		//待收货
		$array3 = Db::name('CardOrder')->where('status =3 and userid ='.session('userid'))->select(); 
		$this->assign('ary1',$array1); 
		$this->assign('ary2',$array2);
		$this->assign('ary3',$array3);
		return $this->fetch();
	}
	public function news()
	{
		//消息中心
		$array1 = Db::name('information')->where('uid ='.session('userid'))->select(); 
		//
		$array2 = Db::name('game_info')->where('status =1 and type=1')->select(); 
	
		$array3 = Db::name('information')->where('type =4 and uid ='.session('userid'))->select(); 

		$this->assign('ary1',$array1); 

		$this->assign('ary2',$array2);

		$this->assign('ary3',$array3);
		
		return $this->fetch();

	}
	public function changestatus()
	{
		$res =Db::name('information')->where('uid',session('userid'))->setField('status',2);
		if($res){
			 $result['code'] = 1;
			 return json($result);exit;
		}
	}
	/* 校验消息有没有查看 */
	public function checkstatus()
	{
		$res =Db::name('information')->where('uid',session('userid'))->where('status',1)->select();
		if(empty($res)){
			 $result['code'] = 1;
			 return json($result);exit;
		}
	}
	public function news_detail()
	{
		//新闻详情
		$id =input('id');

		$res = Db::name('game_info')->where('id',$id)->find(); 

		$this->assign('arr',$res);

		return $this->fetch();

	}
	public function change_save()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();
			if($det['code'] != $data['code']){
				return $this->error('验证码不正确');
			}else{
					$flag = Db::name('user')->where('id',session('userid'))->setField('phone',$data['phone']);
					if($flag){
						session('userid',null);
					    session('name',null);
						return $this->success('修改成功');
					}else{
						return $this->error('网络超时！提交失败');
					}
			}
		}
	}
	public function change_pass()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$old_pass =md5($data['old_pass'].'lfcy');
			$new_pass =$data['new_pass'];
			if(empty($new_pass)){
				return $this->error('密码不能为空');
			}
			$user = Db::name('user')->where('id',session('userid'))->find();
			if($old_pass != $user['password']){
				return $this->error('原始密码不正确');
			}else{
				$flag = Db::name('user')->where('id',session('userid'))->setField('password',md5($new_pass.'lfcy')); //->find();
				if($flag){
					session('userid',null);
					session('name',null);
					return $this->success('修改成功');
				}else{
				    return $this->error('修改失败');
				}
			}
		}
		return $this->fetch();
	}
	public function setPwd()
	{
		if($this->request->isPost()){
			$data = $this->request->post();
			$det = Db::name('code')->where('phone',$data['phone'])->order('id desc')->find();
			if($det['code'] != $data['code']){
				    return '验证码不正确';
			}else{
				$flag = Db::name('user')->where('phone',$data['phone'])->setField('password',md5($data['password'].'lfcy')); //->find();
				if($flag){
					return '修改成功';
				}else{
					return '修改失败';
				}
			}
		}else{
			        return '注册失败';
		}
	}
	public function upimg(){
		$ret = array();  //返回的上传文件状态数组
        if ($_FILES["file"]["error"] > 0)
        {
                $ret["message"] =  $_FILES["file"]["error"];
                $ret["status"] = 0; 
                $ret["src"] = "";
                return json($ret);   
        }else{
                $pic =  $this->uploadimg();
                if($pic['info']== 1){ 
					$url = OSS_URL.$pic['savename'];
                }  else {
                    $ret["message"] = $this->error($pic['err']);
                    $ret["status"] = 0;   
                }
                $ret["msg"]= "图片上传成功！";
                $ret["status"] = 1;   
                $ret["src"] = $url; 
                return json($ret);
        } 

    }
	public function message(){
        if($this->request->isPost()){
			$data = $this->request->post();
			$data['uid']=session('userid');
			$ress = db('message')->insert($data);	
			if($ress){
				return $this->success('已提交畅游团队');
			}
		}else{
			   return $this->error('参数错误');
		}
     }
     //图片上传代码
     private  function uploadimg(){
        $file = request()->file('file'); 
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $this->thumb($file,1);
        $reubfo = array();  //定义一个返回的数组
        if($info){
			$reubfo['info']= 1;
            $reubfo['savename'] = aliyun($info);
        }else{
            // 上传失败获取错误信息
			$reubfo['info']= 0;
            $reubfo['err'] = $file->getError();
        }
        return $reubfo;
	}
	public function upimgcard(){
		$ret = array();  //返回的上传文件状态数组
        if ($_FILES["file"]["error"] > 0)
        {
                $ret["message"] =  $_FILES["file"]["error"];
                $ret["status"] = 0; 
                $ret["src"] = "";
                return json($ret);   
        }else{
                $pic =  $this->uploadcard();
                if($pic['info']== 1){ 
					$url = OSS_URL.$pic['savename'];
                }  else {
                    $ret["message"] = $this->error($pic['err']);
                    $ret["status"] = 0;   
                }
                $ret["msg"]= "图片上传成功！";
                $ret["status"] = 1;   
                $ret["src"] = $url; 
                return json($ret);
        } 

	}
	  //图片上传代码
     private  function uploadcard(){
        $file = request()->file('file'); 
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $this->thumb($file,2);
        $reubfo = array();  //定义一个返回的数组
        if($info){
			$reubfo['info']= 1;
            $reubfo['savename'] = aliyun($info);
        }else{
            // 上传失败获取错误信息
			$reubfo['info']= 0;
            $reubfo['err'] = $file->getError();
        }
        return $reubfo;
	 }
	/* 图片裁剪 */
	private  function thumb($file,$type){
                $date =date('Y-m-d',time());
                $a = str_replace('-','',$date);
                $mulu =ROOT_PATH.'public/uploads/'.$a;
                $dir = iconv("UTF-8", "GBK",$mulu);
                if (!file_exists($dir)){
                    mkdir ($dir,0777,true);
				}
				if($type==1){
					$width='300';
					$height='300';
				}else{
					$width='800';
					$height='600';
				}
                $image = Image::open($file);
                $image->thumb($width,$height,Image::THUMB_CENTER);
                $saveName = md5(request()->time()).'.png';
                $image->save($mulu.'/'.$saveName);
                $info =$a.'/'.$saveName;
                return $info;
     }

}
