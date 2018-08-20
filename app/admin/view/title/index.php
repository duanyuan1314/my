<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get">
        <div class="layui-form-item">
            <label class="layui-form-label">搜索</label>
            <div class="layui-input-inline">
                <input type="text" name="q" value="{:input('get.q')}" lay-verify="required" placeholder="请输入关键词搜索" autocomplete="off" class="layui-input">
            </div>
        </div>
        </form>
    </div>
<form class="page-list-form">
    <div class="layui-btn-group fl">
        <a href="{:url('titleadd')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=title&field=ishidden&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=title&field=ishidden&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('deltitle')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th>称号名称</th>
                <th>称号时长(天)</th>
                <th>经验倍数</th>
                <th>奖励碎片</th>
                <th>原价</th>
                <th>现价</th>
                <th>添加时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>{$v['name']}</td>
                <td>{$v['limittime']}</td>
                <td>{$v['beishu']}</td>
                <td>{$v['chip']}</td>
                <td>{$v['ledou']}</td>
                <td>{$v['trueledou']}</td>
                <td>{$v['addtime']|date="Y-m-d",###}</td>
                <td><input type="checkbox" name="status" {if condition="$v['ishidden'] eq 1"}checked=""{/if}  value="{$v['ishidden']}" lay-skin="switch" lay-filter="switchStatus" lay-text="下架|正常" data-href="{:url('status?table=title&field=ishidden&ids='.$v['id'])}"></td>
                <td>
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a href="{:url('titleedit?id='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <!-- <a href="{:url('log/index?uid='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small" title="查看操作日志"><i class="layui-icon">&#xe60e;</i></a> -->
                        <a data-href="{:url('deltitle?ids='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
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