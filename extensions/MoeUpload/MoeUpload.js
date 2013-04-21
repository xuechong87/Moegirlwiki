$( document ).ready( function() {
	$('.mw-htmlform-field-HTMLTextAreaField').each(function(){
		var self = this;
		if($(this).find("#wpUploadDescription")){
			var html = $(this).find('.mw-input').html();
			html = '<a class="tooggle" href="##" >仅供管理使用</a>' + html;
			$(this).find('.mw-input').html(html);
			$(this).find('.mw-input #wpUploadDescription').hide();
		}
	});
	$('.tooggle').click(function(){
		$('#wpUploadDescription').slideToggle();
	});
	  /*url输入验证*/
	  $('input#wpSrcUrl').change(function(){   
	    var str=$(this).val();
	    str=str.replace(/(^\s*)|(\s*$)/g, "");
	    str=str.toLowerCase();
	    if(str.match(/(\.jepg)|(\.gif)|(\.jpg)|(.ico)$/g)){
	      if( $('p#upLoadFileUrlmsg').length==0)
	      {
	        $(this).after('<p  id=\"upLoadFileUrlmsg\" class=\"error \">请输入页面地址，而非图片链接<p>');  
	      }    
	    }else{
	      $('p#upLoadFileUrlmsg').remove();
	    }
 	 });
} );

/* XpAhH同学写的上传页面检测，未写注释禁止上传。管理员，巡查员不检测 */
Array.prototype.intersects=function(){if(!arguments.length)return false;var array2=arguments[0];var len1=this.length;var len2=array2.length;if(len2==0)return false;for(var i=0;i<len1;i++){for(var j=0;j<len2;j++){if(this[i]===array2[j])return true}};return false};
$("#mw-upload-form").submit(function(){
  if(wgUserGroups.intersects(["sysop","patroller"])||window.disableUpCheck==1)return!0;
  var o=$($("input[name=wpSourceType]:checked").val()=="url"?"#wpUploadFileURL":"#wpUploadFile"),t="";
  o.each(function(i,a){t+=$(a).val()});
  if(!t){
    o.eq(0).focus();
    //彩蛋
    $.extend($.easing,{easeOutCirc: function (x, t, b, c, d) {return c * Math.sqrt(1 - (t=t/d-1)*t) + b;}})
    var c=$("body");
    for(var i=0;i<20;i++)
      c.append($("<div>").text("萌").css({color:"#3FFC2E","font-size":54+30*Math.random(),position:"fixed",left:screen.availWidth*Math.random(),top:screen.availHeight*Math.random()})
        .animate({opacity: 0.2,"font-size":54+80*Math.random(),left:screen.availWidth*Math.random(),top:-100-Math.random()*300},2000,"easeOutCirc",function(){this.remove()}))
     return!1;
  }
  //三选一&符号
  t="";
  (o=$("#wpCharName,#wpAuthor,#wpSrcUrl")).each(function(i,a){t+=$(a).val()});
  o.each(function(i,a){t+=$(a).val()});
  if(!t){
    o.eq(0).focus();
    o.css({"box-shadow":"0 0 8px red",border:"red solid 1px",padding:"2px 1px"});
    $("#errmsg")[0] || $("#mw-htmlform-description>tbody").prepend($('<tr id=errtr><td></td><td class="mw-input"><div class="mw-editTools"><div id=errmsg class="anonnotice common-box"></div><p><br></p></div></td></tr>'));
    $("#errmsg")
      .html($("<font color=red>")
        .text(t?"＞_＜ 【人物名，作者名，来源】不能包含特殊符号~!请不要写多余的内容 [·~。（）()!@#$%^&*]":"＞_＜ 【人物名，作者名，来源地址】不能全部为空~!"));
    o.one("focus",function(){
      o.attr("style","");
      $("#errmsg").hide(300,function(){$("#errtr").remove()});
    });
    return!1;
  }
    /*url提交验证*/
  if($('p#upLoadFileUrlmsg').length==0){
    return true;
  }
  else{
    return false;
  }
});
