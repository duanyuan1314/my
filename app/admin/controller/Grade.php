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
use app\admin\model\GameList as GameModel;
use think\Db;
/**
 * 会员管理控制器
 * @package app\admin\controller
 */
class Grade extends Admin
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
            $log = DB::name('game_config')->update($data);
            if (!$log) {
                return $this->error('应用失败!,请修改数据再应用');
            }
            return $this->success('应用成功。');
        }
        $row = DB::name('game_config')->where('id',1)->find();
        $this->assign('data_info', $row);
        return $this->fetch();
    }

    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['ctime'] =strtotime($data['ctime']);
            if($data['image']==''){
                 return $this->error('请上传图片!');
            }
            if($data['icon']==''){
                 return $this->error('请上传icon图片!');
            }
            $log = db('game_list')->insert($data);
            if (!$log) {
                return $this->error('添加失败！');
            }
            return $this->success('添加成功。');
        }
        
        return $this->fetch();
    }
    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function edit($id = 0)
    {
       if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['ctime'] =strtotime($data['ctime']);
            if($data['image']==''){
                 return $this->error('请上传图片!');
            }
            if($data['icon']==''){
                 return $this->error('请上传icon图片!');
            }
            $log = GameModel::update($data);
            if (!$log) {
                return $this->error('修改失败！');
            }
            return $this->success('修改成功。');
        }
        $row = DB::name('game_list')->where('id', $id)->find();
        $this->assign('data_info', $row);
        return $this->fetch();
    }
    
   
}
