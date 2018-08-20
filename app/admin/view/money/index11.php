<div class="layui-fluid layui-bg-red">
  <fieldset class="layui-elem-field layui-field-title">
    <legend>合计(不包含今天)：</legend>
  </fieldset>
  <div class="layui-row">
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1">RMB：{$sum[0]['sumrmb']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo">卖出乐豆：{$sum[0]['sumjifen']}</div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo grid-demo-bg1"></div>
    </div>
    <div class="layui-col-sm3">
      <div class="grid-demo">消耗碎片：{$sum[0]['sumchip']}</div>
    </div>
  </div>
  <fieldset class="layui-elem-field layui-field-title">
    
  </fieldset>
</div>

<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get">

        <div class="layui-form-item">
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-starttime"  name="starttime" autocomplete="off" placeholder="开始时间" >
            </div>
         
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-endtime"  name="endtime" autocomplete="off" placeholder="结束时间"  >
            </div>
            <button type="submit" class="layui-btn" lay-submit="" >查询</button>
            <button type="button" class="layui-btn"  id="xiazai" >下载表格</button>
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
                <th>日期</th>
                <th>微信</th>
                <th>支付宝</th>
                <th>总RMB</th>
                <th>充值卡</th>
                <th>卖出乐豆</th>
                <th>卖出称号</th>
                <th>回收碎片</th>
    
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td> </td>
                <td>{$today['date']}</td>
                <td>{$today['wxpay']}</td>
                <td>{$today['alipay']}</td>
                <td>{$today['RMB']}</td>
                <td>{$today['cardpay']}</td>
                <td>{$today['jifenout']}</td>
                <td>{$today['titleout']}</td>
                <td>{$today['chipin']}</td> 
            </tr>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>{$v['date']}</td>
                <td>{$v['wxpay']}</td>
                <td>{$v['alipay']}</td>
                <td>{$v['RMB']}</td>
                <td>{$v['cardpay']}</td>
                <td>{$v['jifenout']}</td>
                <td>{$v['titleout']}</td>
                <td>{$v['chipin']}</td> 
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
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
                      url:"{:url('money/money_excel')}",
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
                               var list = json.item; 
                               $.each(list,function(index,item){
                               var tempHtml="<tr><td>#date#</td><td>#wxpay#</td><td>#alipay#</td><td>#RMB#</td><td>#cardpay#</td><td>#jifenout#</td><td>#titleout#</td><td>#chipin#</td></tr>";
                                 Trhtml+=tempHtml.replace(/#date#/g,item.date).replace(/#wxpay#/g,item.wxpay).replace(/#alipay#/g,item.alipay).replace(/#RMB#/g,item.RMB).replace(/#cardpay#/g,item.cardpay).replace(/#jifenout#/g,item.jifenout).replace(/#titleout#/g,item.titleout).replace(/#chipin#/g,item.chipin);
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