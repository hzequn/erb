 $(function(){
                //返回列字段
            var fields = $("#dg").datagrid('getColumnFields');
            for(var i = 1;i < fields.length - 4;i++){
                //返回特定的列属性。
	            var column = $("#dg").datagrid('getColumnOption', fields[i]);
	            var muti = "<div name= '"+ fields[i] +"' >"+ column.title + "</div>";
	            //不断添加 <div>
	            $("#mm").html($("#mm").html()+muti);
            }
            $("#searchbox").searchbox({
                    menu:"#mm"
            })
        });
		function detail(val,row){
			return "<a href = '#' onclick  = 'editImg("+row.id+")'>点击查看</a>";
		}
		function editImg(rowId){
			//alert(rowId);
			$('#detail_id').val(rowId);
			$.ajax({
				method:'post',
				url:imgUrl,
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
		function doSearch(value,name){
			//alert('You input: ' + value+'('+name+')');
			$('#dg').datagrid('reload',{
				'name':name,
				'value':value,
			});
		}
		function sale(){
			var row = $('#dg').datagrid('getSelected');
			if(row){
				$('#dlg').dialog('open').dialog('setTitle','出售商品详情');
				$('#fm').form('load',row);
				data = row;
			}else{
				$.messager.alert("提示！","请选中要出售的物品","error");
			}
		}
		function del(id,value){
			var totalPrice = Number($('#totalPrice').val()) - Number(value);
			$('#totalPrice').val(totalPrice);
			$('#'+id).remove();
		}
		function save(){
			//console.log(typeof(data.total));
			//console.log(typeof($('#total').val()));
			if($('#'+data.id).length > 0){
				$.messager.alert("提示！","该商品已在出售列表!","error");
				$('#dlg').dialog('close');
			}else if( Number($('#total').val()) > Number(data.total)){
				$.messager.alert('提示!','出售数量大于库存,库存不足,请重试!','error');
				$('#total').val("").focus();
			}else{
				var totalPrice = Number($('#totalPrice').val()) + Number(data.price) * Number($('#total').val());
				$('#totalPrice').val(totalPrice);
				var list = "<tr id = '"+data.id+"'>"+
				"<td><input class = 'disabledTd' type='text' name = 'id[]' 	   value = '"+data.id+"'	  readonly='readonly'></td>"+
				"<td><input class = 'disabledTd' type='text' name = 'name[]'    value = '"+data.name+"'    readonly='readonly'></td>"+
            	"<td><input class = 'disabledTd' type='text' name = 'code[]'    value = '"+data.code+"'    readonly='readonly'></td>"+
            	"<td><input class = 'disabledTd' type='text' name = 'size[]'    value = '"+data.size+"'    readonly='readonly'></td>"+
            	"<td><input class = 'disabledTd' type='text' name = 'price[]'   value = '"+data.price+"'   readonly='readonly'></td>"+
            	"<td><input class = 'disabledTd' type='text' name = 'total[]'   value = '"+$('#total').val()+"' readonly='readonly></td>"+
            	"<td><input class = 'disabledTd' type='text' name = 'remark[]'  value = '"+data.remark+"'  readonly='readonly'></td>"+
        		"<td><input class = 'disabledTd' type='text' name = 'picture[]' value = '"+data.picture+"' readonly='readonly'></td>"+
        		"<td><a href = '#' onclick = 'del("+data.id+","+Number(data.price) * Number($('#total').val())+")'>删除此商品</a></td>"+
	    		"</tr> ";
				$('#list').html($('#list').html()+list);
				$('#dlg').dialog('close');
			}
			
		}