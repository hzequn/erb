function del(){
            var row = $('#tg').treegrid('getSelected');
            if(row){
                    $.messager.confirm('提示','确认删除这条数据吗？',function(r){
                        if(r){
                            $.ajax({
                                method:'post',
                                url:delUrl,
                                data:{"id":row.id,"table":'auth_rule'},
                                success:function(res){
                                    if(res.status == 1){
                                        $.messager.alert('成功！','删除成功！');
                                        $('#tg').treegrid('reload');
                                    }else{
                                        $.messager.show({
                                            title:'错误',
                                            msg:res.info,
                                        });
                                    }
                                }
                            });
                        }else{
                            $.messager.alert("提示","已取消操作");
                        }
                    });
            }else{
                $.messager.alert("提示！","请选中要删除的选项","error");
            }
        }

        function edit(){
            var row = $('#tg').treegrid('getSelected');
            if(row){
                $('#dlg').dialog('open').dialog('setTitle','编辑');
                $('#remark').val(row.title);
                editUrl = editUrl + "?id=" + row.id;
            }else{
                $.messager.alert("提示！","请选中要编辑的选项","error");
            }
        }
        function add(){
            $('#list').hide();
            $('#parent').html('');
            $('#level').val('1');
            $('#status').val('1');
            $('#name').val('');
            $('#title').val('');
            $('#node-dlg').dialog('open').dialog('setTitle','编辑');
        }
        function checkLevel(level){
            var num = parseInt(level.value);
            $('#list').hide();
            if(num != 1){
                $.ajax({
                    method:'post',
                    data:{'level':num},
                    url:getNodeUrl,
                    success:function(data){
                        $('#parent').html('');
                        for(var i in data){
                            var html = "<option value = '"+data[i].id+"'>"+data[i].title+"</option>";
                            $('#parent').append(html);
                        }
                        $('#list').show();
                    }
                });
            }
        }

        function saveEdit(){
            console.log($('#remark').val());
            var data = {
                'title':$('#remark').val(),
            }
            $.ajax({
                method:'post',
                data:{'data':data},
                url:editUrl,
                success:function(res){
                    if(res.status == 1){
                        $('#dlg').dialog('close');    
                        $.messager.alert('提示',res.info);
                        $('#tg').treegrid('reload');
                    }else{
                        $.messager.show({
                            title:'错误',
                            msg:res.info,
                        });
                    }
                }
            });
        }
        function save(){
            var level = $('#level').val();
            var data = {
                'level':$.trim( $('#level').val() ),
                'name':$.trim( $('#name').val() ),
                'title':$.trim( $('#title').val() ),
                'status':$.trim( $('#status').val() ),
                'pid':$.trim( $('#parent').val() ),
            }
            if(data.name == '' || data.title == '' || data.status == ''){
                $.messager.alert('警告!',"存在空数据,请检查数据!",'error');
            }else{
                $.ajax({
                    method:'post',
                    data:{'data':data},
                    url:saveUrl,
                    success:function(res){
                        if(res.status == 1){
                            $('#node-dlg').dialog('close');    
                            $.messager.alert('提示',res.info);
                            $('#tg').treegrid('reload');
                        }else{
                            $.messager.show({
                                title:'错误',
                                msg:res.info,
                            });
                        }
                    }
                });
            }

        }