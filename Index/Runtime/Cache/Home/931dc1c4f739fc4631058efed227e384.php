<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
    </head>
 <body>  
<div class="con">
   <div > &nbsp  </div> 
<table width="60%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="10%" valign="top"> &nbsp</td>
    <td width="90%" valign="top">
        
      <div class="tb-line"></div>
        
      <div id="comm" style="padding:2px">
        <table class="infobox table-border" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="height:23px; line-height:23px;">
            <td width="18%">服务器名称:</td>
            <td width="32%"><?php echo $_SERVER['SERVER_NAME']; ?></td>
            <td width="18%">服务器IP:</td>
            <td width="32%"><?php echo strstr($_SERVER['SERVER_SOFTWARE'],'Microsoft')?$_SERVER['LOCAL_ADDR']:$_SERVER['SERVER_ADDR']; ?></td>
            </tr>
          <tr style="height:23px; line-height:23px;">
            <td width="18%">服务器域名:</td>
            <td width="32%"><?php echo $_SERVER['HTTP_HOST']; ?></td>
            <td width="18%">操作系统:</td>
            <td width="32%"><?php echo PHP_OS; ?></td>
            </tr>
          <tr style="height:23px; line-height:23px;">
            <td width="18%">PHP版本:</td>
            <td width="32%"><?php echo PHP_VERSION; ?></td>
            <td width="18%">运行状态:</td>
            <td width="32%"><?php echo C('CFG_ON')==1?"运行中":"维护中"; ?></td>
            </tr>
          </table>
        </div>
       
    </td>
    </tr>
</table>

</div>
</body>
</html>