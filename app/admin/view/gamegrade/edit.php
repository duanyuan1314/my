<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
          <legend>兑换等级编辑</legend>
        </fieldset>
         <div class="layui-form-item">
            <label class="layui-form-label">低等级</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-gradeup" name="gradeup" lay-verify="required"  autocomplete="off" placeholder="请输入低等级"  >
            </div>
         </div>
         <div class="layui-form-item">
            <label class="layui-form-label">高等级</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-gradedown" name="gradedown" lay-verify="required"  autocomplete="off" placeholder="请输入高等级"  >
            </div>
         </div>
         <div class="layui-form-item">
            <label class="layui-form-label">天数</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-day" name="day" lay-verify="required"  autocomplete="off" placeholder="请输入天数"  >
            </div>
         </div>
         <div class="layui-form-item">
            <label class="layui-form-label">兑换次数</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-time" name="time" lay-verify="required"  autocomplete="off" placeholder="请输入兑换次数"  >
            </div>
         </div>
         <div class="layui-form-item" >
                <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
                <div class="layui-input-inline">
                    <input type="radio" class="field-status" name="status" value="1" title="开启" checked >
                    <input type="radio" class="field-status" name="status" value="0" title="禁用" >
                </div>
          </div>
          <div class="layui-form-item" >
                <div class="layui-input-block" >
                    <input type="hidden" class="field-id" name="id" >
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
</script>
<script src="__ADMIN_JS__/footer.js"></script>