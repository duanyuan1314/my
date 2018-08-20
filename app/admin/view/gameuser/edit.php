<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post" >
        <div class="layui-form-item">
            <label class="layui-form-label">用户编号</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['id']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户号</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  name="phone" value="{$data_info['phone']}" autocomplete="off"   >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录密码</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="********" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name" name="name" value="{$data_info['name']}" autocomplete="off"   >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">当前乐豆</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['jifen']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">当前称号</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['title_top']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经验值</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['exp']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">当前碎片</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['haschip']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">当前等级</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{$data_info['grade']}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name" name="real_name"  value="{$data['real_name']}" autocomplete="off"  >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name" name="card"  value="{$data['card']}" autocomplete="off"   >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">注册时间</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-name"  value="{:date('Y-m-d H:i:s',$data_info['addtime'])}" autocomplete="off"  disabled="disabled" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:120px;" >登录禁用说明</label>
            <div class="layui-input-inline w300">
                <input type="text" class="layui-input field-desc" value=" "   autocomplete="off"  >
            </div>
        </div>
        <!--图片-->
        <div class="layui-form-item" >
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
                <select name="status" class="field-role_id" type="select" >
                     <option value="1" {if condition="$data_info['status'] eq 1"}selected="selected"{/if} >启用</option>
                     <option value="2" {if condition="$data_info['status'] eq 2"}selected="selected"{/if} >禁用</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id" value="{$data_info['id']}" >
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
            </div>
        </div>
    </form>
</div>
{include file="block/layui" /}
