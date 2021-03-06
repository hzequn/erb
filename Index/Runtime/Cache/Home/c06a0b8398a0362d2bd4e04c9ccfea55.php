<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title><?php echo ($data['id']); ?>管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/user.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/ERP/Public/Js/Sale/record.js"></script>
	<script>
		var url = "<?php echo U('Stock/clothes');?>";
	</script>
</head>	
	<body>

		<table id = "dg" class="easyui-datagrid" title="商品搜索" data-options="rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true" url="<?php echo U('Sale/getRecord');?>"
		toolbar = "#tb">
			<thead>    
        		<tr> 
        			<th style="width:10%"  data-options="field:'id',center:'left',halign:'center'" hidden = "true">编号</th>
        			<th style="width:10%"  data-options="field:'shop_name',center:'left',halign:'center'">名称</th>
            		<th style="width:10%"  data-options="field:'shop_code',center:'left',halign:'center'">商品编码</th>
            		<th style="width:5%"   data-options="field:'shop_size',align:'left',halign:'center'">尺码</th>
            		<th style="width:10%"  data-options="field:'shop_price',center:'left',halign:'center'">价格</th>
            		<th style="width:5%"   data-options="field:'shop_total',center:'left',halign:'center'">数量</th>
            		<th style="width:10%"  data-options="field:'shop_size',align:'left',halign:'center'">尺码</th>
            		<th style="width:20%"  data-options="field:'saledate',center:'left',halign:'center'">出售日期</th>
            		<th style="width:10%"  data-options="field:'saleman',center:'left',halign:'center'">售货员</th>
            		<th style="width:10%"  data-options="field:'ordernum',align:'left',halign:'center'">订单号</th>
        		</tr>
    		</thead>
		</table>
		<div id="tb">
			
			<input id = "searchbox" class="easyui-searchbox" data-options="prompt:'输入要查询的值',searcher:doSearch " style="width:15%">
			<div id = "mm" >
				<div data-options="name:'shop_name'">商品名称</div>
				<div data-options="name:'shop_code'">商品编码</div>
				<div data-options="name:'saleMan'">售货员</div>
				<div data-options="name:'orderNum'">订单号</div> 
			</div>
		</div>
		<a href = "<?php echo U('Sale/export');?>" >导出CSV文件</a>
	</body>
</html>