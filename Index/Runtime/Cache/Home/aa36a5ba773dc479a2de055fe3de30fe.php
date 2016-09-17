<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title><?php echo ($data['id']); ?>管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
	  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/ERP/Public/Js/Sale/index.js"></script>
	<script>
		var data ;
		var imgUrl = "<?php echo U('Img/search');?>";
	</script>
	<style type="text/css">
		.disabledTd{
			background-color:#CCC;
		}
	</style>
</head>	
	<body>

		<table id = "dg" class="easyui-datagrid" title="商品搜索" data-options="rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true" url="<?php echo U('Sale/getData');?>"
		toolbar = "#tb">
			<thead>    
        		<tr> 
        			<th style="width:10%" data-options="field:'id',center:'left',halign:'center'">编号</th>
        			<th style="width:10%" data-options="field:'name',center:'left',halign:'center'">名称</th>
            		<th style="width:10%" data-options="field:'code',center:'left',halign:'center'">商品编码</th>
            		<th style="width:10%" data-options="field:'size',align:'left',halign:'center'">尺码</th>
            		<th style="width:10%" data-options="field:'price',center:'left',halign:'center'">价格</th>
            		<th style="width:10%" data-options="field:'total',center:'left',halign:'center'" >数量</th>
            		<th style="width:10%" data-options="field:'remark',align:'left',halign:'center'">备注</th>
        			<th style="width:10%" data-options="field:'picture',align:'left',halign:'center'" formatter="detail">查看图片</th>
        		</tr>
    		</thead> 
		</table>
		<div id="tb">
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="sale()">出售</a>
			<input id = "searchbox" class="easyui-searchbox" data-options="prompt:'输入要查询的值',searcher:doSearch " style="width:15%">
			<div id = "mm" >


			</div>
		</div>
		<div id="dlg" class="easyui-dialog" style="width:30%;height:300px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#dlg-buttons">
	    	<form id="fm" method="post">
	    		<div class="fitem">
	    			<label>名称:</label>
	    			<input id = "name" name="name" class="easyui-validatebox" required="true" readOnly="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>商品编码:</label>
	    			<input id = "code" name="code" class="easyui-validatebox" required="true" readOnly="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>尺码:</label>
	    			<input id = "size" name="size" class="easyui-validatebox" required="true" readOnly="true" >
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>价格:</label>
	    			<input id = "price" name="price" class="easyui-validatebox" required="true" readOnly="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>数量:</label>
	    			<input id = "total" name="total" class="easyui-validatebox" required="true" >
	    		</div>
	    	</form>
	    </div>
	    <div id="dlg-buttons">
	     	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">确定</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	    </div>
	    <form action = "<?php echo U('Sale/Sale');?>" method = "post">
		    <table id = "list" border = "true">
		    	<tr>
		    		<td style="width:10%">编号 </td>
	        		<td style="width:10%" >名称</td>
	            	<td style="width:10%" >商品编码</td>
	            	<td style="width:10%" >尺码</td>
	            	<td style="width:10%" >价格</td>
	            	<td style="width:10%" >数量</td>
	            	<td style="width:10%" >备注</td>
	        		<td style="width:10%" >操作</td>
		    	</tr>
		    </table>
		    <input type = "submit" value = "提交">
		    <label>总价:</label><input type = "text" disabled = "disabled" value = "0" id = "totalPrice">
		</form>

		<div id = 'img-dlg' class="easyui-dialog" style="width:30%;height:300px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#img-dlg-buttons">
			<form id="img-fm" method="post" enctype="multipart/form-data" action = "<?php echo U('Img/upload');?>">
	    		<img id = "img_preview" src = "/ERP/Public/Images/noimage.gif" style = "width:100%;height:80%;"> 
	    		<input type = 'text' hidden='true' id = 'detail_id' name = 'detail_id'>
	    	</form>
	    </div>
	</body>
</html>