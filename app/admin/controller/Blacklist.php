<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.hisiphp.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 橘子俊 <364666827@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\AdminUser as UserModel;
use app\admin\model\AdminRole as RoleModel;
use app\admin\model\AdminMenu as MenuModel;
use app\admin\model\Brand as Brand;
use think\Validate;
use think\Db;

/**
 * 后台用户、角色控制器
 * @package app\admin\controller
 */
class Blacklist extends Admin
{
    public $tab_data = [];
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '黑名单管理',
                'url' => 'admin/blacklist/index',
            ],
        ];
        $this->tab_data = $tab_data;
    }

    /**
    **黑名单管理
    **/
    public function index()
    {
        $request = input('request.');
        $map = [];
        if (!empty($request['phone'])) 
        {
            $map['name'] = $request['phone'];
        }
        if (!empty($request['userid'])) 
        {
            $map['userid'] = $request['userid'];
        } 
        $data_list = Db::name('blacklist')->where($map)->paginate(10);
        // 分页
        $pages = $data_list->render();
        $tab_data = $this->tab_data;
        $tab_data['current'] = url('');
        $this->assign('role_list', RoleModel::getAll());
        $this->assign('data_list', $data_list);
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 1);
        $this->assign('pages', $pages);
        return $this->fetch();
    }
    public function blackadd()
    {
        return $this->fetch();
    }
    public function addsave()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            //var_dump($data);
            $flag = Db::name('user')->where('id',$data['userid'])->find();
            if(!$flag){
                return $this->error('会员ID不存在');
                die();
            }else{
                $data['addtime'] = time();
                $flg = Db::name('blacklist')->insert($data);
                if($flg){
                    return $this->success('添加成功');
                }else{
                    return $this->error('添加失败');
                }
            }

        }
    }
    public function editsave()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            $det = Db::name('blacklist')->where('id',$data['id'])->update($data);
            if($det){
                return $this->success('保存成功');
            }else{
                return $this->error('保存失败');
            }
        }
    }

    public function blackedit($id)
    {
        $det = Db::name('blacklist')->find($id);
        if(!$det){

        }else{
            $this->assign('det',$det);
        }
        return $this->fetch();
    }

    public function delblack()
    {
        $ids   = input('param.ids/a');
        
        $flag = Db::name('blacklist')->delete($ids);
        if ($flag) {
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
    /**
     * 布局切换
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function iframe()
    {
        $val = input('param.val', 0);
        if ($val != 0 && $val != 1) {
            return $this->error('参数传递错误');
        }
        if (UserModel::where('id', ADMIN_ID)->setField('iframe', $val) === false) {
            return $this->error('切换失败');
        }
        if ($val == 1) {
            cookie('hisi_iframe', 'yes');
        } else {
            cookie('hisi_iframe', null);
        }
        return $this->success('布局切换成功，跳转中...', url('index/index'));
    }

    /**
     * 添加用户
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function addUser()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'AdminUser');
            if($result !== true) {
                return $this->error($result);
            }
            unset($data['id']);
            $data['last_login_ip'] = '';
            $data['auth'] = '';
            if (!UserModel::create($data)) {
                return $this->error('添加失败');
            }
            return $this->success('添加成功');
        }

        $tab_data = [];
        $tab_data['menu'] = [
            ['title' => '添加用户'],
        ];
        $this->assign('menu_list', '');
        $this->assign('role_option', RoleModel::getOption());
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 2);
        return $this->fetch('userform');
    }
    /**
     * 修改个人信息
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function info()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['id'] = ADMIN_ID;
            // 防止伪造
            unset($data['role_id'], $data['status']);

            if ($data['password'] == '') {
                unset($data['password']);
            }
            // 验证
            $result = $this->validate($data, 'AdminUser.info');
            if($result !== true) {
                return $this->error($result);
            }

            if (!UserModel::update($data)) {
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }

        $row = UserModel::where('id', ADMIN_ID)->field('username,nick,email,mobile')->find()->toArray();
        $this->assign('data_info', $row);
        return $this->fetch();
    }

    /**
     * 删除用户
     * @param int $id
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function delBrand()
    {
        $ids   = input('param.ids/a');
        $model = new Brand();

        if ($model->del($ids)) {
            return $this->success('删除成功');
        }
        return $this->error($model->getError());
    }
   

    /**
    *轮播图管理
    **/
    public function brand($q='')
    {
        //$list = model('brand')->select();
      
        $sqlmap = [];
        if ($q) {
            $sqlmap['name'] = ['like', '%'.$q.'%'];
        }
        $data_list = Brand::where($sqlmap)->paginate();
        $pages = $data_list->render();
        $tab_data = $this->tab_data;
        $tab_data['current'] = url('');
        $this->assign('role_list', RoleModel::getAll());
        $this->assign('data_list', $data_list);
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 1);
        $this->assign('pages', $pages);
        return $this->fetch();
     
    }

    public function brandedit($id)
    {

        if ($this->request->isPost()) {
            $data = $this->request->post();

            if (!Brand::update($data)) {
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }

        $row = Brand::where('id', $id)->field('*')->find()->toArray();
        
        $tab_data = [];
        $tab_data['menu'] = [
            ['title' => '修改轮播图'],
            // ['title' => '设置权限'],
        ];

        $this->assign('menu_list', MenuModel::getAllChild());
        $this->assign('role_option', RoleModel::getOption());
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 2);
        $this->assign('data_info', $row);
        return $this->fetch();
    }

    public function brandadd()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            // $result = $this->validate($data, 'Brand');
            // if($result !== true) {
            //     return $this->error($result);
            // }
            //unset($data['id']);
            // $data['last_login_ip'] = '';
            // $data['auth'] = '';
            //$data['ishidden'] = 0;
            $data['addtime'] = time();
            //var_dump($data);
            if (!Brand::create($data)) {
                return $this->error('添加失败');
            }
            return $this->success('添加成功');
        }

        $tab_data = [];
        $tab_data['menu'] = [
            ['title' => '添加轮播图'],
        ];
        $this->assign('menu_list', '');
        $this->assign('role_option', RoleModel::getOption());
        $this->assign('tab_data', $tab_data);
        $this->assign('tab_type', 2);
        return $this->fetch();
    }



}
