<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get" >
        <div class="layui-form-item">
            <label class="layui-form-label">搜索</label>
            <div class="layui-input-inline">
                <input type="text" name="q" value="{:input('get.q')}" lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        </form>
    </div>
<form class="page-list-form" >
     <div class="layui-btn-group fl">
        <a data-href="{:url('del?table=message')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div> 
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row" >
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th>ID</th>
                <th>手机号</th>
                <th>反馈凭证</th>
                <th>反馈意见</th>
                <th>反馈时间</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody id="layer-photos-demo" >
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                      <td>{$vo['id']}</td>
                      <td>{$vo['phone']}</td>
                      <td class="font10">
                         {volist name="$vo.url" id="vs" }
                          <img src="{$vs}" width="50" height="50"  >
                         {/volist}
                      </td>
                      <td>{$vo['content']}</td>
                      <td>{$vo.addtime}</td>
                      <!-- <input type="hidden" class="field-id" name="id" value="{$vo['id']}" > -->
                      <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                              <a  class="layui-btn layui-btn-primary layui-btn-small paly_a" data="{$vo['id']}"  ><i class="layui-icon">&#xe642;</i></a>
                             <a data-href="{:url('del?table=message&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                            </div>
                        </div>
                     </td>
                </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="block/layui" /}
<script src="__STATIC__/index/js/jquery.min.js"></script>
<script src="__STATIC__/layer/layer.js"></script>
<script>
    //调用示例
    layer.ready(function(){ //为了layer.ext.js加载完毕再执行
        layer.photos({
            photos: '#layer-photos-demo'
            ,shift: 5 //0-6的选择，指定弹出图片动画类型，默认随机
        });
    });   
</script>
<style>
    body .demo-class .layui-layer-btn .layui-layer-btn1{background:#999;}
    .layui-layer-title{background-color: #20222A !important;color:#fff;}
    .layui-layer-iframe{top:15rem !important}
</style>
<script>
	    $(".paly_a").click(function(){
                var id =$(this).attr('data');
	            var index=layer.open({
                                    skin: 'demo-class',
	                                type: 2,
	                                title: '编辑回帖',
	                                shadeClose: true,
	                                shade: 0.6,
	                                top:150,
	                                area: ['40%', '50%'],
	                                content: '{:url('index/layer/huitie')}?id='+id //iframe的url
	            });               
	                                            
	    })
</script>
