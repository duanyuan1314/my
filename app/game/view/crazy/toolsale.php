<form class="page-list-form">
<div class="page-toolbar">
   <!--   <div class="layui-btn-group fl">
            <a href="{:url('addtool')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
            <a data-href="{:url('status?table=LkTools&field=status&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
            <a data-href="{:url('status?table=LkTools&field=status&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
            <a data-href="{:url('del')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div> -->
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
       <!--  <colgroup>
            <col width="50">
            <col width="150">
            <col width="200">
            <col width="300">
            <col width="100">
            <col width="80">
            <col>
        </colgroup> -->
        <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>会员id</th>
                <th>会员昵称</th>
                <th>会员手机号</th>
                <th>消费编号</th>
                <th>消耗乐豆数量</th>
                <th>消耗前</th>
                <th>消耗后</th>
                <th>时间</th>
            </tr> 
        </thead>
        <tbody>
     
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" class="layui-checkbox checkbox-ids" name="ids[]" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo.userid}</td>
                <td>{$vo.username}</td>
                <td>{$vo.userphone}</td>
                <td>{$vo.ordernum}</td>
                <td><p style="color:red;" >-{$vo.ledou}<p/></td>
                <td>{$vo.before}</td>
                <td>{$vo.after}</td>
                <td>{$vo.addtime}</td>
            </tr>
            {/volist}
         
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="admin@block/layui" /}