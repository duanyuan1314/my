<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>后台手动充值</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">用户手机号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="phone" lay-verify="required" autocomplete="off" placeholder="用户手机号" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">乐豆</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input" name="ledou" lay-verify="required" autocomplete="off" placeholder="乐豆" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">碎片</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input" name="haschip" lay-verify="required" autocomplete="off" placeholder="碎片" >
            </div>
    
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >应用</button>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script src="__ADMIN_JS__/footer.js"></script>