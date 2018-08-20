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

use think\Request;

/**

 * 后台用户、角色控制器

 * @package app\admin\controller

 */ 

class Money extends Admin

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

                'title' => '财务统计首页',

                'url' => 'admin/money/index',

            ],

        ];

        $this->tab_data = $tab_data;

    }

    

    /**

     * 统计管理

     * @author 橘子俊 <364666827@qq.com>

     * @return mixed

     */

    public function index()

    {

        /*

        *合计

        */

        $sum = Db::name('AutodayLog')->field('sum(RMB) as sumrmb,sum(jifenout) as sumjifen,sum(chipin) as sumchip')->where('status=0')->select();

        $this->assign('sum',$sum);

        /*

        *今日统计

        */

        $yesterday = strtotime(date("Y-m-d"),time());

        $today = time();

        //购买称号日统计 addtime    sumprice:收入 count  

        $titary = Db::name('TitleLog')->field('sum(price) as sumprice,count(id) as count')->where('addtime >'.$yesterday.' and addtime <'.$today)->select();

        //购买乐豆日统计 create_time 2018-06-09 16:11:10   UNIX_TIMESTAMP(create_time)

        $lebeans = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and ( type=1 or type=2 ) and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();

         //购买道具日统计 addtime    sumprice:收入 count  
        $toolsary = Db::name('tools_log')->field('sum(price) as sumprice,count(id) as count')->where('buy_time >'.$yesterday.' and buy_time <'.$today)->select();

        $lebeans_card = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and type=3 and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();

        $lebeans_wx = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and  type=1  and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();

        $lebeans_ali = Db::name('LebeansLog')->field('sum(money) as rmb, count(id) as count,sum(num) as sumnum')->where('status=1 and type=2 and UNIX_TIMESTAMP(create_time) >'.$yesterday.' and UNIX_TIMESTAMP(create_time) <'.$today)->select();

        //兑换油卡日统计 sumprice 总碎片  sumnum 总数量

        $cardary = Db::name('CardOrder')->field('sum(price) as sumprice,sum(num) as sumnum')->where('addtime >'.$yesterday.' and addtime <'.$today)->select();

        //统计好日志写入autoday_log表中

                                                                                                                                                                                                            

        $data1 = array();

        $data1['date'] =     date("Y-m-d",$today).'(今天)'; //日期



        $data1['RMB'] = $lebeans[0]['rmb']?$lebeans[0]['rmb']:0; // 总额 是否包含充值卡

        $data1['wxpay'] = $lebeans_wx[0]['rmb']?$lebeans_wx[0]['rmb']:0; //微信

        $data1['alipay'] = $lebeans_ali[0]['rmb']?$lebeans_ali[0]['rmb']:0; //支付宝

        $data1['cardpay'] = $lebeans_card[0]['sumnum']?$lebeans_card[0]['sumnum']:0; //充值卡充值的乐豆

        $data1['jifenout'] = $lebeans[0]['sumnum']? $lebeans[0]['sumnum']:0; // 现金充值乐豆

        $data1['titleout'] = $titary[0]['sumprice']?$titary[0]['sumprice']:0; //卖出称号

        $data1['toolsout'] = $toolsary[0]['sumprice']?$toolsary[0]['sumprice']:0; //卖出道具

        $data1['chipin'] = $cardary[0]['sumprice']?$cardary[0]['sumprice']:0;  //回收碎片

        $data1['cardnum'] = $cardary[0]['sumnum']?$cardary[0]['sumnum']:0;  //油卡数量

        $data1['addtime'] = time();



        $this->assign('today',$data1);



        $map=array();

        $map['status'] = 0;

        $request = input('request.');

        if (!empty($request['starttime']) && !empty($request['endtime'])) 

        {

            $keyword1 = strtotime($request['starttime']);

            $keyword2 = strtotime($request['endtime']);

            $map['addtime'] = array(array('>=',$keyword1),array('<=',$keyword2));

        }

        $data_list = Db::name('AutodayLog')->where($map)->order('id desc')->paginate();

        $pages = $data_list->render();

        $this->assign('data_list',$data_list);

        $this->assign('role_list', RoleModel::getAll());

        $this->assign('pages',$pages);                                                                                               

        return $this->fetch();

    }

    public function money_excel(){

            $request = input('param.');

            $usersQuery = Db::name('AutodayLog');

            $list = $usersQuery->order('id desc')->select();

            if($list)

            {

                    $result['status']=1;

                    $result['message']="成功";

                    $result['item'] = $list;

                    return json($result);

            }

            else

            {

                    $result['status']=0;

                    $result['message']="查询失败";

                    return json($result);

            }

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

    /*

    *充值卡代理商列表

    */

    public function agent()

    {

        return $this->fetch();

    }



    /*

    *充值卡列表

    */

    // public function agent()

    // {

    //     //return $this->fetch();

    // }



    /*

    *一键生成秘钥

    */

    public function addcard()

    {



        return $this->fetch();

    }

    //秘钥列表

    public function cardlist($q = '')

    {

        $sqlmap = [];

        if ($q) {

            $sqlmap['cardid'] = ['like', '%'.$q.'%'];

        }

        $data_list =Db::name('card')->where($sqlmap)->paginate();

        $pages = $data_list->render();



        $this->assign('data_list',$data_list);

        $this->assign('pages', $pages);

        return $this->fetch();

    }

    public function cardsave()

    {

        if ($this->request->isPost()) {

            $data = $this->request->post();

            $data['ctime'] =strtotime($data['ctime']);



            if($data['name']==''){

                 return $this->error('请填写秘钥名称!');

            }

            if($data['price']==''){

                 return $this->error('请填写秘钥面值!');

            }

            if($data['num']==''){

                 return $this->error('请填写秘钥数量!');

            }

            $flag = $this-> newcard($data['name'],$data['price'],$data['num'],$data['money'],$data['ctime']);

            if (!$flag) {

                return $this->error('添加失败！');

            }

            return $this->success('添加成功。');

        }

    }



    public function newcard($name,$price,$num,$money,$stoptime)

    {

        $ip = request()->ip();

        $login = session('admin_user');

        $data['addby'] = $login['nick'];

        $i=0;

        for($i;$i<$num;$i++){

            $data['cardname'] = $name;

            $data['cardid'] = $this->random();

            $data['price'] = $price;

            $data['money'] = $money;

            $data['stoptime'] = $stoptime;

            $data['addtime'] = time();

            $data['ip'] = $ip;

            $data['addby'] = $login['nick'];

            $flag = Db::name('card')->insert($data);

        }

        return $flag;

        

        die();

    }



    public function random()

    {

        $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';

        $hash = '';  

        $max = strlen($chars) - 1;  

        for($i = 0; $i < 10; $i++) {  

            $hash .= $chars[mt_rand(0, $max)];  

        }  

        return $hash; 

    }

    





  

 



  



  

 

  











}

