<?php

namespace app\index\controller;

use app\common\controller\Common;

use think\Db;

/*

*基类

*/

class Base extends Common

{	

	protected function _initialize()
    {
    	if(!session('userid')){
    		if(!cookie('userid')){
    			$this->redirect("login/index");
    		}else{
    			session('userid',cookie('userid'));
    		}
		}
		$apparr = DB::name('game_set')->where('id',1)->find();
		$url =YILIAN_URL.$apparr['url'];
		$this->assign('url',$url);
    }
	//默认首页
	public function index()
	{	
		return $this->fetch();
	}

}