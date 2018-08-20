<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get" >
        <div class="layui-form-item">
            <label class="layui-form-label">搜索</label>
           <!--  <input type="submit" value="搜索"  > -->
            <div class="layui-input-inline">
                <input type="text" name="q" value="{:input('get.q')}" lay-verify="required" placeholder="请输入关键词搜索" autocomplete="off" class="layui-input">
            </div>
        </div>
        </form>
    </div>
<form class="page-list-form" >
     <div class="layui-btn-group fl">
        <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=game_list&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=game_list&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('del?table=game_list')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th>游戏ID</th>
                <th>板块名称</th>
                <th>主题广告语</th>
                <th>icon图片</th>
                <th>板块图片</th>
                <th>链接地址</th>
                <th>排序ID</th>
                <th>上线时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" {if condition="$vo['id'] eq 1"}disabled{else /}class="layui-checkbox checkbox-ids"{/if} lay-skin="primary"></td>
                      <td>{$vo['id']}</td>
                      <td>{$vo['name']}</td>
                      <td>{$vo['desc']}</td>
                      <td class="font10">
                        <img src="{if condition="$vo['icon']"}{$vo['icon']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="50" height="50" class="fl">
                      </td>
                      <td class="font10">
                        <img src="{if condition="$vo['image']"}{$vo['image']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="50" height="20" class="fl">
                      </td>
                      <td><a href="{$vo['appurl']}" >{$vo['appurl']}</a></td>
                      <td>{$vo['sortid']}</td>
                      <td>{:date('Y-m-d', $vo['ctime'])}</td>
                      <td><input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="上线|下线" data-href="{:url('status?table=game_list&ids='.$vo['id'])}"></td>
                      <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                            <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                            <a data-href="{:url('del?table=game_list&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
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