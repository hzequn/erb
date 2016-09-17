<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>登录页面</title>
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/EasyUi/demo.css">
	<link rel="stylesheet" type="text/css" href="/ERP/Public/Css/login.css">
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.min.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/ERP/Public/EasyUi/jquery.easyui.min.js"></script>
	<script>
		function verify(){
			$('#verifyImg').attr('src',"<?php echo U('Login/verify');?>?id"+Math.random());
		}
		function login(){
			var data = {
				'account':$('#account').val(),
				'pwd':$('#pwd').val(),
				'verify':$('#verify').val()
			}
			$.ajax({
				method:'post',
				data:{'data':data},
				url:"<?php echo U('Login/checkData');?>",
				success:function(data){
					
					switch(data.status){
						case 0:
							$.messager.alert('提示',data.msg,'error');
							break;
						case 1:
							$.messager.alert('提示',data.msg,'error');
							break;
						case 2:
							$.messager.alert('提示',data.msg,'error');
							break;
						case 3:
							window.location.href = "<?php echo U('Login/login');?>";
							break;
						default:
							$.messager.alert('提示','未知错误请重试!','error');
							break;
					}
					$('#verifyImg').attr('src',"<?php echo U('Login/verify');?>?id"+Math.random());
				}
			});
		}
	</script>
</head>	
	<body>
		<div class = 'login'>
			<h1>后台登录</h1>
			<form action = '#'>
				<input class = 'input' type = 'text'     id = 'account' placeholder = '用户名' required = 'required' />
				<input class = 'input' type = 'password' id = 'pwd'     placeholder = '密码'   required = 'required' />
				<div>
					<input class = 'verify' type = 'text'  id = 'verify' placeholder = '验证码' required = 'required'/>
					<img style = 'float:right;width:40%;height:15%' id = 'verifyImg' src=  "<?php echo U('Login/verify');?>" onclick = 'verify()'> 
				</div>
				<button  class = 'btn btn-primary btn-block btn-large'  onclick = 'login()'>登录</button>
			</form>
		</div>
	</body>
</html>