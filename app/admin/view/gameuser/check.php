<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['real_name']}" autocomplete="off"  disabled="disabled">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-desc" value="{$data_info['card']}"   autocomplete="off" disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-appurl"  value="{$data_info['real_phone']}"  autocomplete="off" disabled="disabled" >
            </div>
        </div>
        <!--图片-->
        <div class="layui-form-item">
         <!--    <label class="layui-form-label">身份证正面</label> -->
            <div class="layui-input-inline upload" style="width:400px;" >
                <img src="{$data_info['zcard']}" class="paly_a" data="1" style="border-radius:5px;border:1px solid #ccc;width:400px;height:250px;cursor:pointer;"  >
            </div>
            <div class="layui-form-mid layui-word-aux">身份证正面*</div>
            <div class="layui-form-mid layui-word-aux"><a  target="_blank" style="cursor:pointer;"  href="{$data_info['zcard']}" >查看原图</a></div>
        </div>
        <div class="layui-form-item">
           <!--  <label class="layui-form-label">身份证反面</label> -->
            <div class="layui-input-inline upload" style="width:400px;" >
                <img src="{$data_info['fcard']}" class="paly_a" data="2" style="border-radius:5px;border:1px solid #ccc;width:400px;height:250px;cursor:pointer;"  >
            </div>
            <div class="layui-form-mid layui-word-aux" style="color:#ff5722 !important;font-size:18px;" >身份证反面*</div>
            <div class="layui-form-mid layui-word-aux" style="color:#ff5722 !important;font-size:18px;" >
                <a  target="_blank" style="cursor:pointer;"  href="{$data_info['fcard']}" >查看原图</a>
            </div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
                <select name="isCheck" class="field-role_id" type="select" >
                     <option value="3">通过</option>
                     <option value="4">拒绝</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
                <label class="layui-form-label">拒绝原因</label>
                <div class="layui-input-inline" style="width:300px;"  >
                    <textarea rows="10" class="layui-textarea" name="refuse" autocomplete="off" placeholder="请填写拒绝原因" ></textarea>
                </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id" value="{$data_info['uid']}" >
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
<script src="__STATIC__/index/js/jquery.min.js"></script>
<script src="__STATIC__/layer/layer.js"></script>
<style>
    .layui-layer-iframe{top:10rem !important}
</style>
<script>
       
	    $(".paly_a").click(function(){
                /* var img =$(this).attr('src'); */
                var id =$('.field-id').val();
                var state =$(this).attr('data');
	            layer.open({
                                    skin: 'demo-class',
	                                type: 2,
	                                title: '查看',
	                                shadeClose: true,
	                                shade: 0.6,
	                                top:150,
	                                area: ['40%', '50%'],
	                                content: '{:url('index/layer/index')}?id='+id+'&state='+state //iframe的url
	            });               
	                                            
	    })
</script>
