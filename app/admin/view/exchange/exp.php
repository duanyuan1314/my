<div class="layui-tab-item layui-show">
    
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <fieldset class="layui-elem-field layui-field-title">
          <legend>碎片参数设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">兑换额度</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input field-examout" name="examout" lay-verify="required" autocomplete="off" placeholder="兑换油卡额度" >
            </div>
            <div class="layui-form-mid layui-word-aux">可兑换油卡的兑换券额度</div>
        </div>
       <!--  <div class="layui-form-item">
            <label class="layui-form-label">经验值+</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-gainemp" name="gainemp" lay-verify="required" autocomplete="off" placeholder="获得经验值" >
            </div>
            <div class="layui-form-mid layui-word-aux">用户在游戏中中完成1次游戏可获得经验值</div>
        </div> -->
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" >应用</button>
                <!-- <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a> -->
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script>
var formData = {:json_encode($data_info)};
</script>
<script src="__ADMIN_JS__/footer.js"></script>