<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>添加礼包</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">礼包名称</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-name" name="name" lay-verify="required" autocomplete="off" placeholder="礼包名称" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">获得方式</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-gifttype" name="gifttype" lay-verify="required" autocomplete="off" placeholder="获得方式" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">礼包内容</label>
            <div class="layui-input-inline w300">
               <textarea rows="6" class="layui-textarea field-content" name="content" autocomplete="off" placeholder="请填写礼包内容"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
            <div class="layui-input-inline">
                <input type="radio" class="field-status" name="status" value="1" title="上线" checked>
                <input type="radio" class="field-status" name="status" value="0" title="下线" >
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >应用</button>
                <a href="{:url('gift')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script>
var formData = {:json_encode($data_info)};

layui.use(['jquery', 'laydate'], function() {
    var $ = layui.jquery, laydate = layui.laydate;
    laydate.render({
        elem: '.field-ctime',
        min:'0'
    });
    $('#reset_expire').on('click', function(){
        $('input[name="ctime"]').val(0);
    });
});
</script>
<script src="__ADMIN_JS__/footer.js"></script>