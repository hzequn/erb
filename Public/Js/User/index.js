//格式化列 查看用户拥有的系统操作权限
function detail(val,row){
	//row.role_id
	var url = accessUrl+"?rid="+val+"&status=1";
	return "<a  class = 'easyui-linkbutton' iconCls = 'icon-ok' href = '"+url+"' >查看用户拥有权限</a>";
}

//获取所有角色组
function getRole(){
	$.ajax({
		url:roleUrl,
		success:function(data){
			var selectObj = $('#role_id');
			selectObj.empty();
			for(var i in data){
				selectObj.append("<option value = '"+data[i].id+"'>"+data[i].title+" </option>");
			}
		}
	});
}

//删除用户
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

//新增用户 
function add(){
	$('#dlg').dialog('open').dialog('setTitle','新增');
	$('#fm').form('clear');
	ajaxUrl = addUrl;
}

//格式化 列 显示用户当前账号状态
function status(val,row){
	if(val == 1){
		return  "开启";
	}else{
		return  "冻结";
	}
}

//编辑用户信息
function edit(){
	var row = $('#dg').datagrid('getSelected');
	if(row){
		ajaxUrl = editUrl+"?id="+row.id;
		$("#status").val(row.status);
		$('#dlg').dialog('open').dialog('setTitle','编辑');
		$('#fm').form('load',row);
	}else{
		$.messager.alert("提示！","请选中要编辑的选项","error");
	}
}

//为用户分配角色
function role(){
	var row = $('#dg').datagrid('getSelected');
	if(row){
		$.ajax({
			url:roleUrl,
			success:function(data){
				var selectObj = $('#role_id');
				selectObj.empty();
				for(var i in data){
					selectObj.append("<option value = '"+data[i].id+"'>"+data[i].title+" </option>");
				}
				$('#user_id').val(row.id);
				$('#role_name').val(row.name);
				$('#role_id').val(row.role_id);
				$('#role_account').val(row.account);
				$('#role-dlg').dialog('open').dialog('setTitle','设置');
			}
		});
	}else{
		$.messager.alert("提示！","请选中用户","error");
	}
}
function saveRole(){
	var data ={
		'uid':$('#user_id').val(),
		'group_id':$('#role_id').val(),
	}
	$.ajax({
		method:'post',
		data:{"data":data},
		url:setRole,
		success:function(res){
			if(res.status == 1){
				$('#role-dlg').dialog('close');
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
}
function save(){
	
	var data = {
		'name':$.trim($('#name').val()),
		'account':$.trim($('#account').val()),
		'status':$.trim($('#status').val())
	}
	if(data.name == "" ||data.account == "" ||data.status == ""){
		$.messager.alert('警告!',"存在空数据,请检查数据!",'error');
	}else{
		$.ajax({
			method:'post',
			url:ajaxUrl,
			data:{'data':data},
			success:function(res){
				if(res.status == 1){
					$('#dlg').dialog('close');
					$.messager.alert('提示',res.info,'success');
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