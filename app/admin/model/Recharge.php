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
namespace app\admin\model;

use think\Model;
use app\admin\model\AdminMenu as MenuModel;
use app\admin\model\AdminRole as RoleModel;

/**
 * 后台用户模型
 * @package app\admin\model
 */
class Recharge extends Model
{
    // 定义时间戳字段名
    //protected $createTime = 'ctime';
    //protected $updateTime = 'addtime';

    // 自动写入时间戳
    //protected $autoWriteTimestamp = true;

    // 对密码进行加密
    // public function setPasswordAttr($value)
    // {
    //     return password_hash($value, PASSWORD_DEFAULT);
    // }

    // 写入时，将权限ID转成JSON格式
    // public function setAuthAttr($value)
    // {
    //     if (empty($value)) return '';
    //     return json_encode($value);
    // }

    // 获取最后登陆ip
    // public function setLastLoginIpAttr()
    // {
    //     return get_client_ip();
    // }

    /**
     * 删除用户
     * @param string $id 用户ID
     * @author 橘子俊 <364666827@qq.com>
     * @return bool
     */
    public function del($id = 0) 
    {
        //$menu_model = new MenuModel();
        if (is_array($id)) {
            $error = '';
            foreach ($id as $k => $v) {
                if ($v == ADMIN_ID) {
                    $error .= '不能删除当前登陆的用户['.$v.']！<br>';
                    continue;
                }

                if ($v == 1) {
                    $error .= '不能删除超级管理员['.$v.']！<br>';
                    continue;
                }

                if ($v <= 0) {
                    $error .= '参数传递错误['.$v.']！<br>';
                    continue;
                }

                $map = [];
                $map['id'] = $v;
                // 删除用户
                self::where($map)->delete();
                // 删除关联表;
                //$menu_model->delUser($v);
            }

            if ($error) {
                $this->error = $error;
                return false;
            }
        } else {
            $id = (int)$id;
            if ($id <= 0) {
                $this->error = '参数传递错误！';
                return false;
            }

            if ($id == ADMIN_ID) {
                $this->error = '不能删除当前登陆的用户！';
                return false;
            }

            // if ($id == 1) {
            //     $this->error = '不能删除超级管理员！';
            //     return false;
            // }

            $map = [];
            $map['id'] = $id;
            // 删除用户
            self::where($map)->delete();
            // 删除关联表
            //$menu_model->delUser($id);
        }

        return true;
    }

    

   
    

    /**
     * 数据签名认证
     * @param array $data 被认证的数据
     * @author 橘子俊 <364666827@qq.com>
     * @return string 签名
     */
    public function dataSign($data = [])
    {
        if (!is_array($data)) {
            $data = (array) $data;
        }
        ksort($data);
        $code = http_build_query($data);
        $sign = sha1($code);
        return $sign;
    }

    // /**
    //  * 用户状态设置
    //  * @param string $id 用户ID
    //  * @return bool
    //  */
    // public function status($id = '', $val = 0) {
    //     if (is_array($id)) {
    //         $error = '';
    //         foreach ($id as $k => $v) {
    //             $v = (int)$v;
    //             if ($v == 1) {
    //                 $error .= '禁止更改超级管理员状态['.$v.']<br>';
    //                 continue;
    //             }

    //             $map = [];
    //             $map['id'] = $v;
    //             // 删除用户
    //             self::where($map)->setField('status', $val);
    //         }

    //         if ($error) {
    //             $this->error = $error;
    //             return false;
    //         }
    //     } else {
    //         $id = (int)$id;
    //         if ($id <= 0) {
    //             $this->error = '参数传递错误';
    //             return false;
    //         }

    //         if ($id == 1) {
    //             $this->error = '禁止更改超级管理员状态';
    //             return false;
    //         }

    //         $map = [];
    //         $map['id'] = $id;
    //         // 删除用户
    //         self::where($map)->setField('status', $val);
    //     }

    //     return true;
    // }
}
