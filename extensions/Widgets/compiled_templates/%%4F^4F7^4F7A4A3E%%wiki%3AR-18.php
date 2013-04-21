<?php /* Smarty version 2.6.18-dev, created on 2013-04-21 13:48:41
         compiled from wiki:R-18 */ ?>
<script language="javascript"> 
if(!$.cookie("x18"))
(function(){
var css1="width:100%;height:100%;position:fixed;top:0;background:rgba(0,0,0,0.9);z-index:9999",
    css2="position:relative;margin:0 auto;margin-top:-40px;top:50%;width:240px;height:80px;background:#444;color:white;border:solid 1px rgb(118,195,255);border-radius:4px;box-shadow:0 0 5px rgb(118, 195, 255);padding:12px",
    css3="width:72px;height:20px;border-radius:4px;padding:4px;text-align:center;font-size:11pt;float:left;margin-left:26px;cursor:pointer;box-shadow:#777 0 0 22px inset;",
    css4="position:relative;border:8px solid transparent;border-left:12px solid #fff;float:left;margin:2px 0";
$(document.body).append(
  $("<div id=x18>").attr("style",css1)
  .append($("<div>",{style:css2})
    .append($('<div style="margin:12px">你是否已年满十八岁?</div>').prepend($("<div>",{style:css4})))
    .append($("<div>",{text:"是",style:css3+"background:rgb(57,238,0)",click:function(){$.cookie("x18",1);$("#x18").fadeOut(400,function(){this.remove()})}}))
    .append($("<div>",{text:"否",style:css3+"background:rgb(238,48,0);",click:function(){location="/"}}))
  )
);
})();
</script>
<meta name="robots" content="noindex,follow" />