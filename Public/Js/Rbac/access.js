            $(function(){
                $("input[level=1]").click(function(){
                    var inputs = $(this).parents(".app").find("input");
                    $(this).prop("checked")?inputs.prop("checked", true):inputs.prop("checked", false);
                });
                $("input[level=2]").click(function(){
                    var inputs = $(this).parents("dl").find("input");
                    $(this).prop("checked")?inputs.prop("checked",true):inputs.prop("checked", false);
                });
            });
            function save(){
                var data = [];
                $("input[name='access[]']:checked").each(function(){
                    //alert($(this).val());
                    data.push($(this).val());
                });
                $.ajax({
                    method:'post',
                    data:{'data':data,'rid':$('#rid').val()},
                    url:setUrl,
                    success:function(res){
                        if(res.status == 1){
                            $.messager.alert('提示!','修改成功!');
                            var url = aceUrl+"?rid="+$('#rid').val();
                            window.location = url;
                        }else{
                            $.messager.show({
                                title:'错误',
                                msg:res.info,
                            });
                        }
                    }
                });
            }