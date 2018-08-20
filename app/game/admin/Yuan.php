<?php
namespace app\game\admin;
use app\admin\controller\Admin;
use think\Db;
class Yuan extends Admin
{
    public function index()
    {
            
          return $this->fetch();
         /* return $this->fetch(); */
    }
    public function yuan()
    {
          return $this->fetch();
         /* return $this->fetch(); */
    }
}