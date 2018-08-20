<div class="layui-fluid layui-bg-red">
  <fieldset class="layui-elem-field layui-field-title">
    <legend>合计：</legend>
  </fieldset>
  <div class="layui-row">
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">收入：{$count[0]['moneysum']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo">支出乐豆：{$count[0]['jifensum']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">充值人数：{$peocount}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo"></div>
    </div>
  </div>
  <fieldset class="layui-elem-field layui-field-title">

  </fieldset>
</div>

<div class="page-toolbar" style="overflow:visible" >
    <div class="page-filter fr" style="overflow:visible;float:left;height:50px;" >
        <form class="layui-form layui-form-pane" action="{:url()}" method="post" id="myform" >
        <div class="layui-form-item">
            <label class="layui-form-label">支付类型</label>
            <div class="layui-input-inline">
                <select name="type" class="field-level_id" type="select" >
                     <option value="">请选择支付类型</option>
                     <option value="1">微信</option>
                     <option value="2">支付宝</option>
                   
                     <option value="3">充值卡</option>
                </select>
            </div>
            <label class="layui-form-label">充值时间:</label>
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
            <button type="button" class="layui-btn"  id="xiazai" >下载表格</button>
           <!--  <a href="javascript:void(0)"  > 下载表格</a> -->
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
                <th>用户ID</th>
                <th>购买时间</th>
                <th>昵称</th>
                <th>手机号</th>
                <th>充值金额</th>
                <th>充值乐豆额</th>
                <th>剩余乐豆</th>
                <th>支付类型</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" {if condition="$vo['id'] eq 1"}disabled{else /}class="layui-checkbox checkbox-ids"{/if} lay-skin="primary"></td>
                      <td>{$vo['user_id']}</td>
                      <td>{$vo['create_time']}</td>
                      <td>{$vo['name']}</td>
                      <td>{$vo['phone']}</td>
                      <td>{$vo['money']}￥</td>
                      <td>+{$vo['num']}个</td>
                      <td>{$vo['jifen']}</td>
                      <td>
                            {switch name="$vo.type" }
                                {case value="1"}<span style="color: green" class="add">微信</span>{/case}
                                {case value="2"}<span style="color: red" class="del">支付宝</span> {/case}
                                {case value="3"}<span style="color: red" class="del">充值卡</span> {/case}
                            {/switch}
                      </td>
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
                    <th>ID</th>
                    <th>昵称</th>
                    <th>手机号</th>
                    <th>充值金额</th>
                    <th>充值乐豆额</th>
                    <th>剩余乐豆</th>
                    <th>支付类型</th>
                    <th>购买时间</th>
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
                      url:"{:url('gamelog/recharge_excel')}",
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
                                if(item.status == 1){state="微信"};
                                if(item.status == 2){state="支付宝"}; 

                                 Trhtml+=tempHtml.replace(/#id#/g,item.id).replace(/#name#/g,item.name).replace(/#mobile#/g,item.phone).replace(/#money#/g,item.money).replace(/#num#/g,item.num).replace(/#jifen#/g,item.jifen).replace(/#type#/g,state).replace(/#time#/g,item.create_time);
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