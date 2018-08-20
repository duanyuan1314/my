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
        <a href="{:url('brandadd')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=brand&field=ishidden&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=brand&field=ishidden&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('delBrand')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th>图片</th>
                
                <th>排序ID</th>
                <th>跳转路径</th>
                <th>添加时间</th>
               
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" {if condition="$v['id'] eq 1"}disabled{else /}class="layui-checkbox checkbox-ids"{/if} lay-skin="primary"></td>
                <td>{$v['name']}</td>
                <td><img src="{$v['image']}" width="200"></td>
                <td>{$v['sortid']}</td>
               
                <td>{$v['url']}</td>
                <td>{$v['addtime']|date="Y-m-d",###}</td>
                
                <td><input type="checkbox" name="status" {if condition="$v['ishidden'] eq 1"}checked=""{/if} {if condition="$v['id'] eq 1"}disabled{/if} value="{$v['ishidden']}" lay-skin="switch" lay-filter="switchStatus" lay-text="下架|正常" data-href="{:url('status?table=brand&field=ishidden&ids='.$v['id'])}"></td>
                <td>
                    {if condition="ADMIN_ID neq 1 && $v['id'] eq 1"}
                    {else /}
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a href="{:url('brandedit?id='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <!-- <a href="{:url('log/index?uid='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small" title="查看操作日志"><i class="layui-icon">&#xe60e;</i></a> -->
                        <a data-href="{:url('delBrand?ids='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                        </div>
                    </div>
                    {/if}
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
{include file="block/layui" /}