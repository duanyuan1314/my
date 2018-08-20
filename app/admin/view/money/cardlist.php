<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get">
        <div class="layui-form-item">
            <label class="layui-form-label">搜索</label>
            <div class="layui-input-inline">
                <input type="text" name="q" value="{:input('get.q')}" lay-verify="required" placeholder="请输入秘钥搜索" autocomplete="off" class="layui-input">
            </div>
        </div>
        </form>
    </div>
<form class="page-list-form">
    <div class="layui-btn-group fl">
        <a href="{:url('addcard')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
       
    </div>
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th>名称</th>
                <th>秘钥</th>
                <th>面值</th>
                <th>建议零售价</th>
                <th>添加时间</th>
                <th>添加人</th>
                <th>添加人IP</th>
                <th>是否兑换</th>
                
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>{$v['cardname']}</td>
                <td>{$v['cardid']}</td>
                <td>{$v['money']}</td>
                <td>{$v['price']}</td>
                <td>{$v['addtime']|date="Y-m-d H:i:s",###}</td>
                <td>{$v['addby']}</td>
                <td>{$v['ip']}</td>
                <td>
                    {switch name="$v.type"}
                        {case value ="0"}未售出 {/case} 
                        {case value ="1"}已售出 {/case}
                    {/switch}
                </td>
               
                   
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="block/layui" /}