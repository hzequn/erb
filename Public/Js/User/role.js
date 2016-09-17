
function detail(val,row){
	var url = setAccessUrl+"?rid="+val;
	return "<a href = '"+url+"'>设置角色权限</a>";
}
function status(val,row){
	if(val == 1){
		return  "开启";
	}else{
		return  "冻结";
	}
}
function edit(){
	var row = $('#dg').datagrid('getSelected');
	ajaxUrl = editUrl + "?id="+row.id;
	$("#status").val(row.status);
	if(row){
		$('#dlg').dialog('open').dialog('setTitle','编辑');
		$('#fm').form('load',row);
	}else{
		$.messager.alert("提示！","请选中要编辑的选项","error");
	}
}

function add(){
	$('#dlg').dialog('open').dialog('setTitle','新增');
	$('#fm').form('clear');
	ajaxUrl = addUrl;
}
function del(){
	var row = $('#dg').datagrid('getSelected');
	if(row){
		$.messager.confirm('提示','确认删除这条数据吗？！！',function(r){
			if(r){
				$.ajax({
					method:'post',
					url:delUrl,
					data:{"id":row.id},
					success:function(res){
						if(res.status == 1){
							$.messager.alert('成功！',res.info,'success');
							$('#dg').datagrid('reload');
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
function save(){
	var data = {
		'title':$.trim($('#title').val()),
		'remark':$.trim($('#remark').val()),
		'status':$.trim($('#status').val())			
	}
	if(data.title == '' ||  data.remark == '' || data.status == ''){
		$.messager.alert('警告',"存在空数据,请检查数据!",'error');
	}else{
		$.ajax({
			method:'post',
			url:ajaxUrl,
			data:{'data':data},
			success:function(res){
				if(res.status == 1){
					$('#dlg').dialog('close');
					$.messager.alert('提示',res.info);
					$('#dg').datagrid('reload');
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