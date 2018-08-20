<?php
namespace app\index\controller;
use app\common\controller\Common;
use think\Db;
/*
*礼品页面
*/
class My extends Common
{
	//默认首页
	public function add_address($fromtype = '0')
	{	
		if(!session('fromtype')){
			session('fromtype',$fromtype);
		}
		return $this->fetch();
	}
	public function address($fromtype ='0',$cardid='0')
	{	
		session('fromtype',$fromtype);
		if($fromtype=='2'){
			session('cardid',$cardid);
		}
		
		$this->checkLogin();
		$list = Db::name('UserAddress')->where('ishidden =0 and userid ='.session('userid'))->select();
		//var_dump($list); die();
		$this->assign('list',$list);
		return $this->fetch();
	}
	public function edit_address($id='0'){
		if($id!='0'){
			$det = Db::name('UserAddress')->where('id',$id)->find();

			$this->assign('det',$det);
		}
		return $this->fetch();
	}
	/*
	*收货地址保存
	*/
	public function addSave()
	{
		$this->checkLogin();

		if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $data['userid'] = session('userid');
			$fag = Db::name('UserAddress')->where('userid',session('userid'))->find();
			if(!$fag){
				$data['isSelect']=1;
				$res = Db::name('UserAddress')->insert($data);
				if($res){
					if(session('fromtype')=='1'){
						session('fromtype',null);
						//die();
						$this->success('成功','index/gift/index');
						//$this->redirect(url('index/gift/index'));
					}else if(session('fromtype')=='2'){
						// /index/gift/confirm_order.html?id=2
						session('fromtype','');
						//session('cardid','');
						$this->success('成功', 'index/gift/confirm_order?id='.session('cardid'));
						
					}else{
						$this->success('成功', 'index/my/address');
					}
					$this->success('应用成功');
				}
			}else{
				if($data['isSelect']==1){

					Db::name('UserAddress')->where('userid',session('userid'))->setField('isSelect',0);
					$res = Db::name('UserAddress')->insert($data);
					
					if($res){
						if(session('fromtype')=='1'){
							session('fromtype',null);
							//die();
							$this->success('成功','index/gift/index');
							//$this->redirect(url('index/gift/index'));
						}else if(session('fromtype')=='2'){
							// /index/gift/confirm_order.html?id=2
							session('fromtype',null);
							//session('cardid','');
							$this->success('成功', 'index/gift/confirm_order?id='.session('cardid'));
							
						}else{
							$this->success('成功', 'index/my/address');
						}
						$this->success('应用成功');
					}
				}else{
					$res = Db::name('UserAddress')->insert($data);
					if($res){
						if(session('fromtype')=='1'){
							session('fromtype',null);
							//die();
							$this->success('成功','index/gift/index');
							//$this->redirect(url('index/gift/index'));
						}else if(session('fromtype')=='2'){
							// /index/gift/confirm_order.html?id=2
							session('fromtype',null);
							//session('cardid','');
							$this->success('成功', 'index/gift/confirm_order?id='.session('cardid'));
							
						}else{
							$this->success('成功', 'index/my/address');
						}
						$this->success('应用成功');
					}

				}
			}
        }
	}
	public function editSave()
	{
		$this->checkLogin();

		if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $data['userid'] = session('userid');
            $tempid = $data['id'];
            if($data['isSelect']==1){
					Db::name('UserAddress')->where('userid',session('userid'))->setField('isSelect',0);
					$res = Db::name('UserAddress')->where('id',$tempid)->update($data);
					if($res){
						if(session('fromtype')=='1'){
							session('fromtype','');
							//die();
							$this->success('成功','index/gift/index');
							//$this->redirect(url('index/gift/index'));
						}else if(session('fromtype')=='2'){
							// /index/gift/confirm_order.html?id=2
							session('fromtype','');
							//session('cardid','');
							$this->success('成功', 'index/gift/confirm_order?id='.session('cardid'));
							
						}
						$this->success('应用成功','index/my/address');
					}
				}else{
					Db::name('UserAddress')->where('id',$tempid)->setField('isSelect',1);
					$res = Db::name('UserAddress')->where('id',$tempid)->update($data);
					if($res){
						if(session('fromtype')=='1'){
							session('fromtype','');
							//die();
							$this->success('成功','index/gift/index');
							//$this->redirect(url('index/gift/index'));
						}else if(session('fromtype')=='2'){
							// /index/gift/confirm_order.html?id=2
							session('fromtype','');
							//session('cardid','');
							$this->success('成功', 'index/gift/confirm_order?id='.session('cardid'));
							
						}
						$this->success('应用成功','index/my/address');
					}

			}
		}	
		
	}

	function checkLogin()
    {
        if(!session('userid'))
        {
            $this->redirect(url('/index/login/index'));
        }else{
            $det = Db::name('user')->where('id',session('userid'))->find();
            return $det;
        }
	}
	public function del()
    {
       if ($this->request->isPost()) {
			$data = $this->request->post();
			$id = $data['id'];
            $log = DB::name('user_address')->where('id', $id)->delete();
            if (!$log) {
                return $this->error('删除失败！');
            }
            return $this->success('删除成功。');
        }
	}
	public function moren()
    {
       if ($this->request->isPost()) {
			$data = $this->request->post();
			$id = $data['id'];
			Db::name('UserAddress')->where('userid',session('userid'))->setField('isSelect',0);
			$log =Db::name('UserAddress')->where('id',$id)->setField('isSelect',1);
            if (!$log) {
                return $this->error('应用失败！');
            }
            return $this->success('应用成功。');
        }
    }
}