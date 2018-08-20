<div class="page-toolbar" style="overflow:visible" >
    <div class="page-filter fr" style="overflow:visible;height:50px;" >
        <form class="layui-form layui-form-pane" action="{:url()}" method="post" >
        <div class="layui-form-item">
            <label class="layui-form-label">注册时间:</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-starttime"  name="starttime" autocomplete="off" placeholder="开始时间" >
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-endtime"  name="endtime" autocomplete="off" placeholder="结束时间"  >
            </div>
            <label class="layui-form-label">审核状态</label>
            <div class="layui-input-inline">
                <select name="ischeck" class="field-level_id" type="select" >
                     <option value="" >全部</option>
                     <option value="5">没有认证</option>
                     <option value="2">需要审核</option>
                     <option value="3">审核通过</option>
                     <option value="4">审核失败</option>
                     <option value="6">重新审核</option>
                </select>
            </div>
            <div class="layui-input-inline" >
                <select name="status" class="field-level_id" type="select" >
                     <option value="" >全部状态</option>
                     <option value="2">禁用</option>
                     <option value="1">启用</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="type" class="field-level_id" type="select" >
                     <option value="" >全部</option>
                     <option value="1">用户ID</option>
                     <option value="2">昵称</option>
                     <option value="3">手机号</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <input type="text" name="keyword" value="{:input('request.keyword')}"  placeholder="请输入查询内容" autocomplete="off" class="layui-input">
            </div>
            <button type="submit" class="layui-btn" lay-submit="" >查询</button>
        </div>
        </form>
    </div>
<form class="page-list-form">
     <div class="layui-btn-group fl">
       <!--  <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a> -->
        <a data-href="{:url('status?table=user&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=user&val=2')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('del?table=user')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div> 
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" ></th>
                <th>用户ID</th>
                <th>昵称</th>
                <th>手机号</th>
                <th>用户头像</th>
                <th>注册时间</th>
                <th>乐豆</th>
                <th>礼品碎片</th>
                <th>认证状态</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody id="layer-photos-demo" >
            {volist name="data_list" id="vo"}
                <tr>
                      <td><input type="checkbox" name="ids[]" value="{$vo['id']}"  class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                      <td>{$vo['id']}</td>
                      <td>{$vo['name']}</td>
                      <td>{$vo['phone']}</td>
                      <td class="font10"  >
                         <img src="{if condition="$vo['avatar']"}{$vo['avatar']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="40" height="40" class="fl">
                      </td>
                      <td>{$vo['addtime']|date="Y-m-d H:i:s",###}</td>
                      <td>{$vo['jifen']}</td>
                      <td>{$vo['haschip']}</td>
                      <td>
                          {switch name="$vo.isCheck" } 
                                {case value="5"}
                                    <div class="mui-pull-right"  >
                                        没有认证
                                    </div>
                                {/case}
                                {case value="1"}
                                     <div class="mui-pull-right"  >
                                        <a href="javascript:void(0);" style="color:#bbaa24;"  >无证件照片</a> 
                                     </div>
                                {/case}
                                {case value="2"}
                                     <div class="mui-pull-right"  >
                                        <a href="{:url('check?id='.$vo['id'])}" style="color:#ff5722;" >需要审核</a> 
                                    </div>
                                {/case}
                                {case value="3"}
                                    <div class="mui-pull-right"  style="color:#009688;" >
                                         已通过
                                    </div>
                                    <a href="{:url('check?id='.$vo['id'])}" style="color:#1eb3ef;" >实名认证</a>
                                {/case}
                                {case value="4"}
                                    <div class="mui-pull-right"  style="color:#f7561e;" >
                                         审核失败 
                                    </div>
                                    <a class="paly_a" style="cursor:pointer;" data="{$vo.refuse}" >拒绝理由</a>
                                {/case}
                                {case value="6"}
                                    <div class="mui-pull-right">
                                        <a href="{:url('check?id='.$vo['id'])}" style="color:#009688;" >重新审核</a> 
                                    </div>
                                    <a class="paly_a" style="cursor:pointer;" data="{$vo.refuse}" >拒绝理由</a>
                                {/case}
                            {/switch}
                      </td>
                       <td>
                           <input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|禁用" data-href="{:url('status?ids='.$vo['id'])}"></td>
                       <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                                <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                               <!--  <a data-href="{:url('del?table=game_list&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a> -->
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
<script>
	    $(".paly_a").click(function(){
                 var img =$(this).attr('data'); 
                 layer.open({
                    type: 1,
                    area: ['600px', '360px'],
                    shadeClose: true, //点击遮罩关闭
                    content: '\<\div style="padding:20px;">'+img+'\<\/div>'
                });
	    })
</script>



