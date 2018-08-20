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
class Message extends Admin
{
    /**
     * 信息反馈
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function index($q = '')
    {
        $map = [];
        if ($q) {
            $map['phone'] = $q;
        }
        $data_list = DB::name('message')->where($map)->paginate(10);
        $data=$data_list->all();
        foreach($data as $k=>$v){
                $arr = explode(',',$v['imgurl']);
                $v['url']=$arr;
                $data_list[$k]=$v;
        }
       /*  var_dump($data_list); */
        // 分页
         $pages = $data_list->render(); 
         $this->assign('data_list', $data_list);
         $this->assign('pages', $pages);
        return $this->fetch();
    }
   
}
