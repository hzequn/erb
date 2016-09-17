<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>后端首页</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/index.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
    <link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
    <script type="text/javascript" src ="/ERP/Public/Js/Index/index.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
</head>	
	<body class = "easyui-layout" data-options = "fit:true" id = "cc">  
		<div region="west" id = "west" split="true" title="功能栏" style="width:10%">
			<div class="easyui-accordion" data-options="fit:true,border:false">
				<div title="系统管理"  style="padding:10px;">
						<li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok'  onclick = "addPanel('<?php echo U('User/index');?>','用户管理')">用户管理<a/></li><br>
						<li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok' onclick = "addPanel('<?php echo U('User/role');?>','角色管理')">角色管理<a/></li><br>
						<li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok' onclick = "addPanel('<?php echo U('Rbac/node');?>','节点管理')">权限管理<a/></li><br>
				</div>
				<div title="库存管理"  style="padding:10px;">
					<li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok' onclick = "addPanel('<?php echo U('Stock/record');?>','仓库操作记录')">仓库操作记录</a></li><br>
					<li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok' onclick = "addPanel('<?php echo U('Stock/index');?>','仓库管理')">一级仓库管理</a></li><br>
 					<?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok'  onclick = "addPanel('<?php echo U('Stock/clothes');?>?id=<?php echo ($vo["id"]); ?>','<?php echo ($vo["type"]); ?>管理')"><?php echo ($vo["type"]); ?>管理</a></li><br><?php endforeach; endif; ?>			
				</div>

				<div title="销售管理"  style="padding:10px;">
					<li><span><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok'  onclick = "addPanel('<?php echo U('Sale/index');?>','销售')">销售</a></span></li><br>
					<li><span><a href = "#" class = 'easyui-linkbutton' style = 'width:100%' iconCls = 'icon-ok'  onclick = "addPanel('<?php echo U('Sale/record');?>','销售记录')">销售记录</a></span></li><br>
				</div>
			</div>
		</div>
		<div id = "content" region = "center" title = "主界面">
			<div id = "tt" class = "easyui-tabs" style="width:100%;height:100%">
                <div title="系统基本信息" data-options="closable:false,id:-1,href:'<?php echo U('Index/systeminfo');?>'"></div>
            </div>
		</div>
		<div data-options="region:'north',split:true" style="height:8%">

				<h1 align = 'center'>
					欢迎您!:<?php echo ($user); ?> <a href = "<?php echo U('Login/logout');?>">注销</a> <a href = "#"  onclick = "access('<?php echo U('Rbac/userAccess');?>',<?php echo ($rid); ?>)">查看权限</a> 
				</h1>
		</div>
		<div data-options = "region:'south',split:true" style = "height:10%;">
			<div align = 'center'>
						@Copyright QYX  联系QQ 357748841<br>
						2016.1.1--<?php echo date('Y.m.d');?>
			</div>
		</div>
        <div id = "mm" class = "easyui-menu">
            <div data-options = "iconCls:'icon-cancel'" id = "close">关闭 </div>
            <div id = "closeall"> 关闭全部 </div>
            <div id = "closeother">关闭其他</div>
            <div class = "menu-sep"></div>
            <div id = "closeright">关闭右侧标签页</div>
            <div id = "closeleft">关闭左侧标签页</div>
            <div data-optionds = "iconCls:'icon-refresh'" id = "refresh">刷新</div>
        </div>
        <div id = 'access-dlg' closed = "true" class = "easyui-dialog" style = "width:80%;height:80%">
        </div>

	</body>
</html>