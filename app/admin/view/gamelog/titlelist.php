<div class="layui-fluid layui-bg-red">
  <fieldset class="layui-elem-field layui-field-title">
    <legend>合计：</legend>
  </fieldset>
  <div class="layui-row">
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">收入乐豆：{$count[0]['sumprice']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo">购买记录：{$count[0]['peosum']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">购买人数：{$peocount}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo"></div>
    </div>
  </div>
  <fieldset class="layui-elem-field layui-field-title">
    
  </fieldset>
</div>
<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get">
        <div class="layui-form-item">

            <label class="layui-form-label">充值时间:</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-starttime"  name="starttime" autocomplete="off" placeholder="开始时间" >
            </div>
         
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-endtime"  name="endtime" autocomplete="off" placeholder="结束时间"  >
            </div>

            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" name="uphone" value="{:input('get.uphone')}" placeholder="手机号" autocomplete="off" class="layui-input">
            </div>
            <button type="submit" class="layui-btn" lay-submit="" >查询</button>
        </div>
        </form>
    </div>
<form class="page-list-form">
    
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th>会员ID</th>
                <th>会员名</th>
                <th>手机号</th>
                <th>购买称号</th>
                <th>购买价格</th>
                <th>购买时间</th>
                
            </tr> 
        </thead>
        <tbody>
            {volist name="titary" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>{$v['uid']}</td>
                <td>{$v['uname']}</td>
                <td>{$v['phone']}</td>
                <td>{$v['name']}</td>
                <td>{$v['price']}</td>
                <td>{$v['addtime']|date="Y-m-d H:i:s",###}</td>
               
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
<script src="__STATIC__/js/jquery-1.10.2.min.js"></script>
<script src="__STATIC__/layer/layer.js"></script>
{include file="block/layui" /}


<script>
layui.use(['jquery', 'laydate'], function() {
    var $ = layui.jquery, laydate = layui.laydate;
    laydate.render({
        elem: '.field-starttime',
        type:'datetime'
    });
    laydate.render({
        elem: '.field-endtime',
        type:'datetime'
    });
});
</script>

