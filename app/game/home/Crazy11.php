<?php
namespace app\game\home;
use app\common\controller\Common;
use think\Db;

/*
*疯狂链客
*/
class Crazy extends Base
{	

    public function index()
    {
    	var_dump(session('userid'));
    	echo 'index'; die();
        return $this->fetch();
    }

    /*
    *获取会员信息接口
    */
    public function getUser()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $userary = getUser(session('userid'));
        if($userary){
            $ret['code'] = '1';
            $ret['msg'] = '请求成功';
            $ret['data'] = $userary;
        }else{
            $ret['code'] = '0';
            $ret['msg'] = '请求失败';

        }
        return json_encode($ret);

    }
    /*
    *游戏开始调用，用来保存游戏日志
    */
    public function start()
    {                                       
            header("Access-Control-Allow-Origin:*");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Expose-Headers: FooBar");
            header("content-type:application/json");
            $orderNum = get_order_sn();
            /* 道具 */
            $tools = $this->toollist();
            $gameset = $this->getset();
            $data['userid'] = session('userid');
            $data['gameid'] = 8;
            $data['grade'] = $gameset['gradeid'];
            $data['addtime'] = time();
            $data['ordernum'] = $orderNum;
            $flag = db::name('LkGamelog')->insert($data);
            if($flag){
                $ret['code'] = '2';
                $ret['msg'] = '请求成功';
                $ret['ordernum'] = $orderNum;
                $ret['tools'] = $this->toollist();
                $ret['gameset'] = $this->getset();
                return json_encode($ret);
            } else {
                $ret['code'] = '0';
                $ret['msg'] = '请求失败';
                return json_encode($ret);
            }

    }   

    /*
    *游戏初始调用
    */
    public function getset()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $request = input('param.');
        $log = db('GameSetconfig')->where('id=1')->find();
        $det =  db('LkGrade')->where('gradeid ='.$log['grade'])->find();
        $res['gradeid']=$det['gradeid'];
        $res['blackdong']=8;
        $res['zimu']=8;
        return $res;
    }
    
    /*
    *黑洞调用接口
    */
    public function heidong()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $request = input('param.');
        if(!$request){
            $ret['code'] = '0';
            $ret['msg'] = '未传参';
            return json_encode($ret);
        }

        if(!$request['gradeid']){
            $ret['code'] = '0';
            $ret['msg'] = '缺少gradeid';
            return json_encode($ret);
        }
        $result = $this->zhuanpan($request['gradeid']);
        //增加写入记录
        $dataa['userid'] = session('userid');
        $dataa['ordernum'] = $request['ordernum'];
        $dataa['stepnum'] = $request['stepnum'];
        $dataa['result'] = $result; //转盘中奖结果id
        $dataa['beizhu'] = $request['beizhu'];   //转盘中奖备注
        $dataa['addtime'] = time(); 

        $flag = db::name('LkHeidonglog')->insert($dataa);

        if($flag){
            $ret['code'] = '3';
            $ret['msg'] = '请求成功';
            $ret['data']['result'] = $result;
        }else{
            $ret['code'] = '0';
            $ret['msg'] = '请求失败';
            
        }

        return json_encode($ret);
    }

    //转盘中奖返回 1:w字母中奖 2：飞行道具中奖 3：恢复生命 4：护盾 5：谢谢参与
    public function zhuanpan($gradeid='1')
    {   
        $gailv = Db::name('LkGrade')->where('gradeid='.$gradeid)->find();

        if(!$gailv){
            $ret['code'] = '0';
            $ret['msg'] = 'LkGrade未查询到数据';
            return json_encode($ret);
        }

        $rand = rand(1,100);

        if($rand<=$gailv['wgailv']){
            return 1;
        }else if($rand<=$gailv['wgailv']+$gailv['fly']){
            return 2;
        }else if($rand<=$gailv['wgailv']+$gailv['fly']+$gailv['recover']){
            return 3;
        }else if($rand<=$gailv['wgailv']+$gailv['fly']+$gailv['recover']+$gailv['shield']){
            return 4;
        }else{
            return 5;
        }
        return 0;
    }

    /*
    *获取道具功能
    */
    public function toollist()
    {

        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $list = Db::name('LkTools')->where('status = 1')->select();
        $arr =array();
        foreach($list as $v){
                $res['id']=$v['id'];
                $res['name']=$v['name'];
                $res['descript']=$v['descript'];
                $res['price']=$v['price'];
                $res['img']=YILIAN_URL.$v['image'];
                $arr[]=$res;
        }
        return  $arr;
    }

    
    //字母凑齐调用
    public function enouth()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");

        $request = input('param.');
        if(!$request){
            $ret['code'] = '0';
            $ret['msg'] = '未传参';
            return json_encode($ret);
        }
        
        //调用方法从钱包获得钱币
        $config = Db::name('GameSetconfig')->find(1);
        $max = $config['max']*100;
        $min = $config['min']*100;
        //随机获得金额
        $rand =0.01*rand($min,$max);  //区间
        
        //调用钱包地址获取金块打入个人钱包



        //增加写入记录
        $dataa['userid'] = session('userid');
        $dataa['ordernum'] = $request['ordernum'];
        $dataa['stepnum'] = $request['stepnum'];
        $dataa['run'] = $rand;
        $dataa['runaddress'] = '1111'; //个人钱包地址
        $dataa['runlogid'] = '2222'; //在线记录唯一识别码
        $dataa['status'] = 1;
        $dataa['isnew'] = 1;    
        $flag = db::name('LkRunlog')->insert($dataa);
        if($flag){
            $ret['code'] = '4';
            $ret['msg'] = '请求成功';
            $ret['data']['run'] = $rand;
            return json_encode($ret);
        }else{
            $ret['code'] = '0';
            $ret['msg'] = '请求失败';
            return json_encode($ret);
        }
    }
    public function lc($name='help',$ary=null){
         include_once "static/client.php";
         $jssdk = new \client("a5c","543","127.0.0.1","31253",5,array());  
         $signPackage = $jssdk->execute($name,$ary);  
         return $signPackage;
         
        /* $this->assign('signPackage',$signPackage); */
        /*  return $this->fetch(); */
    }
    /*
    *获取当前用户矿工地址 1：getaddressesbyaccount <account>   2：getnewaddress [account]
    */
    public function getuseradd()
    {
        $userary = getUser(session('userid'));
        if(!$userary['runaddress']){
            $ary = array();
            $ary[] = session('userid'); 
            $address = $this->lc('getaddressesbyaccount',$ary);
            if(!$address){
                $address = $this->lc('getnewaddress',$ary);
                $flag =Db::name('User')->where('id='.session('userid'))->setField('runaddress',end($address));
            }else{
                $flag =Db::name('User')->where('id='.session('userid'))->setField('runaddress',end($address));
            }
            return end($address);
        }else{
            return $userary['runaddress'];
        }

    }
    /*
    *发命令让主钱包向会员钱包转币,返回记录信息 保存本地
    *sendtoaddress <Letaochainaddress> <amount> [comment] [comment-to]
    *listtransactions [account] [count=10] [from=0]  根据userid 查询记录  * 是查所有 ，后接条数
    */
    public function setStart($userid,$rand)
    {
        $runaddress = $this->getuseradd();
        $ary = array();
        $ary[] = $runaddress;
        $ary[] =  $rand;
    }

    /*
    *根据本地保存的记录，定时查询在线钱包记录是否转出完成
    *完成后改变本地记录状态，给用户账户数字增加
    */
    public function check()
    {
       //校验完成给user表中runaddress 账户增加余额

    }
    /*
    *复活需要乐豆数
    *
    */
    public function needledou()
    {
        $userary=getUser(session('userid'));
        /* 复活参数 */
        $config = Db::name('GameSetconfig')->find(1);
        /* 用户复活次数 */
        if($userary['relivetime']!=0){
             $relive =$config['relive']+1;
             $pricemp =round(pow($relive, $userary['relivetime']),2);
             $price =$config['reliveledou']*$pricemp;
        }else{
             $price =$config['reliveledou'];
        }
        $ret['code'] = '7';
        $ret['needjifen'] =  $price;
        $ret['msg'] = '请求成功';
        return json_encode($ret);
    }
    /*
    *复活接口
    * toolid:5
    */
    public function relive()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $request = input('param.');
        if(!$request){
            $ret['code'] = '0';
            $ret['msg'] = '未传参';
            return json_encode($ret);
        }
        $orderNum=$request['ordernum'];

        $userary=getUser(session('userid'));
        /* 复活参数 */
        $config = Db::name('GameSetconfig')->find(1);
        /* 用户复活次数 */
        if($userary['relivetime']!=0){
             $relive =$config['relive']+1;
             $pricemp =round(pow($relive, $userary['relivetime']),2);
             $price =$config['reliveledou']*$pricemp;
        }else{
             $price =$config['reliveledou'];
        }
        if($userary['jifen']>=$price){
            $flag = db::name('user')->where('id='.session('userid'))->setDec('jifen',$price);
            db::name('user')->where('id='.session('userid'))->setInc('relivetime',1);
            if($flag){
                $re = $flag && jifenlog($orderNum,session('userid'),$price,0,1,'复活','一链到底-复活消耗',2);
                if($re){
                    $user = db::name('user')->where('id='.session('userid'))->find();
                    $ret['code'] = '6';
                    $ret['jifen'] =  $user['jifen'];
                    $ret['msg'] = '请求成功';
                    return json_encode($ret);
                }
            }
        }else{
                    $ret['code'] = '0';
                    $ret['msg'] = '余额不足';
                    return json_encode($ret);
        }
    }

    /*
    *购买道具接口
    * toolid:5
    */
    public function buytool()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");

        $request = input('param.');
        if(!$request){
            $ret['code'] = '0';
            $ret['msg'] = '未传参';
            return json_encode($ret);
        }
        $orderNum=$request['ordernum'];
        //type 校验等
        $userary=getUser(session('userid'));
        $det = Db::name('LkTools')->where('id='.$request['toolid'])->find();
        if($userary['jifen']>=$det['price']){
            $flag = db::name('user')->where('id='.session('userid'))->setDec('jifen',$det['price']);
            if($flag){
                $flag = $flag && jifenlog($orderNum,session('userid'),$det['price'],0,1,'购买'.$det['name'].'道具','一链到底-道具消耗',1);
                if($flag){
                    $user = db::name('user')->where('id='.session('userid'))->find();
                    $ret['code'] = '5';
                    $ret['jifen'] =  $user['jifen'];
                    $ret['msg'] = '请求成功';
                    return json_encode($ret);
                }
            }
        }else{
            $ret['code'] = '0';
            $ret['msg'] = '余额不足';
            return json_encode($ret);
        }
    }
    
    /*
    *游戏结束调用
    */
    public function gameover()
    {                                                                
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Expose-Headers: FooBar");
        header("content-type:application/json");
        $request = input('param.');
        $data['setpnum'] = $request['stepnum'];
        $flag = db::name('LkGamelog')->where('ordernum = '.$request['ordernum'])->update($data);
        $run_num = db('lk_runlog')->where('userid',session('userid'))->where('ordernum',$request['ordernum'])->sum('run');
        if($flag){
            db('user')->where('id',session('userid'))->setField('relivetime',0);
            $ret['code'] = '8';
            $ret['run'] = $run_num;
            $ret['msg'] = '保存成功';
            return json_encode($ret);
        } else {
            $ret['code'] = '0';
            $ret['msg'] = '保存失败';
            return json_encode($ret);
        }

    } 



}