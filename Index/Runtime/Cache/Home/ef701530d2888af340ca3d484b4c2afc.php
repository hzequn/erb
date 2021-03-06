<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>角色管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/user.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/ERP/Public/Js/User/role.js"></script>
	<script>
		var ajaxUrl;
		var setAccessUrl = "<?php echo U('Rbac/access');?>";
		var editUrl = "<?php echo U('User/editRole');?>";
		var addUrl = "<?php echo U('User/addRole');?>";
		var delUrl = "<?php echo U('User/delRole');?>";
	</script>
</head>	
	<body>
		<table id = "dg" class="easyui-datagrid" title="角色管理" data-options="rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true" 
		url = "<?php echo U('User/getRoleList');?>"
		toolbar = "#tb">
			<thead>
				<tr>
					<th style="width:25%" data-options="field:'title',center:'left',align:'center'">角色名</th>
					<th style="width:25%" data-options="field:'remark',center:'left',align:'center'">角色组描述</th>
					<th style="width:25%" data-options="field:'status',center:'left',align:'center'" formatter="status" >状态</th>
					<th style="width:24%" data-options="field:'id',center:'left',align:'center'" formatter="detail">权限</th>
				</tr>
			</thead>
		</table>
		<div id="tb">
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="add()">增加</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="del()">删除</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="edit()">编辑</a>
		</div>
		<div id="dlg" class="easyui-dialog" style="width:30%;height:200px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#dlg-buttons">
	    	<form id="fm" method="post">
	    		<div class="fitem">
	    			<label>角色名称:</label>
	    			<input id = "title" name="title" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>角色备注:</label>
	    			<input id = "remark" name="remark" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>角色状态:</label>
	    			<select id = "status" required="true">
					  <option value ="1">开启</option>
					  <option value ="0">关闭</option>
					</select>
	    		</div>
	    	</form>
	    </div>
	    <div id="dlg-buttons">
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">保存</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	    </div>
	</body>
</html>