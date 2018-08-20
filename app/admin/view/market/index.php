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
<div class="page-toolbar" style="overflow:visible"  >
    <div class="page-filter fr" style="overflow:visible;height:50px;" >
        <form class="layui-form layui-form-pane" action="{:url()}" method="post" >
           
        <div class="layui-form-item">
            
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline" >
                <select name="status" class="field-level_id" type="select" >
                     <option value="" >全部状态</option>
                     <option value="1">待发货</option>
                     <option value="2">备货中</option>
                     <option value="3">已发货</option>
                     <option value="3">已完成</option>
                </select>
            </div>
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
            <button type="button" class="layui-btn"  id="xiazai" >下载表格</button>
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
                <th>用户ID</th>
                <th>兑换用户</th>
                <th>兑换数量</th>
                <th>兑换日期</th>
                <th>当前状态</th>
                <th>发货时间</th>
                <th>发货备注</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                      <td>{$vo['userid']}</td>
                      <td>{$vo['uphone']}</td>
                      <td>{$vo['num']}</td>
                      <td>{:date('Y-m-d H:i:s', $vo['addtime'])}</td>
                      <td>
                       {switch name="$vo.status"}
                            {case value="1"}已兑换,待备货{/case}
                            {case value="2"}<span style="color:#ff5722;" >备货中</span>{/case}
                            {case value="3"}<span style="color:#5fb878;" >已发货</span>{/case}
                            {case value="4"}确认收货{/case}
                        {/switch}
                      </td>
                      <td>{$vo['t_time']}</td>
                      <td>{$vo['beizhu']}</td>
                      <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                            {switch name="$vo.status"}
                             {case value="1"}
                                <a href="{:url('beihuo?id='.$vo['id'])}" class="layui-btn layui-btn-primary  j-tr-beihuo">备货</a>
                             {/case}
                             {case value="2"}
                                <a href="javascript:void(0);" class="layui-btn layui-btn-primary  j-tr-fahuo" data="{$vo['id']}" >发货</a>
                             {/case}
                             {/switch}
                            <a data-href="javascript:void(0);" class="layui-btn layui-btn-primary layui-btn-small j-tr-edit" data="{$vo['id']}"  >查看</a>
                            </div>
                        </div>
                     </td> 
                </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
<div style="display: none;" >
        <a download="乐豆充值记录.xls" href="" onclick="return  ExcellentExport.excel(this, 'exportdatainfo', '乐豆充值记录');"
            id="exportdata"></a>
        <table id="exportdatainfo">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>兑换用户</th>
                    <th>兑换数量</th>
                    <th>当前状态</th>
                    <th>兑换日期</th>
                    <th>发货时间</th>
                    <th>发货备注</th>
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
                      url:"{:url('market/market_excel')}",
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
                              var tempHtml="<tr><td>#id#</td><td>#mobile#</td><td>#num#</td><td>#type#</td><td>#time#</td><td>#htime#</td><td>#beizhu#</td></tr>";
                              var list = json.item; 
                              $.each(list,function(index,item){
                                 if(item.status == 1){state="待发货"};
                                 if(item.status == 2){state="备货"}; 
                                 if(item.status == 3){state="已发货"}; 
                                 Trhtml+=tempHtml.replace(/#id#/g,item.id).replace(/#mobile#/g,item.phone).replace(/#num#/g,item.num).replace(/#type#/g,state).replace(/#time#/g,item.creat_time).replace(/#htime#/g,item.t_time).replace(/#beizhu#/g,item.beizhu);
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
<script>
    $('.j-tr-beihuo').click(function() {
        var that = $(this),
        href = !that.attr('data-href') ? that.attr('href') : that.attr('data-href');
        layer.confirm('确定备货？', {title:false, closeBtn:0}, function(index){
            if (!href) {
                layer.msg('请设置data-href参数');
                return false;
            }
            $.get(href, function(res) {
                if (res.code == 0) {
                    layer.msg(res.msg);
                } else {
                    layer.msg(res.msg, {time: 1000},function() {
                         location.reload();
                    });
                }
            });
            layer.close(index);
        });
        return false;
    });
</script>
<style>
    .layui-layer-photos{top:10rem !important}
    .layui-layer-iframe{top:10rem !important}
    body .demo-class .layui-layer-btn .layui-layer-btn1{background:#999;}
    .layui-layer-title{background-color: #20222A !important;color:#fff;}
</style>
<script>
	    $(".j-tr-fahuo").click(function(){
                 var id = $(this).attr('data');
	             var index=layer.open({
                                    skin: 'demo-class',
	                                type: 2,
	                                title: '发货',
	                                shadeClose: true,
	                                shade: 0.6,
	                                top:150,
	                                area: ['40%', '75%'],
	                                content: '{:url('market/fahuo')}?id='+id
	            });         
	    })
        $(".j-tr-edit").click(function(){
                 var id = $(this).attr('data');
	             var index=layer.open({
                                    skin: 'demo-class',
	                                type: 2,
	                                title: '查看',
	                                shadeClose: true,
	                                shade: 0.6,
	                                top:150,
	                                area: ['40%', '75%'],
	                                content: '{:url('market/edit')}?id='+id
	            });         
	    })
</script>