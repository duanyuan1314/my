<?php
namespace app\game\home;
use app\common\controller\Common;

use think\Db;

class Index extends Common
{
    public function index()
    {

    	echo 'index'; die();
        return $this->fetch();

    }
}