	    $(function(){
            $("#searchbox").searchbox({
                    menu:"#mm"
            })
        });
		function detail(val,row){
			return '<a href = "'+url+'">点击查看</a>';
		}
		function doSearch(value,name){
			$('#dg').datagrid('reload',{
				'name':name,
				'value':value
			});
		}