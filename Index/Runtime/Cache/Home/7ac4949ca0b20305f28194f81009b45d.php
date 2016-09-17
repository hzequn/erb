<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo.css">
    <link rel="stylesheet" type="text/css" href="/ERP/Public/Css/public.css">
    <script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
    <script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
    <script type="text/javascript" src="/ERP/Public/Js/Rbac/node.js"></script>
    <script>
        var url;
        var delUrl = "<?php echo U('Rbac/del');?>";
        var getNodeUrl = "<?php echo U('Public/getNode');?>";
        var editUrl = "<?php echo U('Rbac/edit');?>";
        var saveUrl = "<?php echo U('Rbac/add');?>";
    </script>
</head>
    <body>
        <table id = "tg"  title= "权限节点管理" class="easyui-treegrid" toolbar = "#tb"
            data-options="idField:'id',treeField:'title',lines:true,rownumbers:true," checkbox = 'true' url = "<?php echo U('Rbac/getData');?>">
            <thead>
                <tr>
                    <th data-options="field:'title'" width="20%">title</th>
                    <th data-options="field:'name'" width="20%">Name</th>
                    <th data-options="field:'pid'" width="20%" align="right">pid</th>
                   <th data-options="field:'id'" width="20%" align="right">id</th>
                   <th data-options="field:'level'" width="10%" align="right">level</th>
                </tr>
            </thead>
        </table>
        <div id="tb">
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="del()">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edit()">编辑</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="add()">新增</a>
        </div>


        <div id="dlg" class="easyui-dialog" style="width:30%;height:150px;position:relative;top:30%;
            z-index:100" closed="true" buttons="#dlg-buttons">
            <form id="fm" method="post">
                <div class="fitem">
                    <label>备注:</label>
                    <input id = "remark" name="remark" class="easyui-validatebox" required = "true" >
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveEdit()">保存</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
        </div>


        <div id="node-dlg" class="easyui-dialog" style="width:30%;height:300px;position:relative;top:30%;
            z-index:100" closed="true" buttons="#node-dlg-buttons">
            <form id="fm" method="post">
                <div class="fitem">
                    <label>创建:</label>
                    <select id = "level" onchange = "checkLevel(this)" >
                        <option value = '1' selected = "true">应用</option>
                        <option value = '2'>控制器</option>
                        <option value = '3'>方法</option>
                    </select>
                </div>
                &nbsp
                <div  id = "list" hidden = "true" class="fitem">
                    <label>所属目录:</label>
                    <select id = "parent" >
                    </select>
                </div>
                &nbsp
                <div class="fitem">
                    <label>名称:</label>
                    <input id = "name" name="name" class="easyui-validatebox" required="true">
                </div>
                &nbsp
                <div class="fitem">
                    <label>描述:</label>
                    <input id = "title" name="title" class="easyui-validatebox" required="true" >
                </div>
                &nbsp
                <div class="fitem">
                    <label>是否开启:</label>
                    <select id = "status" required="true">
                      <option value ="1" selected = "true" >开启</option>
                      <option value ="0">关闭</option>
                    </select>
                </div>
            </form>
        </div>
         <div id="node-dlg-buttons">
            <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">保存</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#node-dlg').dialog('close')">取消</a>
        </div>
    </body>
</html>