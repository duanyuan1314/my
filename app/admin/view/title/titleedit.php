<div class="layui-tab-item layui-show">
    
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
          <legend>称号编辑</legend>
        </fieldset>
       
        <div class="layui-form-item">
            <label class="layui-form-label">称号名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="name" value="{$data_info['name']}" lay-verify="title" autocomplete="off" placeholder="请输入称号名">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">时长(天)</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="limittime" value="{$data_info['limittime']}" lay-verify="title" autocomplete="off" placeholder="如：30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经验倍数</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="beishu" value="{$data_info['beishu']}" lay-verify="title" autocomplete="off" placeholder="请输入经验倍数">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">原价(乐豆)</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="ledou" value="{$data_info['ledou']}" lay-verify="title" autocomplete="off" placeholder="请输入原价">
            </div>
        </div>
          <div class="layui-form-item">
            <label class="layui-form-label">奖励碎片</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="chip" value="{$data_info['chip']}" lay-verify="title" autocomplete="off" placeholder="请输入奖励碎片" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">现价(乐豆)</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="trueledou" value="{$data_info['trueledou']}" lay-verify="title" autocomplete="off" placeholder="请输入现价">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
            <div class="layui-input-inline">
                <input type="radio" class="field-ishidden" name="ishidden" value="0" title="启用" checked >
                <input type="radio" class="field-ishidden" name="ishidden" value="1" title="禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="" name="id" value="{$data_info['id']}">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script>
/* 修改模式下需要将数据放入此变量 */
var formData = {:json_encode($data_info)};
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