<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title><?php echo ($data['id']); ?>管理</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
	  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	  	  	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo/demo.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script>
		function checkTotal(){
			var total = $('#total').val();
			if(total < 0){
				$.messager.alert('提示!','数量不能为负数!','error');
				$('#total').val('').focus();
			}
		}
		function detail(val,row){
			return "<a href = '#' onclick  = 'editImg("+row.id+")'>点击查看</a>";
		}
		function editImg(rowId){
			//alert(rowId);
			$('#detail_id').val(rowId);
			$.ajax({
				method:'post',
				url:"<?php echo U('Img/search');?>",
				data:{'id':rowId,"table":'detail_img'},
				success:function(res){
					if(res.status == 1){
						$('#img_preview').attr('src',res.info);
					}else{
						$('#img_preview').attr('src','/ERP/Public/Images/noimage.gif');
					}
					$('#img-dlg').dialog('open').dialog('setTitle','图片查看');
				}
			});
			//$('#img-dlg').dialog('open').dialog('setTitle','图片查看');
		}
		function saveImg(){
			$('#img-fm').form('submit');
			$('#img-dlg').dialog('close');
			$.messager.alert('提示!','上传成功!','success');
		}
		function previewImg(){
			var file = document.getElementById("detail_img").files[0];
			//alert(file.type);
			var reader = new FileReader();  
   			 //将文件以Data URL形式读入页面  
		    reader.readAsDataURL(file);  
		    reader.onload=function(e){   
		        $('#img_preview').attr('src',this.result);
		    }  
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
								data:{"id":row.id,"table":'clothesdetail'},
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
				'name':$.trim($('#name').val()),
				'code':$.trim($('#code').val()),
				'size':$.trim($('#size').val()),
				'price':$.trim($('#price').val()),
				'total':$.trim($('#total').val()),
				'remark':$.trim($('#remark').val()),
			}
			if(data.name == '' || data.code == '' || data.size == '' || data.price == '' || data.total == ''){
				$.messager.alert('警告!','存在空数据,请检查数据!','error');
			}else{
				$.ajax({
					method:'post',
					url:url,
					data:{'data':data,'table':'clothesdetail','clothesId':$('#clothesId').val()},
					success:function(res){
						$('#dlg').dialog('close');
						if(res.status == 1){
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

		<table id = "dg" class="easyui-datagrid" title="三级仓库管理" data-options="rownumbers:true,singleSelect:true,autoRowHeight:false,pagination:true" url="<?php echo U('Stock/getData',array('table'=>'clothesdetail','clothesId'=>$clothesId));?>"
		toolbar = "#tb">
			<thead>    
        		<tr> 
        			<th style="width:10%" data-options="field:'id',center:'left',halign:'center'">编号</th>
        			<th style="width:10%" data-options="field:'name',center:'left',halign:'center'">名称</th>
            		<th style="width:10%" data-options="field:'code',center:'left',halign:'center'">商品编码</th>
            		<th style="width:10%" data-options="field:'size',align:'left',halign:'center'">尺码</th>
            		<th style="width:10%" data-options="field:'price',center:'left',halign:'center'">价格</th>
            		<th style="width:10%" data-options="field:'total',center:'left',halign:'center'">数量</th>
            		<th style="width:10%" data-options="field:'remark',align:'left',halign:'center'">备注</th>
        			<th style="width:10%" data-options="field:'picture',align:'left',halign:'center'" formatter="detail">查看图片</th>
        		</tr>
    		</thead> 
		</table>
		<div id="tb">
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="add()">增加</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="del()">删除</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="edit()">编辑</a>
		</div>
		<div id="dlg" class="easyui-dialog" style="width:30%;height:300px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#dlg-buttons">
	    	<form id="fm" method="post">
	    		<div class="fitem">
	    			<label>名称:</label>
	    			<input id = "name" name="name" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>商品编码:</label>
	    			<input id = "code" name="code" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>尺码:</label>
	    			<input id = "size" name="size" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>价格:</label>
	    			<input id = "price" name="price" class="easyui-validatebox" required="true">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>数量:</label>
	    			<input id = "total" name="total" class="easyui-validatebox" required="true" onchange = "checkTotal()">
	    		</div>
	    		&nbsp
	    		<div class="fitem">
	    			<label>备注:</label>
	    			<input id = "remark" name="remark" class="easyui-validatebox" >
	    		</div>
	    		&nbsp
	    	</form>
	    </div>
	    <input type = "text" id = "clothesId" value = "<?php echo ($clothesId); ?>"  style="display:none;">
	    <div id="dlg-buttons">
	     	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">保存</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	    </div>


	    <div id = 'img-dlg' class="easyui-dialog" style="width:30%;height:300px;position:relative;top:30%;
			z-index:100" closed="true" buttons="#img-dlg-buttons">
			<form id="img-fm" method="post" enctype="multipart/form-data" action = "<?php echo U('Img/upload');?>">
	    		<img id = "img_preview" src = "/ERP/Public/Images/noimage.gif" style = "width:100%;height:80%;"> 
	    		<input type = 'text' hidden='true' id = 'detail_id' name = 'detail_id'>
	    		<input type = 'file' name = 'detail_img' id = 'detail_img' onchange="previewImg()">
	    		<input type = 'text' hidden = 'true' name = 'type' value = 'detail_img'>
	    	</form>
	    </div>

	    <div id="img-dlg-buttons">
	     	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveImg()">保存</a>
	    	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#img-dlg').dialog('close')">取消</a>
	    </div>


	    <a href = "<?php echo U('Stock/export',array('table'=>'clothesdetail','clothes'=>$clothesId));?>" class = "easyui-linkbutton" iconCls = "icon-ok" > 导出CSV文件</a>
	    <a href = "<?php echo U('Stock/clothes',array('id'=>$stockId));?>" class = "easyui-linkbutton" iconCls = "icon-ok"> 返回上一级</a>
	</body>
</html>