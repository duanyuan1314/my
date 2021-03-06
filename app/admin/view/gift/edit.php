<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>礼品编辑</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">礼品名称</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name" name="name" lay-verify="required" autocomplete="off" placeholder="请输入礼品名称" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">礼品分类</label>
            <div class="layui-input-inline">
                <select name="type" class="field-role_id" type="select">
                    <option value="1" {if condition="$data_info['type'] eq 1"}selected="selected"{/if} >中石化</option>
                    <option value="2" {if condition="$data_info['type'] eq 2"}selected="selected"{/if} >中石油</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所需碎片</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-examout" name="examout" lay-verify="required" autocomplete="off" placeholder="所需碎片" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所需等级</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-grade" name="grade" lay-verify="required" autocomplete="off" placeholder="所需等级" >
            </div>
        </div>
        <!--图片-->
        <div class="layui-form-item">
            <label class="layui-form-label">图片上传</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload" lay-type="image" lay-data="{accept:'image'}">请上传图片</button>
                <input type="hidden" class="upload-input" name="image" value="{$data_info['image']}">
                <img src="{$data_info['image']}" style="border-radius:5px;border:1px solid #ccc" width="36" height="36">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
            <div class="layui-input-inline">
                <input type="radio" class="field-status" name="status" value="1" title="上线" checked >
                <input type="radio" class="field-status" name="status" value="0" title="下线">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id" >
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script>
var formData = {:json_encode($data_info)};
</script>
<script>
layui.use(['upload'], function() {
    var $ = layui.jquery, layer = layui.layer, upload = layui.upload;
    upload.render({
        elem: '.layui-upload'
        ,url: '{:url("admin/annex/upload?water=&thumb=&from=&group=")}'
        ,method: 'post'
        ,before: function(input) {
            layer.msg('文件上传中...', {time:3000000});
        },done: function(res, index, upload) {
            var obj = this.item;
            if (res.code == 0) {
                layer.msg(res.msg);
                return false;
            }
            layer.closeAll();
            var input = $(obj).parents('.upload').find('.upload-input');
            if ($(obj).attr('lay-type') == 'image') {
                input.siblings('img').attr('src', res.data.file).show();
            }
            input.val(res.data.file);
        }
    });
});
</script>

<script src="__ADMIN_JS__/footer.js"></script>