<?php
namespace app\game\admin;
use app\admin\controller\Admin;
use think\Db;
class Crazy extends Base
{

	protected function _initialize()
    {
        parent::_initialize();

    }
    /*
    *参数设置
    */
    public function index()
    {
    	$first = db('LkGrade')->find(1);
    	$second = db('LkGrade')->find(2);
        $third = db('LkGrade')->find(3);
    	$fourth = db('LkGrade')->find(4);
    	$det = db('GameSetconfig')->find(1);
    	$this->assign('first',json_encode($first));
    	$this->assign('second',json_encode($second));
    	$this->assign('third',json_encode($third));
    	$this->assign('fourth',json_encode($fourth));
    	$this->assign('det',$det);
    	$this->assign('type','参数设置');
        return $this->fetch();
    }
    /*
    *参数保存
    */
    public function save()
    {
    	if ($this->request->isPost()) {
            $data = $this->request->post();
            $data1['name'] = $data['name'];
            $data1['max'] = $data['max'];
            $data1['min'] = $data['min'];
            $data1['addtime'] = time();
            $data1['grade'] = $data['grade']; 
            $data1['heidong'] = $data['heidong']; 
            $data1['relive'] = $data['relive']; 
            $data1['zimu'] = $data['zimu']; 
            $data1['reliveledou'] = $data['reliveledou']; 
            $log = db('GameSetconfig')->where('id=1')->update($data1);
            if($data['gradeid']){
	            $data2['gradeid'] = $data['gradeid'];
	            $data2['wgailv'] = $data['wgailv'];
	            $data2['fly'] = $data['fly'];
	            $data2['recover'] = $data['recover'];
	            $data2['shield'] = $data['shield'];
	            $data2['thank'] = $data['thank'];
	            $data2['addtime'] = time();
	            $log = $log && db('LkGrade')->where('gradeid ='.$data['gradeid'])->update($data2);
	        }
            if (!$log) {
                return $this->error('添加失败！');
            }
            return $this->success('应用成功');
        }
        return $this->error('保存失败！');	
    }
    /*
    *道具编辑
    */
    public function edittool($id=1)
    {
    	$det = db('lkTools')->find($id);
    	$this->assign('det',$det);
    	$this->assign('type','道具编辑');
    	return $this->fetch();
    }
    public function editsave()
    {
    	if($this->request->isPost()){
    		$data = $this->request->post();
    		$flag = db('lkTools')->where('id='.$data['id'])->update($data);
    		if($flag){
    			return $this->success('编辑成功',url('game/crazy/tools'));
    		}else{
    			return $this->error('编辑失败');
    		}
    	}
    	return $this->error('编辑失败');
    }
    /*
    *添加道具
    */
    public function addtool()
    {

    	$this->assign('type','添加道具');
    	return $this->fetch();
    }

    public function toolsave()
    {
    	if($this->request->isPost()){
    		$data = $this->request->post();
    		$data['addtime'] = time();
    		$flag = db('lkTools')->insert($data);
    		if($flag){
    			return $this->success('添加成功。',url('game/crazy/tools'));
    		}else{
    			return $this->error('保存失败');
    		}
    	}
    	return $this->error('保存失败');
    }

    /*
    *道具列表
    */
    public function tools()
    {

    	$data_list = Db::name('lkTools')->where('ishidden = 0')->paginate(15);
    	$pages = $data_list->render();
    	$this->assign('data_list',$data_list);
    	$this->assign('pages',$pages);
    	$this->assign('type','道具列表');
    	return $this->fetch();

    }

    /*
    * 游戏记录
    */
    public function history()
    {
    	$list = Db::name('jifen_log')->where('gamename = 8')->paginate(15);
    	$pages = $list->render();
    	$this->assign('pages',$pages);	
    	return $this->fetch();
    }

    /*
    *道具售卖列表	
    */
    public function toolsale()
    {
        $request = input('request.');
        $map = [];
        $map['j.type'] = 1;
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
    	$list = Db::name('lk_jifenlog')
    			->alias('j')
    			->join('user u','u.id=j.userid')
    			->field('j.*,u.name as username,u.phone as userphone')
    			->where($map)
    			->paginate(15);
    	$pages = $list->render();
    	$this->assign('list',$list);
    	$this->assign('pages',$pages);
    	return $this->fetch();
    }

    /*
    *游戏获取黑洞记录
    */
    public function relivelist()
    {
        $request = input('request.');
        $map = [];
        $map['j.type'] = 2;
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
    	$list = Db::name('lk_jifenlog')
    			->alias('j')
    			->join('user u','u.id=j.userid')
    			->field('j.*,u.name as username,u.phone as userphone')
    			->where($map)
    			->paginate(15);
    	$pages = $list->render();
    	$this->assign('list',$list);
    	$this->assign('pages',$pages);
    	return $this->fetch();
    }  
    public function jifenlist()
    {
        $request = input('request.');
        $map = [];
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
    	$list = Db::name('lk_jifenlog')
    			->alias('j')
    			->join('user u','u.id=j.userid')
    			->field('j.*,u.name as username,u.phone as userphone')
    			->where($map)
    			->paginate(15);
    	$pages = $list->render();
    	$this->assign('list',$list);
    	$this->assign('pages',$pages);
    	return $this->fetch();
    }      
    /*
    *R币记录
    */
    public function runlist()
    {

        $request = input('request.');
        $map = [];
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
        $list = Db::name('lk_runlog')
              ->alias('r')
              ->join('user u','u.id=r.userid')
              ->field('r.*,u.name as username,u.phone as userphone')
              ->where($map)
              ->paginate(15);
        $pages = $list->render();
        $this->assign('pages',$pages);
        $this->assign('list',$list);
        return $this->fetch();
    } 
     /*
    *用户消费记录
    */
    public function userlist()
    {

        $request = input('request.');
        $map = [];
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
        $list = Db::name('lk_gamelog')
              ->alias('r')
              ->join('user u','u.id=r.userid')
              ->field('r.*,u.name as username,u.phone as userphone,u.jifen')
              ->where($map)
              ->paginate(15);
        $data=$list->all();
        foreach($data as $k=>$v){
                $amout= $v['relive']+$v['tools'];
                $v['amout']=$amout;
                $list[$k]=$v;
        }
        $pages = $list->render();
        $this->assign('pages',$pages);
        $this->assign('list',$list);
        return $this->fetch();
    }     

}