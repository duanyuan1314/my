<?php
namespace app\game\admin;
use app\admin\controller\Admin;
use think\Db;


class Base extends Admin
{
    public function index()
    {
    	
        return $this->fetch();
    }

    /**
     * 获取当前方法URL
     * @author 橘子俊 <364666827@qq.com>
     * @return string
     */
    protected function getActUrl() {
        $model      = request()->module();
        $controller = request()->controller();
        $action     = request()->action();
        return $model.'/'.$controller.'/'.$action;
    }

    /**
     * 通用状态设置
     * 禁用、启用都是调用这个内部方法
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function status() {
        
        $val   = input('param.val');
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $field = input('param.field', 'status');
        if (empty($ids)) {
            return $this->error('参数传递错误[1]！');
        }
        if (empty($table)) {
            return $this->error('参数传递错误[2]！');
        }
        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_user' || $table == 'admin_role' || $table == 'admin_module') {
            if (in_array('1', $ids) || ($table == 'admin_menu' && in_array('2', $ids))) {
                return $this->error('系统限制操作');
            }
        }
         // 获取主键
        $pk = Db::name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = Db::name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('状态设置失败');
        }
        return $this->success('状态设置成功');
    }

    /**
     * 通用删除
     * 单纯的记录删除
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function del() {
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        if (empty($ids)) {
            return $this->error('无权删除(原因：可能您选择的是系统菜单)');
        }
        // 禁止以下表通过此方法操作
        if ($table == 'admin_user' || $table == 'admin_role') {
            return $this->error('非法操作');
        }

        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_module') {
            if ((is_array($ids) && in_array('1', $ids))) {
                return $this->error('禁止操作');
            }
        }
            
        // 获取主键
        $pk = Db::name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = Db::name($table)->where($map)->delete();
        if ($res === false) {
            return $this->error('删除失败');
        }
        return $this->success('删除成功');
    }

    /**
     * 通用排序
     * @author 橘子俊 <364666827@qq.com>
     * @return mixed
     */
    public function sort() {
        $ids   = input('param.ids/d') ? input('param.ids/d') : input('param.id/d');
        $table = input('param.table');
        $field = input('param.field/s', 'sort');
        $val   = input('param.val/d');
        // 获取主键
        $pk = Db::name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];
        $res = Db::name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('排序设置失败');
        }
        return $this->success('排序设置成功');
    }
}