<div class="layui-tab-item layui-show">

    

    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >

        <fieldset class="layui-elem-field layui-field-title">

          <legend>游戏等级设置</legend>

        </fieldset>

        <div class="layui-form-item">

            <label class="layui-form-label">等级范围</label>

            <div class="layui-input-inline">

                <input type="text" class="layui-input field-gradedown" name="gradedown" lay-verify="required" autocomplete="off" placeholder="低等级" >

            </div>

            <div class="layui-input-inline">

                <input type="text" class="layui-input field-gradeup" name="gradeup" lay-verify="required" autocomplete="off" placeholder="高等级" >

            </div>

        </div>

        <div class="layui-form-item">

            <label class="layui-form-label">1-2级经验值</label>

            <div class="layui-input-inline w300">

                <input type="text" class="layui-input field-emp" name="emp" lay-verify="required" autocomplete="off" placeholder="1-2级经验值"  >

            </div>

             

        </div>

        <div class="layui-form-item">

            <label class="layui-form-label">百分比-</label>

            <div class="layui-input-inline w200">

                <input type="text" class="layui-input field-emptage" name="emptage" lay-verify="required" autocomplete="off" placeholder="经验百分比" >

            </div>

            <div class="layui-form-mid layui-word-aux">%每升1级需要当前等级所需的经验再增加的百分比</div>

        </div>

        <div class="layui-form-item">

            <label class="layui-form-label">胜利经验</label>

            <div class="layui-input-inline w300">

                <input type="text" class="layui-input field-gainemp" name="gainemp" lay-verify="required" autocomplete="off" placeholder="获得经验值" >

            </div>

            <div class="layui-form-mid layui-word-aux">用户在游戏中中完成1次游戏胜利可获得经验值</div>

        </div>

        <div class="layui-form-item">

            <label class="layui-form-label">失败经验</label>

            <div class="layui-input-inline w300">

                <input type="text" class="layui-input field-filedtage" name="filedtage" lay-verify="required" autocomplete="off" placeholder="获得经验百分比" >

            </div>

            <div class="layui-form-mid layui-word-aux">%游戏失败时只能获得经验经验值</div>

        </div>

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