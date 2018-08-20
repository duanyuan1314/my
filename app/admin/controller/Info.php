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
class Info extends Admin
{
    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '公告管理',
                'url' => 'admin/info/index',
            ],
        ];
        $this->tab_data = $tab_data;
    }
    public function index()
    { 
            $data_list = DB::name('game_info')->paginate(10);
            // 分页
            $pages = $data_list->render();
            $tab_data = $this->tab_data;
            $tab_data['current'] = url('');
            $this->assign('data_list', $data_list);
            $this->assign('tab_data', $tab_data);
            $this->assign('tab_type', 1);
            $this->assign('pages', $pages);
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
            $data['content'] = htmlspecialchars_decode($data['content']);
            $log = db('game_info')->insert($data);
            if (!$log) {
                return $this->error('添加失败！');
            }
            return $this->success('添加成功。',url('info/index')); 
        }
        
        return $this->fetch();
    }
    public function edit($id = 0)
    {
       if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['content'] = htmlspecialchars_decode($data['content']);
            $log = DB::name('game_info')->update($data);
            return $this->success('修改成功');
        }
        $row = DB::name('game_info')->where('id', $id)->find();
        $this->assign('data_info', $row);
        return $this->fetch();
    }
    
    
   
}
