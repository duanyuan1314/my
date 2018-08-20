<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>游戏设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:150px;" >安卓版本号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input field-version" name="version" lay-verify="required" autocomplete="off" placeholder="APP版本号" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:150px;" >ios版本号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input field-ios" name="ios" lay-verify="required" autocomplete="off" placeholder="ios版本号" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:150px;" >APP分享海报</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload" lay-type="image" lay-data="{accept:'image'}">请上传图片</button>
                <input type="hidden" class="upload-input" name="url" value="{$data_info.url}" >
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <img src="{$data_info.url}" style="border-radius:5px;border:1px solid #ccc" id="img" >
        <div class="layui-form-item" style="margin-top:50px;" >
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id" >
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >应用</button>
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
    /**
     * 附件上传url参数说明
     * @param string $from 来源
     * @param string $group 附件分组,默认sys[系统]，模块格式：m_模块名，插件：p_插件名
     * @param string $water 水印，参数为空默认调用系统配置，no直接关闭水印，image 图片水印，text文字水印
     * @param string $thumb 缩略图，参数为空默认调用系统配置，no直接关闭缩略图，如需生成 500x500 的缩略图，则 500x500多个规格请用";"隔开
     * @param string $thumb_type 缩略图方式
     * @param string $input 文件表单字段名
     */
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
               /*  input.siblings('img').attr('src', res.data.file).show(); */
               $("#img").attr('src',res.data.file);
            }
            input.val(res.data.file);
        }
    });
});
</script>
<script src="__ADMIN_JS__/footer.js"></script>