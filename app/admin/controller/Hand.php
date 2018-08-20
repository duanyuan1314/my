<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 张志远 <466180170@qq.com>，开发者QQ群：466180170
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Db;
/**
 * 会员管理控制器
 * @package app\admin\controller
 */
class Hand extends Admin
{
    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $phone =$data['phone'];
            $user = Db::name('user')->where('phone',$phone)->find();
            if(empty($user)){
               return $this->error('用户不存在'); 
            }
            $data_info['jifen'] =$user['jifen']+$data['ledou'];
            $data_info['haschip'] =$data['haschip'];
            $data_info['id'] =$user['id'];
            DB::name('user')->update($data_info);
            $order_sn = 'r'.time().rand(10000,90000);
            $dataArr['userid'] = $user['id'];
			$dataArr['jifen'] = $data['ledou'];
			$dataArr['orderid'] = $order_sn;
			$dataArr['type'] = 8;
			$dataArr['beizhu'] = '后台手动充值';
			db('jifen_log')->insert($dataArr);
            return $this->success('应用成功。');
        }
        return $this->fetch();
    }
    public function set()
    {
         if ($this->request->isPost()) {
            $data = $this->request->post();
            $log = DB::name('game_set')->update($data);
            return $this->success('应用成功。');
        }
        $row = DB::name('game_set')->where('id',1)->find();
        $this->assign('data_info', $row);
        return $this->fetch();
    }
   
}
