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
class Exchange extends Admin
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
                'title' => '礼品碎片设置',
                'url' => 'admin/exchange/index',
            ],
            [
                'title' => '碎片参数设置',
                'url' => 'admin/exchange/exp',
            ],
            [
                'title' => '礼包设置',
                'url' => 'admin/exchange/gift',
            ],
        ];
        $this->tab_data = $tab_data;
    }

    public function index()
    {
        $data_list = DB::name('game_exchange')->paginate(10);
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
    public function exp()
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
        $tab_data = $this->tab_data;
        $tab_data['current'] = url('');
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 1);
        $this->assign('data_info', $row);
        return $this->fetch();
    }

    public function gift()
    {
        $data_list = DB::name('exchange_gift')->paginate(10);
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
            $log = db('game_exchange')->insert($data);
            if (!$log) {
                return $this->error('添加失败！');
            }
            return $this->success('添加成功。',url('exchange/index'));
        }
        
        return $this->fetch();
    }
    
    /**
     * 礼包
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function giftadd()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $log = db('exchange_gift')->insert($data);
            if (!$log) {
                return $this->error('添加失败！');
            }
            return $this->success('添加成功。',url('exchange/gift'));
        }
        return $this->fetch();
    }
    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function editgift($id = 0)
    {
       if ($this->request->isPost()) {
            $data = $this->request->post();
            $log = DB::name('exchange_gift')->update($data);
            if (!$log) {
                return $this->error('修改失败！');
            }
            return $this->success('修改成功。');
        }
        $row = DB::name('exchange_gift')->where('id', $id)->find();
        $this->assign('data_info', $row);
        return $this->fetch('giftadd');
    }
    
   
}
