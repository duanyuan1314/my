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
                <th>派币单号</th>
                <th>钱包地址</th>
                <th>交易标识</th>
                <th>run币</th>
                <th>状态</th>
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
                    <td><span style="color:#e0892c;" >{$vo.address}</span></td>
                    <td>{$vo.txtid}</td>
                    <td><p style="color:#009688;" >{$vo.amout}<p/></td>
                    <td>
                        {if condition="$vo.status eq 0" }
                                <span style="color:#0029ff" >交易审核中</span>
                            {else /}
                                <span style="color:#009688" >交易成功</span>
                        {/if}
                    </td>
                    <td>{$vo.addtime}</td>
                </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="admin@block/layui" /}