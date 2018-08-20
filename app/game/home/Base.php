<?php
namespace app\game\home;
use app\common\controller\Common;
use think\Db;

class Base extends Common
{
	public function _initialize()
	{
		// if(!session('userid')){
		// 	$this->redirect('/index/index/login');
		// }
	}

	//
    public function index()
    {

    	echo 'index'; die();
        return $this->fetch();
    }
}