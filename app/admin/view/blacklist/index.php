<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">按手机号码查询:</label>
            <div class="layui-input-inline">
                <input type="text" name="phone" value="{:input('request.phone')}"  placeholder="请输入手机号码" autocomplete="off" class="layui-input">
            </div>
            <label class="layui-form-label">用户ID:</label>
            <div class="layui-input-inline">
                <input type="text" name="userid" value="{:input('request.userid')}"  placeholder="请输入会员ID搜索" autocomplete="off" class="layui-input" >
            </div>
            <button type="submit" class="layui-btn" lay-submit="" >查询</button>
        </div>
        </form>
    </div>
<form class="page-list-form">
    <div class="layui-btn-group fl">
        <a href="{:url('blackadd')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=blacklist&field=ishidden&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>禁用</a>
        <a data-href="{:url('status?table=blacklist&field=ishidden&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>失效</a>
        <a data-href="{:url('delblack')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th>ID</th>
                <th>名称</th>
                <th>添加时间</th>
                <th>状态</th>
                <th>备注</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}"class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>{$v['userid']}</td>
                <td>{$v['name']}</td>
                <td>{$v['addtime']|date="Y-m-d",###}</td>
                <td> 
                    {switch name="$v.ishidden"}
                        {case value ='0'}已禁用 {/case}
                        {case value ='1'}已失效 {/case}
                    {/switch}
                </td>
                <td>{$v['beizhu']}</td>
                <td>
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a href="{:url('blackedit?id='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <!-- <a href="{:url('log/index?uid='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small" title="查看操作日志"><i class="layui-icon">&#xe60e;</i></a> -->
                        <a data-href="{:url('delblack?ids='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
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