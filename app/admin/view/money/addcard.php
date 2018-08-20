<div class="layui-tab-item layui-show">
    
    <form class="layui-form layui-form-pane" action="{:url('money/cardsave')}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>秘钥添加</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">卡片名称</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name" name="name" lay-verify="required" autocomplete="off" placeholder="">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数量</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-desc" name="num" lay-verify="required" autocomplete="off" placeholder="" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">面值</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-appurl" name="money" lay-verify="required" autocomplete="off" placeholder="：乐豆" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">建议售价</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-appurl" name="price" lay-verify="required" autocomplete="off" placeholder="：RMB" >
            </div>
        </div>
        
       <!--  <div class="layui-form-item">
            <label class="layui-form-label">icon图片</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload" lay-type="image" lay-data="{accept:'image'}">请上传图片</button>
                <input type="hidden" class="upload-input" name="icon" value="">
                <img src="" style="display:none;border-radius:5px;border:1px solid #ccc" width="36" height="36">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div> -->
        <div class="layui-form-item">
            <label class="layui-form-label">截止时间</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-ctime"   name="ctime" autocomplete="off" placeholder="请设置游戏上线时间" onclick="layui.laydate({elem: this,format:'YYYY-MM-DD'})" readonly>
            </div>
            <div class="layui-form-mid layui-word-aux"><a href="javascript:void(0);" id="reset_expire">点我设置为永久</a></div>
        </div>
       
       
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >一键生成</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
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
                input.siblings('img').attr('src', res.data.file).show();
            }
            input.val(res.data.file);
        }
    });
});
</script>

<script src="__ADMIN_JS__/footer.js"></script>