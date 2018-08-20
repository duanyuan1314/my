<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
/*
*我的页面
*/
class Index extends Common
{
	//默认首页
	public function index()
	{
		/* 分享二维码 链接 */
		$apparr = DB::name('game_set')->where('id',1)->find();
		$url =YILIAN_URL.$apparr['url'];
		$this->assign('url',$url);
		//brand图
		$brandList = Db::name('brand')->where('ishidden',0)->limit(4)->order('sortid','desc')->select();
		$brandListlast = Db::name('brand')->where('ishidden',0)->limit(1)->order('sortid','desc')->select();
		$brandListfirst = Db::name('brand')->where('ishidden',0)->limit(1)->order('sortid','asc')->select();
		//最佳榜单
		/* 第一名 */
		$toplistone = Db::name('toplist')->where('ishidden',0)->limit(1)->order('id desc')->select();
		/* 第二名 */
		$toplisttwo = Db::name('toplist')->where('ishidden',0)->limit(1,1)->order('id desc')->select();
		/* 第三名 */
		$toplistree = Db::name('toplist')->where('ishidden',0)->limit(2,1)->order('id desc')->select();

		$toplist= Db::name('toplist')->where('ishidden',0)->order('id desc')->select();

		$this->assign('toplistone',$toplistone);
		
		$this->assign('toplisttwo',$toplisttwo);

		$this->assign('toplistree',$toplistree);

		/* 排名第一游戏 */
		$gameone = Db::name('game_list')->where('status',1)->limit(1)->order('sortid desc')->select();

		$gametwo = Db::name('game_list')->where('status',1)->limit('1,1')->order('sortid desc')->select();

		$gametree = Db::name('game_list')->where('status',1)->limit('2,1')->order('sortid desc')->select();

		$gamelist = Db::name('game_list')->where('status',1)->limit('3,4')->order('sortid desc')->select();

		$this->assign('gamelist',$gamelist);

		$this->assign('gameone',$gameone);

		$this->assign('gametwo',$gametwo);

		$this->assign('gametree',$gametree);

		$this->assign('brandListlast',$brandListlast);

		$this->assign('brandListfirst',$brandListfirst);
		
		$this->assign('brandlist',$brandList);

		$this->assign('userid',session('userid'));

		return $this->fetch();

	}
	public function checkinfo(){
			$res = Db::name('game_info')->field('id,title,description,image,status')->where('status =1 and type=2')->order('creat_time desc')->find(); 
			if(empty($res)){
					$result['code'] = 0;
					$result['msg'] = '未发公告';
					return json($result);exit;
			}else{
					if($res['status']==1){
						$result['code'] = 1;
						$result['data'] =$res;
						$result['msg'] = '启用公告';
						return json($result);exit;
					}else{
						$result['code'] = 0;
						$result['msg'] = '禁用公告';
						return json($result);exit;
					}
			}
	}
	public function checklogin(){
			if(session('userid')){
						$user = Db::name('user')->where('id',session('userid'))->find();
						$le_beans =$user['jifen'];
						$black = Db::name('blacklist')->where('userid',session('userid'))->where('ishidden',0)->find();
						if($black){
							$result['code'] = 3;
							$result['msg'] = '你已被列入黑名单';
							return json($result);exit;
						}
						if($le_beans<=0){
							$result['code'] = 2;
							$result['msg'] = '乐豆不足,前去充值';
							return json($result);exit;
						}else{
							$result['code'] = 1;
							$result['userid'] = session('userid');
							return json($result);exit;
						}
			}else{
						$result['code'] = 0;
                        $result['msg'] = '您暂未登录,请前去登录';
                        return json($result);exit;
			}
	}
	/*
	*全部榜单列表
	*/
	public function rank(){
		//最佳榜单
		/* 第一名 */
		$toplistone = Db::name('toplist')->where('ishidden',0)->limit(1)->order('id desc')->select();
		/* 第二名 */
		$toplisttwo = Db::name('toplist')->where('ishidden',0)->limit(1,1)->order('id desc')->select();
		/* 第三名 */
		$toplistree = Db::name('toplist')->where('ishidden',0)->limit(2,1)->order('id desc')->select();

		$toplist= Db::name('toplist')->where('ishidden',0)->order('id desc')->select();

		$this->assign('toplistone',$toplistone);
		
		$this->assign('toplisttwo',$toplisttwo);

		$this->assign('toplistree',$toplistree);
		
		$list = Db::name('toplist')->where('ishidden',0)->order('id desc')->select();
		//个人信息 在帮当排名
		$data['userid'] =session('userid');
		$url = 'http://playgame.hnlfcywlkj.com/Home/Api/mylist/';
		$det = post_https($url,$data);
		$ary = json_decode($det,true);
		if($ary['code'] == 300 || $ary['code'] == 404){
			$arys ['rownum']='-1';
			$arys ['name']='暂无信息';
			$arys ['sum']='0.00';
			$arys ['avatar']='无';
			$this->assign('det',$arys);
		}else{
			$this->assign('det',$ary);
		}
		$this->assign('toplist',$toplist);
		$this->assign('list',$list);
		return $this->fetch();
	}

}
