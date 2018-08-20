<div class="layui-tab-item layui-show">
    
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
          <legend>轮播图添加</legend>
        </fieldset>
       
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-username" name="name" lay-verify="title" autocomplete="off" placeholder="请输入用户名">
            </div>
           <!--  <div class="layui-form-mid layui-word-aux">表单操作提示</div> -->
        </div>
        <!--图片-->
        <div class="layui-form-item">
            <label class="layui-form-label">图片上传</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload" lay-type="image" lay-data="{accept:'image'}">请上传图片</button>
                <input type="hidden" class="upload-input" name="image" value="">
                <img src="" style="display:none;border-radius:5px;border:1px solid #ccc" width="36" height="36">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序 ID</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input " name="sortid" lay-verify="title" autocomplete="off" placeholder="请输入排序ID">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跳转路径</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input " name="url" lay-verify="title" autocomplete="off" placeholder="请输入URL">
            </div>
        </div>
       
       
        
      
       
      
       
        <div class="layui-form-item">
            <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
            <div class="layui-input-inline">
                <input type="radio" class="field-status" name="ishidden" value="0" title="启用">
                <input type="radio" class="field-status" name="ishidden" value="1" title="禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
               <!--  <input type="hidden" class="field-id" name="id"> -->
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>


{include file="block/layui" /}
<script>
/* 修改模式下需要将数据放入此变量 */
var formData = {"id":1,"role_id":1,"nick":"\u8d85\u7ea7\u7ba1\u7406\u5458","email":"chenf4hua12@qq.com","mobile":13888888888,"status":0};
// 会员选择回调函数
function func(data) {
    var $ = layui.jquery;
    $('input[name="member"]').val('['+data[0]['id']+']'+data[0]['username']);
}
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