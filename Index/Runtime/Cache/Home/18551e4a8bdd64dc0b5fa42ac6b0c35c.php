<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>用户管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/user.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/ERP/Public/Js/User/index.js"></script>
	<script>
		var ajaxUrl;
		var roleUrl = "<?php echo U('Public/getAllRole');?>";
		var accessUrl = "<?php echo U('Rbac/userAccess');?>";
		var delUrl = "<?php echo U('User/delUser');?>";
		var addUrl = "<?php echo U('User/adduser');?>";
		var editUrl = "<?php echo U('User/editUser');?>";
		var setRole = "<?php echo U('User/setRole');?>";
	</script>
</head>	
	<body>

		<table id = "dg" class="easyui-datagrid" title="用户管理" data-options="rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true"  url = "<?php echo U('User/getUserList');?>"
		toolbar = "#tb">
			<thead>
				<tr>
					<th style="width:10%;" hidden="true" data-options="field:'account',center:'center',align:'center'">账号</th>
					<th style="width:10%;" hidden="true" data-options="field:'pwd',center:'center',align:'center'">密码</th>
					<th style="width:10%;" hidden="true" data-options="field:'id',center:'center',align:'center'">编号</th>
					<th style="width:10%" data-options="field:'name',center:'center',align:'center'">姓名</th>
					<th style="width:20%" data-options="field:'logindate',center:'center',align:'center'">前次登录时间</th>
					<th style="width:20%" data-options="field:'loginip',center:'center',align:'center'">前次登录位置</th>
					<th style="width:20%" data-options="field:'status',center:'center',align:'center'" formatter="status">用户当前状态</th>
					<th style="width:10%" data-options="field:'role',center:'center',align:'center'">用户所属角色</th>
					<th style="width:10%" data-options="field:'role_id',center:'center',align:'center'" formatter="detail">操作</th>
				</tr>
			</thead>
		</table>
		<div id="tb">
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="add()">增加</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="del()">删除</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edit()">编辑</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="role()">分配角色</a>
		</div>
		<div id="dlg" class="easyui-dialog" style="width:25%;height:230px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#dlg-buttons">
	    	<form id="fm" method="post">
	    		<div class="fitem">
	    			<label>姓名:</label>
	    			<input id = "name" name="name" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>账号:</label>
	    			<input id = "account" name="account" class="easyui-validatebox" required="true">
	    		</div>
	    		<div class = "fitem"  hidden = "true">
	    			<label></label>
	    			<select id = "#role_id">
	    			</select>
	    		</div>
	    		&nbsp
				<div class="fitem">	
					<label>状态:</label>
	    			<select id = "status" required="true">
					  <option value ="1" selected = "true" >开启</option>
					  <option value ="0">冻结</option>
					</select>
	    		</div>
	    	</form>
	    </div>
	   	<div id="dlg-buttons">
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">保存</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	    </div>


	    <div id = 'role-dlg' class="easyui-dialog" style="width:25%;height:230px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#role-dlg-buttons">
	    	<form>
	    		&nbsp
	    		<div class="fitem">
	    			<label>姓名:</label>
	    			<input id = "role_name" name="role_name" class="easyui-validatebox" required="true" disabled = "true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>账号:</label>
	    			<input id = "role_account" name="role_account" class="easyui-validatebox" required="true" disabled = "true">
	    		</div>
	    		&nbsp
	    		<div class="fitem" hidden = "true">
	    			<label>编号:</label>
	    			<input id = "user_id" name="user_id" class="easyui-validatebox" required="true" disabled = "true">
	    		</div>
	    		<div class="fitem">
	    			<label>角色:</label>
	    			<select id = "role_id" required="true">
					</select>
				</div>
				&nbsp

	    	</form>
	    </div>
	    <div id="role-dlg-buttons">
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRole()">保存</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#role-dlg').dialog('close')">取消</a>
	    </div>
	</body>
</html>