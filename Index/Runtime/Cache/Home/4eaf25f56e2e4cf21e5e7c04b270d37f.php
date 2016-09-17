<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>仓库操作记录</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/user.css">
  	  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script>
	</script>
</head>	
	<body>
		<table id = 'dg' class = 'easyui-datagrid' title = '仓库操作记录' data-options = 'rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true'
		url = "<?php echo U('Stock/getRecord');?>"
		toolbar = '#tb'>
			<thead>    
        		<tr> 
            		<th style="width:20%" data-options="field:'date',center:'left',align:'center'">时间</th>
            		<th style="width:10%" data-options="field:'user',center:'left',align:'center'">操作人员</th>
            		<th style="width:60%" data-options="field:'record',align:'left',align:'center'">详情</th>
        		</tr>
    		</thead> 
		</table>
	</body>
</html>