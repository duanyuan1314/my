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
class Gameuser extends Admin
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
                'title' => '用户列表',
                'url' => 'admin/gameuser/index',
            ],
        ];
        $this->tab_data = $tab_data;
    }
    public function index()
    {
        $request = input('request.');
        $map = [];
        if (!empty($request['type'])) 
        {
            $type =$request['type'];
            if($type ==1){
                $map['id'] = $request['keyword'];
            }
            if($type ==2){
                $map['name'] = $request['keyword'];
            }
            if($type ==3){
                $map['phone'] = $request['keyword'];
            }
        }
        if (!empty($request['ischeck'])) 
        {
            $map['isCheck'] = $request['ischeck'];
        }
        if (!empty($request['status'])) 
        {
             $map['status'] = $request['status'];
        }
        if (!empty($request['starttime']) && !empty($request['endtime'])) 
        {
            $word1 = $request['starttime'];
            $word2 = $request['endtime'];
            $map['addtime'] = array(array('>=',$word1),array('<=',$word2));
        }
        else if(!empty($request['endtime']))
        {
            $word = $request['endtime'];
            $map['addtime']    = ['ELT', "$word"];
        }
        else if(!empty($request['starttime']))
        {
            $keyword = $request['starttime'];
            $map['addtime']    = ['EGT', "$word"];
        }

        $data_list = DB::name('user')->where($map)->paginate(10, false,['query'=>$request]);
        // 分页
        $pages = $data_list->render();

        $this->assign('data_list', $data_list);

        $this->assign('pages', $pages);

        return $this->fetch();
    }
    /**
     * 会员列表
     * @author 张志远 <466180170@qq.com>
     * @return mixed
     */
    public function edit($id = 0)
    {
       if($this->request->isPost()) {
            $data = $this->request->post();
            $user_data['name']=$data['name'];
            $user_data['phone']=$data['phone'];
            $user_data['status']=$data['status'];
            $real_data['real_name']=$data['real_name'];
            $real_data['card']=$data['card'];
            db('user')->where('id',$data['id'])->update($user_data);
            db('real_user')->where('uid',$data['id'])->update($real_data);
            return $this->success('应用成功。',url('gameuser/index'));
        }
        $row = DB::name('user')->where('id', $id)->find();
        $res = DB::name('real_user')->where('uid', $id)->find();
        $this->assign('data', $res);
        $this->assign('data_info', $row);
        return $this->fetch();
    }
    public function check($id = 0)
    {
       if ($this->request->isPost()) {
            $data = $this->request->post();
            $status =$data['isCheck'];
            if($status==4){
                if($data['refuse'] == ''){
                    return $this->error('请填写拒绝原因!');
                }
                $res = db('user')->where('id',$data['id'])->update($data);
                if (!$res) {
                    return $this->error('修改失败!');
                }
                $data_info['uid']=$data['id'];
                $data_info['content']=$data['refuse'];
                $data_info['type']=1;
                $data_info['title']='实名认证通知';
                db('information')->insert($data_info);
                return $this->success('已拒绝',url('gameuser/index'));
            }
            if($status == 3){
                db('user')->where('id',$data['id'])->setField('isCheck',3);
                $data_info['uid']=$data['id'];
                $data_info['content']='恭喜您,您的实名已通过';
                $data_info['type']=2;
                $data_info['title']='实名认证通知';
                db('information')->insert($data_info);  
                return $this->success('审核通过。',url('gameuser/index'));
            }
        }
        $row = DB::name('real_user')->where('uid', $id)->find();
       
        $this->assign('data_info', $row);
        return $this->fetch();
    }

    public function status()
    {
        $id     = input('param.ids');
        $val    = input('param.val/d');
        if(empty($val)){
            $val =2;
        }
        $res = DB::name('user')->where('id', $id)->setField('status', $val);
        if ($res === false) {
            return $this->error('操作失败！');
        }
        return $this->success('操作成功！');
    }
    
   
}
