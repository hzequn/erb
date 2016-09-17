
	        $(function(){       
                //jquery bind 方法 用来绑定事件
                 $(".tabs-header").bind('contextmenu',function(e){
                    e.preventDefault();
                    $('#mm').menu('show', {
                        left: e.pageX,
                        top: e.pageY
                    });
                });
                //关闭当前标签页
                $("#close").bind("click",function(e){
                    var tab = $('#tt').tabs('getSelected');
                    var index = $('#tt').tabs('getTabIndex',tab);
                    $('#tt').tabs('close',index);
                });
                //关闭所有标签页
                $("#closeall").bind("click",function(e){
                    var tablist = $('#tt').tabs('tabs');
                    for(var i=tablist.length-1;i>=0;i--){
                        $('#tt').tabs('close',i);
                    }
                });
                //关闭非当前标签页（先关闭右侧，再关闭左侧）
                $("#closeother").bind("click",function(e){
                    var tablist = $('#tt').tabs('tabs');
                    var tab = $('#tt').tabs('getSelected');
                    var index = $('#tt').tabs('getTabIndex',tab);
                    for(var i=tablist.length-1;i>index;i--){
                        $('#tt').tabs('close',i);
                    }
                    var num = index-1;
                    for(var i=num;i>=0;i--){
                        $('#tt').tabs('close',i);
                    }
                });
                //关闭当前标签页右侧标签页
                $("#closeright").bind("click",function(e){
                    var tablist = $('#tt').tabs('tabs');
                    var tab = $('#tt').tabs('getSelected');
                    var index = $('#tt').tabs('getTabIndex',tab);
                    for(var i=tablist.length-1;i>index;i--){
                        $('#tt').tabs('close',i);
                    }
                });
                //关闭当前标签页左侧标签页
                $("#closeleft").bind("click",function(e){
                    var tab = $('#tt').tabs('getSelected');
                    var index = $('#tt').tabs('getTabIndex',tab);
                    var num = index-1;
                    for(var i=0;i<=num;i++){
                        $('#tt').tabs('close',i);
                    }
                });
                $("#refresh").bind("click",function(e){
                    var tabs = $('#tt').tabs('getSelected');
                    var content = tabs.panel('options').content;
                    $('#tt').tab('update',{
                        options:{
                            content:'content',
                        }
                    });
                });
                $(function(){
                    $('#cc').layout();
                    setHeight();
                });
        });
        function setHeight(){
            var c = $('#cc');
            var p = c.layout('panel','center'); // get the center panel
            var oldHeight = p.panel('panel').outerHeight();
            p.panel('resize', {height:'auto'});
            var newHeight = p.panel('panel').outerHeight();
            c.layout('resize',{
                height: (c.height() + newHeight - oldHeight)
            });
        }
        function addPanel(url,title){ 
            if(!$('#tt').tabs('exists', title)){ 
                var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
                $('#tt').tabs('add',{
                    title: title,
                    content:content,
                    closable:true,
                    //tools:[{ iconCls:'icon-mini-refresh', handler : function(){alert('refresh');} }]
                     }   ); 
             }else{
                $('#tt').tabs('select', title); 
            } 
        } 
        //关闭面板
        function removePanel(){ 
            var tab = $('#tt').tabs('getSelected'); 
            if (tab){ 
                var index = $('#tt').tabs('getTabIndex', tab); 
                $('#tt').tabs('close', index); 
            } 
        } 
	    function access(url,rid){  
            url += '?rid='+rid+'&status=0';
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            $('#access-dlg').html('');
            $('#access-dlg').append(content);
            $('#access-dlg').dialog('open').dialog('setTitle','查看权限');
        }