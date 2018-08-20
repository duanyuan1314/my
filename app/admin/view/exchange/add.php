<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>添加礼品碎片</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">礼品碎片</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-examout" name="examout" lay-verify="required" autocomplete="off" placeholder="礼品碎片" >
            </div>
            <div class="layui-form-mid layui-word-aux">枚</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">出现概率</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input field-probability" name="probability" lay-verify="required" autocomplete="off" placeholder="出现概率" >
            </div>
            <div class="layui-form-mid layui-word-aux">%</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
               <!--  <input type="hidden" class="field-id" name="id"> -->
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >应用</button>
                 <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script src="__ADMIN_JS__/footer.js"></script>