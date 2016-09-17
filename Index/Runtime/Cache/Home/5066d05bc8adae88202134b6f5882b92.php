<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>服装管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/user.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script>
		var url;
		function detail(val,row){
			var url = "<?php echo U('Stock/clothes');?>?id="+row.id;
			return '<a href = "'+url+'">点击查看</a>';
		}
		function add(){
				$('#dlg').dialog('open').dialog('setTitle','新增');
				$('#fm').form('clear');
				url = "<?php echo U('Stock/add');?>";
		}
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if(row){
					$.messager.confirm('提示','确认删除这条数据吗？',function(r){
						if(r){
							$.ajax({
								method:'post',
								url:"<?php echo U('Stock/del');?>",
								data:{"id":row.id,"table":'stock'},
								success:function(res){
									if(res.status == 1){
										$.messager.alert('成功！','删除成功！');
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
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if(row){
				$('#dlg').dialog('open').dialog('setTitle','新增');
				$('#fm').form('load',row);
				url = "<?php echo U('Stock/edit');?>?id="+row.id;
			}else{
				$.messager.alert("提示！","请选中要编辑的选项","error");
			}
		}
		function save(){
			var data = {
				'type':$.trim($('#type').val()),
				'remark':$.trim($('#remark').val()),
			}
			if(data.type == ''){
				$.messager.alert('警告!','存在空数据,请检查数据!','error');
			}else{
				$.ajax({
					method:'post',
					url:url,
					data:{'data':data,'table':'stock'},
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
	</script>
</head>	
	<body>
		<table id = 'dg' class = 'easyui-datagrid' title = '一级仓库管理' data-options = 'rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true'
		url = "<?php echo U('Stock/getData',array('table'=>'stock'));?>" toolbar = '#tb'>
			<thead>    
        		<tr> 
            		<th style = "width:10%" data-options = "field:'type',center:'left',align:'center'">服装类型</th>
            		<th style = "width:10%" data-options = "field:'total',center:'left',align:'center'">数量</th>
            		<th style = "width:60%" data-options = "field:'remark',align:'left',align:'center'">备注</th>
        			<th style = "width:10%" data-options = "field:'id',align:'left',align:'center'" formatter= "detail">查看详情</th>
        		</tr>
    		</thead> 
		</table>
		<div id = 'tb'>
			<a href = "#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="add()">增加</a>
			<a href = "#" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="del()">删除</a>
			<a href = "#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="edit()">编辑</a>
		</div>

		<div id = 'dlg' class = 'easyui-dialog' style = 'width:30%;height:150px;position:relative;top:30%;
			z-index:100' closed = 'true' buttons = '#dlg-buttons'>
	    	<form id = 'fm' method = 'post'>
	    		<div class = 'fitem'>
	    			<label>类型:</label>
	    			<input id = "type" name = "type" class = "easyui-validatebox" required = "true">
	    		</div>
	    		&nbsp
	    		<div class = 'fitem'>
	    			<label>备注:</label>
	    			<input id = "remark" name = "remark" class = "easyui-validatebox" >
	    		</div>
	    	</form>
	    </div>
	    <div id = 'dlg-buttons'>
	    	<a href = "#" class = "easyui-linkbutton" iconCls = "icon-ok" onclick = "save()">保存</a>
	    	<a href = "#" class = "easyui-linkbutton" iconCls = "icon-cancel" onclick = "javascript:$('#dlg').dialog('close')">取消</a>
	    </div>
	</body>
</html>