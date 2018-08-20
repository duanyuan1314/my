<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css?v={:config('hisiphp.version')}">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:config('hisiphp.version')}">
</head>
<body>
    <div class="layui-tab-item layui-show" style="margin-top:5%;" >
        <form class="layui-form layui-form-pane"  method="post" >
            <div class="layui-form-item">
                <label class="layui-form-label">商品名称</label>
                <div class="layui-input-inline w300" >
                    <input type="text" class="layui-input"  style="background:#eee;" value="{$data_info['cardname']}" autocomplete="off"  disabled="disabled"  >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品数量</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input"   style="background:#eee;" value="{$data_info['num']}" autocomplete="off"  disabled="disabled"  >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品ID</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input"   style="background:#eee;" value="{$data_info['cardid']}" autocomplete="off"  disabled="disabled" >
                </div>
            </div>
             <div class="layui-form-item">
                <label class="layui-form-label">会员昵称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" style="background:#eee;" value="{$data_info['name']}" autocomplete="off"  disabled="disabled" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">收货人电话</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input"  style="background:#eee;"  value="{$data_info['phone']}" autocomplete="off"  disabled="disabled" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">收货地址</label>
                <div class="layui-input-inline w300" >
                    <input type="text" class="layui-input"  style="background:#eee;" value="{$data_info['address']}" autocomplete="off"  disabled="disabled" >
                </div>
            </div>
             {if condition="$data_info['status'] eq 3" }
            <div class="layui-form-item" >
                <label class="layui-form-label">选着快递</label>
                    <div class="layui-input-inline">
                        <select id="type"  class="field-role_id" type="select" >
                            <option value="1" {if condition="$data_info['type'] eq 1"}selected="selected"{/if} >顺丰快递</option>
                            <option value="2" {if condition="$data_info['type'] eq 2"}selected="selected"{/if}  >申通</option>
                        </select>
                    </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">快递单号</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="tracking"  value="{$data_info['tracking']}" autocomplete="off" lay-verify="required"  >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline" style="width:60%;" >
                    <textarea rows="5" class="layui-textarea"  autocomplete="off" lay-verify="required" >{$data_info['beizhu']}</textarea>
                </div>
            </div>
            <input type="hidden" class="field-id"  value="{$data_info['id']}" >
            <input type="hidden" class="uid"  value="{$data_info['userid']}" >
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit=""  >应用</button>
                </div>
            </div>
            {/if}
        </form>
    </div>
</body>
</html>
{include file="block/layui" /}
<script src="__STATIC__/index/js/jquery.min.js"></script>
<script src="__STATIC__/layer/layer.js"></script>
<script>
    $('.layui-btn').click(function () {
            var id   = $(".field-id").val();
            var type = $("#type ").val();
            var tracking = $("#tracking").val();
            var uid= $(".uid").val();
            var beizhu= $(".layui-textarea").val();
            if(tracking ==''){
                    layer.msg('订单编号不能为空', { time: 2000 });
            }else if(beizhu ==''){
                    layer.msg('备注不能为空', { time: 2000 });
            }else{
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: "{:url('market/edit')}",
                    data: { id: id, type:type,tracking:tracking,uid:uid,beizhu:beizhu},
                    success: function (re) {
                        if (re.code == 1) {
                            layer.msg(re.msg, { time: 1000 }, function () {
                                  var index = parent.layer.getFrameIndex(window.name);
                                  parent.layer.close(index); 
                                  parent.location.reload();
                            })
                        } else {
                             layer.msg(re.msg, { time: 2000 });
                        }
                    }
                });
            }
     })
</script>