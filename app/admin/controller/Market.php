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
class Market extends Admin
{

    protected function _initialize()
    {
        parent::_initialize();
    
        $tab_data['menu'] = [
            [
                'title' => '兑换用户列表',
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
        $request = input('param.');

        $map = [];
        if (!empty($request['phone'])) 
        {
            $map['u.phone'] = $request['phone'];
        }
        if (!empty($request['status'])) 
        {
            $map['c.status'] = $request['status'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $keyword1 = strtotime($request['starttime']);
            $keyword2 = strtotime($request['endtime']);
            $map['c.addtime'] = array(array('>=',$keyword1),array('<=',$keyword2));
        }
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
    public function market_excel(){
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
                           ->join('hisi_user u','u.id = l.userid')
                           ->order('l.id desc')
                           ->select();
            $arr =array();
            foreach($list as $k=>$v){
                   $v['creat_time']= date("Y-m-d H:i:s",$v['addtime']); 
                   $arr[]=$v;
            }
            if($list)
            {
                    $result['status']=1;
                    $result['message']="成功";
                    $result['item'] = $arr;
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
    public function beihuo()
    {
            $id  = input('param.id');
            $res = DB::name('card_order')->where('id', $id)->setField('status', 2);
            if ($res === false) {
                return $this->error('操作失败！');
            }
            return $this->success('应用成功');
    }
    public function fahuo()
    {
            if($this->request->isPost()){
                  $data = $this->request->post();
                  $data_card['beizhu']=$data['beizhu'];
                  $data_card['tracking']=$data['tracking'];
                  $data_card['type']=$data['type'];
                  $data_card['status']=3;
                  $re = Db::name('card_order')->where('id',$data['id'])->update($data_card);
                  if($re){
                          $data_info['uid']=$data['uid'];
                          $data_info['content']=$data['beizhu'];
                          $data_info['type']=4;
                          $data_info['title']='订单消息';
                          db('information')->insert($data_info);
                          $data_log['cid']=$data['id'];
                          $data_log['uid']=$data['uid'];
                          $data_log['beizhu']=$data['beizhu'];
                          $data_log['tracking']=$data['tracking'];
                          $data_log['type']=$data['type'];
                          db('card_log')->insert($data_log);
                          return $this->success('发货成功');
                  }
	        }
            $request = input('param.');
            $id = $request['id'];
            $data_list = DB::name('CardOrder')
                ->alias('c')
                ->join('hisi_user u','u.id=c.userid')
                ->field('c.*,u.phone,u.name')
                ->where('c.id',$id)->find();
            $this->assign('data_info', $data_list);
            $this->view->engine->layout(false);
            return $this->fetch();     
    }
    public function edit()
    {
          if($this->request->isPost()){
                  $data = $this->request->post();
                  $data_card['beizhu']=$data['beizhu'];
                  $data_card['tracking']=$data['tracking'];
                  $data_card['type']=$data['type'];
                  Db::name('card_order')->where('id',$data['id'])->update($data_card);
                  
                          $data_log['cid']=$data['id'];
                          $data_log['uid']=$data['uid'];
                          $data_log['beizhu']=$data['beizhu'];
                          $data_log['tracking']=$data['tracking'];
                          $data_log['type']=$data['type'];
                          db('card_log')->insert($data_log);
                          return $this->success('应用成功');
                  
	        }
            $request = input('param.');
            $id = $request['id'];
            $data_list = DB::name('CardOrder')
                ->alias('c')
                ->join('hisi_user u','u.id=c.userid')
                ->field('c.*,u.phone,u.name')
                ->where('c.id',$id)->find();
            $this->assign('data_info', $data_list);
            $this->view->engine->layout(false);
            return $this->fetch();
    }
   
}
