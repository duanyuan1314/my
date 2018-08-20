<div class="layui-collapse page-tips">
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">温馨提示</h2>
    <div class="layui-colla-content">
      <p>不熟悉的人不要修改</p>
    </div>
  </div>
</div>

<form class="layui-form layui-form-pane" action="{:url('save')}" id="editForm" method="post">
    <fieldset class="layui-elem-field layui-field-title">
      <legend>{$type}</legend>
    </fieldset> 

    <div class="layui-form-item">
        <label class="layui-form-label">难度设置</label>
        <div class="layui-input-inline">
            <select name="grade" lay-filter="test" class="field-role_id" type="select">
               
                <option value="1" {if condition="$det.grade eq '1'"} selected="selected" {else /} {/if} >简单</option>
                <option value="2" {if condition="$det.grade eq '2'"} selected="selected" {else /} {/if} >一般</option>
                <option value="3" {if condition="$det.grade eq '3'"} selected="selected" {else /} {/if} >困难</option>
                <option value="4" {if condition="$det.grade eq '4'"} selected="selected" {else /} {/if} >特难</option>
            </select>
        </div>
    </div>  
    <div class="layui-form-item">
        <label class="layui-form-label">游戏名字</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="name" value="{$det.name}" lay-verify="title" autocomplete="off" placeholder="请输入游戏名">
        </div>
        <div class="layui-form-mid layui-word-aux">表单操作提示</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">金块峰值</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="max" value="{$det.max}" lay-verify="title" autocomplete="off" placeholder="金块峰值">
        </div>
        <div class="layui-form-mid layui-word-aux">金块掉落峰值</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">金块低值</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="min" value="{$det.min}" lay-verify="title" autocomplete="off" placeholder="金块掉落低值">
        </div>
        <div class="layui-form-mid layui-word-aux">金块掉落低值</div>
    </div>

    <input type="text" id="gradeid" name="gradeid" value="" hidden>

    <fieldset class="layui-elem-field layui-field-title">
      <legend> 难度等级：<span class="gradee" style="color: red"></span> 概率设置 （百分比）</legend>
    </fieldset>
    <div class="contentt"></div>
    
    <!-- <div class="layui-form-item">
        <label class="layui-form-label">字母W概率</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="gailv" value="{$det.gailv}" lay-verify="title" autocomplete="off" placeholder="概率">
        </div>
        <div class="layui-form-mid layui-word-aux">黑洞字母W出现概率</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">字母W</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="gailv" value="{$det.gailv}" lay-verify="title" autocomplete="off" placeholder="概率">
        </div>
        <div class="layui-form-mid layui-word-aux">黑洞字母W出现概率</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">飞行道具</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="gailv" value="{$det.gailv}" lay-verify="title" autocomplete="off" placeholder="概率">
        </div>
        <div class="layui-form-mid layui-word-aux">飞行道具出现概率</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">护盾</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="gailv" value="{$det.gailv}" lay-verify="title" autocomplete="off" placeholder="概率">
        </div>
        <div class="layui-form-mid layui-word-aux">护盾出现概率</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">回血</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="recover" value="{$det.gailv}" lay-verify="title" autocomplete="off" placeholder="概率">
        </div>

        <div class="layui-form-mid layui-word-aux">回血出现概率</div>
    </div> -->


    <!--<div class="layui-form-item">
        <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="status" value="1" title="启用">
            <input type="radio" class="field-status" name="status" value="0" title="禁用">
        </div>
    </div> -->
    <div class="layui-form-item">
        <div class="layui-input-block">
          
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
{include file="admin@block/layui" /}

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">

layui.use("form", function () {
        var form = layui.form;

        var ary = new Array();
        ary[0] = '字母W概率';
        ary[1] = '飞行道具';
        ary[2] = '护盾';
        ary[3] = '回血';
        ary[4] = '黑洞';
        ary[5] = 'wgailv';
        ary[6] = 'fly';
        ary[7] = 'shield';
        ary[8] = 'recover';
        ary[9] = 'heidong';
        var first = eval({$first}); //<?php echo $first; ?>;// {json_encode:($first,true)};

        var i=0;
        var jsondata ;
        form.on('select(test)', function(data){
            if(data.value=='1'){
                $(".gradee").html("简单");
                 jsondata = eval({$first});
            }else if(data.value=='2'){
                $(".gradee").html("一般");
                 jsondata = eval({$second});
            }else if(data.value=='3'){
                $(".gradee").html("困难");
                 jsondata = eval({$third});
            }else if(data.value=='4'){
                 jsondata = eval({$fourth});
                $(".gradee").html("特难");
            }
            var kk = data.value;
            $("#gradeid").attr("value",kk);
          html ='';
          for(i=0;i<5;i++){

            var temp = ary[i+5];
    
            html += ' <div class="layui-form-item">'
            +'<label class="layui-form-label">'+ary[i]+'</label>'
            +'<div class="layui-input-inline">'
            +    '<input type="text" class="layui-input field-username" name="'+temp+'" value="'+jsondata[temp]+'" lay-verify="title" autocomplete="off" placeholder="概率">'
            +'</div>'
            +'<div class="layui-form-mid layui-word-aux">转盘'+ary[i]+'出现概率</div>'
            +'</div>';
            
          }
          $(".contentt").html('');
          $(".contentt").append(html);

        });
    })
    
</script>

<script>

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
        ,url: '{literal}{:url("admin/annex/upload?water=&thumb=&from=&group=")}{/literal}'
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
