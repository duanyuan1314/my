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
        <a href="{:url('getnew')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>更新</a>
        <a data-href="{:url('status?table=toplist&field=ishidden&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=toplist&field=ishidden&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('deltop')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
              <!--   <th>排名</th> -->
                <th>用户ID</th>
                <th>昵称</th>
                <th>手机号</th>
                <th>用户头像</th>
                <th>注册时间</th>
                <th>赚取总额</th>
                <th>最近上线时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="v"}
            <tr>
                <td><input type="checkbox" name="ids[]" value="{$v['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
               <!--  <td>{$v['id']}</td> -->
                <td>{$v['userid']}</td>
                <td>{$v['name']}</td>
                <td>{$v['mobile']}</td>
                <th><img  src="{if condition="$v['avatar']"}{$v['avatar']}{else /}https://img.yilian.lefenmall.com/app/icon/avatar.png{/if}" width="30" height="30" ></th>
                <td>{$v['datetime']|date="Y-m-d H:i:s",###}</td>
                <td>{$v['sum']}</td>
                <td>{$v['addtime']|date="Y-m-d H:i:s",###}</td>
                <td><input type="checkbox" name="status" {if condition="$v['ishidden'] eq 1"}checked=""{/if} {if condition="$v['id'] eq 1"}disabled{/if} value="{$v['ishidden']}" lay-skin="switch" lay-filter="switchStatus" lay-text="下架|正常" data-href="{:url('status?table=brand&field=ishidden&ids='.$v['id'])}"></td>
                <td>  
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a data-href="{:url('deltop?ids='.$v['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
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