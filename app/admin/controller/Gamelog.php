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
use think\Request;
use think\Db;
/**
 * 会员管理控制器
 * @package app\admin\controller
 */
class Gamelog extends Admin
{

    protected function _initialize()
    {
        parent::_initialize();
    
        $tab_data['menu'] = [
            [
                'title' => '充值购买',
                'url' => 'admin/gamelog/index',
            ],
        ];
        $this->tab_data = $tab_data;
    }

    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function index()
    {
        $request = input('request.');
        $map = [];
        $map['l.status'] = 1;
        if (!empty($request['phone'])) 
        {
            $map['u.phone'] = $request['phone'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $keyword1 = $request['starttime'];
            $keyword2 = $request['endtime'];
            $map['create_time'] = array(array('>=',$keyword1),array('<=',$keyword2));
        }
        else if(!empty($request['endtime']))
        {
            $keyword = $request['endtime'];
            $map['create_time']    = ['ELT', "$keyword"];
        }
        else if(!empty($request['starttime']))
        {
            $keyword = $request['starttime'];
            $map['create_time']    = ['EGT', "$keyword"];
        }
        if (!empty($request['type'])) 
        {
            $map['l.type'] = $request['type'];
        } 
        $usersQuery = Db::name('lebeans_log');

        $count = $usersQuery->alias('l')
                           ->where($map)
                           ->field(' sum(l.num) as jifensum,sum(l.money) as moneysum,l.*,u.name,u.phone,u.jifen')
                           ->join('hisi_user u','u.id = l.user_id')
                           ->select();
        $peocount = $usersQuery->alias('l')
                           ->where($map)
                           ->field(' sum(l.num) as jifensum,sum(l.money) as moneysum,l.*,u.name,u.phone,u.jifen')
                           ->join('hisi_user u','u.id = l.user_id')
                           ->group('l.user_id')
                           ->count();

        $data_list = $usersQuery->alias('l')
                           ->where($map)
                           ->field('l.*,u.name,u.phone,u.jifen')
                           ->join('hisi_user u','u.id = l.user_id')
                           ->order('l.id desc')
                           ->paginate(10,false,['query'=>$request]);
        $pages = $data_list->render();
        $this->assign('count',$count);
        $this->assign('peocount',$peocount);

        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }
    public function exchange()
    {
        $request = input('param.');

        $map = [];
        if (!empty($request['phone'])) 
        {
            $map['u.phone'] = $request['phone'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $keyword1 = strtotime($request['starttime']);
            $keyword2 = strtotime($request['endtime']);
            $map['c.addtime'] = array(array('>=',$keyword1),array('<=',$keyword2));
        }

        //$data_list = DB::name('game_list')->where($map)->paginate(10, false, ['query' => input('get.')]);

        $count = DB::name('CardOrder')
                ->alias('c')
                ->join('hisi_user u','u.id=c.userid')
                ->field('sum(price) as sumprice,count(c.id) as sumpeo')
                ->where($map)->select();
        $peocount = DB::name('CardOrder')
                ->alias('c')
                ->join('hisi_user u','u.id=c.userid')
                ->field('c.*,u.phone as uphone')
                ->where($map)
                ->group('c.userid')
                ->count();

        $data_list = DB::name('CardOrder')
                ->alias('c')
                ->join('hisi_user u','u.id=c.userid')
                ->field('c.*,u.phone as uphone')
                ->where($map)->paginate(10, false, ['query' => input('get.')]);
        $pages = $data_list->render();
        $this->assign('peocount',$peocount);
        $this->assign('count',$count);
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }
    public function exchange_excel(){
            $request = input('param.');
            $map= [];
            if (!empty($request['phone'])) 
            {
                $map['u.phone'] = $request['phone'];
            }
            $usersQuery = Db::name('card_order');
            $list = $usersQuery->alias('l')
                           ->where($map)
                           ->field('l.*,u.name,u.phone,u.jifen')
                           ->join('hisi_user u','u.id = l.user_id')
                           ->order('l.id desc')
                           ->select();
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
    public function recharge_excel(){
            $request = input('param.');
            $map= [];
            if (!empty($request['phone'])) 
            {
                $map['u.phone'] = $request['phone'];
            }
            $usersQuery = Db::name('lebeans_log');
            $list = $usersQuery->alias('l')
                           ->where($map)
                           ->field('l.*,u.name,u.phone,u.jifen')
                           ->join('hisi_user u','u.id = l.user_id')
                           ->order('l.id desc')
                           ->select();
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


    /*
    *称号购买记录
    */
    public function titlelist()
    {
        $request = input('request.');
        $map = [];
       
        if (!empty($request['uphone'])) 
        {
            $map['u.phone'] = $request['uphone'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $keyword1 = strtotime($request['starttime']);
            $keyword2 = strtotime($request['endtime']);
            $map['t.addtime'] = array(array('>=',$keyword1),array('<=',$keyword2));
        }


        $count = Db::name('TitleLog')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('sum(t.price) as sumprice,count(t.id) as peosum,u.name as uname,u.phone,t.*')
            ->where($map)->select();
        $peocount = Db::name('TitleLog')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('u.name as uname,u.phone,t.*')
            ->where($map)
            ->group('t.uid')
            ->count();


        $ary = Db::name('TitleLog')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('u.name as uname,u.phone,t.*')
            ->where($map)->paginate();
        
        $pages = $ary->render();
        $this->assign('count',$count);
        $this->assign('peocount',$peocount);
        $this->assign('titary',$ary);
        $this->assign('pages',$pages);
        return $this->fetch();

    }
    public function tools()
    {
        $request = input('request.');
        $map = [];
       
        if (!empty($request['uphone'])) 
        {
            $map['u.phone'] = $request['uphone'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $keyword1 = strtotime($request['starttime']);
            $keyword2 = strtotime($request['endtime']);
            $map['t.buy_time'] = array(array('>=',$keyword1),array('<=',$keyword2));
        }
        $count = Db::name('tools_log')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('sum(t.price) as sumprice,count(t.id) as peosum,u.name as uname,u.phone,t.*')
            ->where($map)->select();
        $peocount = Db::name('tools_log')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('u.name as uname,u.phone,t.*')
            ->where($map)
            ->group('t.uid')
            ->count();
        $ary = Db::name('tools_log')->alias('t')
            ->join('user u','u.id=t.uid','LEFT')
            ->field('u.name as uname,u.phone,t.*')
            ->where($map)->paginate();
        $pages = $ary->render();
        $this->assign('count',$count);
        $this->assign('peocount',$peocount);
        $this->assign('titary',$ary);
        $this->assign('pages',$pages);
        return $this->fetch();

    }
    
   
}
