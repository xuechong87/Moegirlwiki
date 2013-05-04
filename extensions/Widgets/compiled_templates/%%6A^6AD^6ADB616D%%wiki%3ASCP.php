<?php /* Smarty version 2.6.18-dev, created on 2013-05-05 06:22:00
         compiled from wiki:SCP */ ?>
<script language="javascript"> 
if(!$.cookie("scp"))
(function(){
var css1="width:100%;height:100%;position:fixed;top:0;background:rgba(0,0,0,0.9);z-index:9999",
    css2="position:relative;margin:0 auto;margin-top:-40px;top:50%;width:300px;height:80px;background:#444;color:white;border:solid 1px rgb(118,195,255);border-radius:4px;box-shadow:0 0 5px rgb(118, 195, 255);padding:12px",
    css3="width:72px;height:20px;border-radius:4px;padding:4px;text-align:center;font-size:11pt;float:left;margin-left:26px;cursor:pointer;box-shadow:#777 0 0 22px inset;",
    css4="position:relative;border:8px solid transparent;border-left:12px solid #fff;float:left;margin:2px 0";
$(document.body).append(
  $("<div id=scp>").attr("style",css1)
  .append($("<div>",{style:css2})
    .append($('<div style="margin:12px">继续访问将涉及保密内容<br />未经授权的访问将被监控,定位和处理<br />该警告仅此一次!</div>').prepend($("<div>",{style:css4})))
    .append($("<div>",{text:"是",style:css3+"background:rgb(57,238,0)",click:function(){$.cookie("scp",1);$("#scp").fadeOut(400,function(){this.remove()})}}))
    .append($("<div>",{text:"否",style:css3+"background:rgb(238,48,0);",click:function(){location="/"}}))
  )
);
})();
</script>
<meta name="robots" content="noindex,follow" />