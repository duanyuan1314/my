<form class="page-list-form">
<div class="page-toolbar">
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>会员id</th>
                <th>会员昵称</th>
                <th>会员手机号</th>
                <th>会员当前乐豆</th>
                <th>复活消耗</th>
                <th>道具消耗</th>
                <th>消耗总额</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="list" id="vo"}
                <tr>
                    <td><input type="checkbox" class="layui-checkbox checkbox-ids" name="ids[]" value="{$vo['id']}" lay-skin="primary"></td>
                    <td>{$vo.userid}</td>
                    <td>{$vo.username}</td>
                    <td>{$vo.userphone}</td>
                    <td>{$vo.jifen}</td>
                    <td><span style="color:#e0892c;" >{$vo.relive}</span></td>
                    <td><span style="color:#e0892c;" >{$vo.tools}</span></td>
                    <td><span style="color:#1e9fff;" >{$vo.amout}</span></td>
                </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="admin@block/layui" /}