<div class="layui-fluid layui-bg-red">
  <fieldset class="layui-elem-field layui-field-title">
    <legend>合计：</legend>
  </fieldset>
  <div class="layui-row">
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">兑换人数：{$peocount}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo">收入碎片：{$count[0]['sumprice']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">记录总数：{$count[0]['sumpeo']}</div>
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
        <form class="layui-form layui-form-pane" action="{:url()}" method="get" >


        <div class="layui-form-item">
            <label class="layui-form-label">兑换时间:</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-starttime"  name="starttime" autocomplete="off" placeholder="开始时间" >
            </div>
         
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-endtime"  name="endtime" autocomplete="off" placeholder="结束时间"  >
            </div>
            <label class="layui-form-label">按手机号码查询:</label>
            <div class="layui-input-inline">
                <input type="text" name="phone" value="{:input('request.phone')}"  placeholder="请输入手机号码" autocomplete="off" class="layui-input">
            </div>
            <!-- <label class="layui-form-label">搜索</label> -->
            <button type="submit" class="layui-btn" lay-submit="" >查询</button>
            
        </div>
        </form>
    </div>
<form class="page-list-form">
   
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row" >
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th>订单号</th>
                <th>用户ID</th>
                <th>用户手机号</th>
                <th>兑换时间</th>
                <th>收货人</th>
                <th>收货人手机号</th>
                <th>礼品名称</th>
                <th>礼品数量</th>
                <th>支付礼品碎片</th>
               <!--  <th>剩余礼品碎片</th> -->
                <th>状态</th>
                <!-- <th>操作</th> -->
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                      <td>{$vo['orderNum']}</td>
                      <td>{$vo['userid']}</td>
                      <td>{$vo['uphone']}</td>
                      <td>{:date('Y-m-d', $vo['addtime'])}</td>
                      <td>{$vo['receiver']}</td>
                      <td>{$vo['phone']}</td>
                      <td>{$vo['cardname']}</td>
                      <td>{$vo['num']}</td>
                      <td>{$vo['price']}</td>
                      <td>
                        {switch name="$vo.status"}
                            {case value="1"}已支付{/case}
                            {case value="2"}其他{/case}
                            {default /}无
                        {/switch}
                      </td>
                      <!--  <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                            <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                            <a data-href="{:url('del?table=game_list&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                            </div>
                        </div>
                     </td> -->
                </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
<div style="display: none;">
        <a download="乐豆充值记录.xls" href="" onclick="return  ExcellentExport.excel(this, 'exportdatainfo', '乐豆充值记录');"
            id="exportdata"></a>
        <table id="exportdatainfo">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>用户ID</th>
                    <th>兑换时间</th>
                    <th>收货人</th>
                    <th>收货人手机号</th>
                    <th>礼品名称</th>
                    <th>礼品数量</th>
                    <th>支付礼品碎片</th>
                </tr>
            </thead>
            <tbody id="tbodycontent" >
            </tbody>
        </table>
</div>
</form>
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
<script src="__STATIC__/js/jquery-1.10.2.min.js"></script>
<script src="__STATIC__/layer/layer.js"></script>
<script src="__STATIC__/exl/excellentexport.min.js" type="text/javascript"></script>
<script>
        $("#xiazai").click(function(){
        $.ajax({
                      url:"{:url('gamelog/exchange_excel')}",
                      data:$('#myform').serialize(),
                      type:'get',
                      dataType:'json',
                      success:function(json)
                      {
                          if(json.status == 1)
                          {
                             $("#tbodycontent").empty();
                              var Trhtml="";
                              var state = "";
                              var tempHtml="<tr><td>#id#</td><td>#name#</td><td>#mobile#</td><td>#money#</td><td>#num#</td><td>#jifen#</td><td>#type#</td><td>#time#</td></tr>";
                              var list = json.item; 
                              $.each(list,function(index,item){
                                /*  if(item.status == 1){state="微信"};
                                 if(item.status == 2){state="支付宝"};  */
                                 Trhtml+=tempHtml.replace(/#id#/g,item.orderNum).replace(/#name#/g,item.name).replace(/#mobile#/g,item.phone).replace(/#money#/g,item.money).replace(/#num#/g,item.num).replace(/#jifen#/g,item.jifen).replace(/#type#/g,state).replace(/#time#/g,item.create_time);
                               });
                               $("#tbodycontent").html(Trhtml); 
                               document.getElementById("exportdata").click();
                          }
                          else
                          {
                              layer.msg('没有信息!',{icon: 5,time:1000});
                          }  
                      }
                  });
        });
</script>