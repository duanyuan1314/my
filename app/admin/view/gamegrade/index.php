<div class="page-toolbar">
    <div class="page-filter fr">
        <form class="layui-form layui-form-pane" action="{:url()}" method="get" >
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
        <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=game_grade&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>显示</a>
        <a data-href="{:url('status?table=game_grade&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>隐藏</a>
        <a data-href="{:url('del?table=game_grade')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div> 
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row" >
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th>ID</th>
                <th>低等级</th>
                <th>高等级</th>
                <th>天数</th>
                <th>次数</th>
                <th>创建时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{$vo['id']}" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                      <td>{$vo['id']}</td>
                      <td>{$vo['gradeup']}</td>
                      <td>
                          {$vo['gradedown']}
                      </td>
                      <td>
                           {$vo['day']}
                      </td>
                       <td>
                           {$vo['time']}
                      </td>
                      <td>
                           {$vo.creat_time}
                      </td>
                      <td><input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="开启|禁用" data-href="{:url('status?table=game_grade&ids='.$vo['id'])}"></td>
                      <td>
                        <div class="layui-btn-group">
                            <div class="layui-btn-group">
                            <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
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