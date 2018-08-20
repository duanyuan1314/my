<form class="page-list-form">
<div class="page-toolbar">
     <div class="layui-btn-group fl">
            <a href="{:url('addtool')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
            <a data-href="{:url('status?table=LkTools&field=status&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
            <a data-href="{:url('status?table=LkTools&field=status&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
            <a data-href="{:url('del')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div>
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
                <th>购买时间</th>
                <th>价格</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
     
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" class="layui-checkbox checkbox-ids" name="ids[]" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo.beizhu}</td>
                <td>{$vo.userid}</td>
                <td>{$vo.username}</td>
                <td>{$vo.phone}</td>
                <td>{$vo.addtime|date='Y-m-d H:i:s',###}</td>
                <td>
                    <div class="layui-btn-group" >
                        <div class="layui-btn-group">
                      <!--   <a data-href="" class="layui-btn layui-btn-primary layui-btn-small">文字</a> -->
                        <a href="{:url('edittool?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <a data-href="{:url('del?table=LkTools&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
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
{include file="admin@block/layui" /}