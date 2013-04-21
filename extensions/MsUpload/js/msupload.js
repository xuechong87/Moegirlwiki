var gallery_arr = new Array();

$(document).ready(function () { //jquery      
/* Check if we are in edit mode and the required modules are available and then customize the toolbar */
if ( $.inArray( mw.config.get( 'wgAction' ), ['edit', 'submit'] ) !== -1 ) {
	mw.loader.using( 'user.options', function () {
		if ( mw.user.options.get('usebetatoolbar') ) {
	    	mw.loader.using( 'ext.wikiEditor.toolbar', function () { createUpload(true); });
		}else{ createUpload(false); }
	});
}
});

function createUpload(wikiEditor){
		
	if(wikiEditor==true){		
		
		//create upload button
		var upload_tab = $(document.createElement("span")).attr('class','tab tab-msupload').prependTo('#wikiEditor-ui-toolbar .tabs');
				
		var upload_button = $(document.createElement("span")).attr({ 
		     id: "upload_select",
		     title: mw.msg('msu-button_title')
		}).append('<img src="'+msu_vars.path+'/images/button_upload.gif">').appendTo(upload_tab); 
		
		//create upload div  
    	var upload_container = $(document.createElement("div")).attr('id',"upload_container").insertAfter('#wikiEditor-ui-toolbar');
   		var upload_div = $(document.createElement("div")).attr("id","upload_div").appendTo(upload_container); 
		var container_msu = 'upload_container';
		$('#wikiEditor-ui-toolbar .tool .options').css('z-index', '2'); //headline dropdown
	
	}else{ //only standard editor
		
	  var upload_button = $(document.createElement("a")).attr({ 
      id: "upload_select",
      title: mw.msg('msu-button_title')
      }).append('<img src="'+msu_vars.path+'/images/button_upload.gif">').appendTo("#toolbar"); 
	  
	  var upload_div = $(document.createElement("div")).attr("id","upload_div").insertAfter("#toolbar"); 
	  var container_msu = 'toolbar';
	}  
	      
    var status_div = $(document.createElement("div")).attr("id","upload_status").html('No runtime found.').appendTo(upload_div); 
    var upload_list = $(document.createElement("ul")).attr("id","upload_list").appendTo(upload_div);
    var bottom_div = $(document.createElement("div")).attr("id","upload_bottom").appendTo(upload_div).hide(); 
    var start_button = $(document.createElement("a")).attr("id","upload_files").appendTo(bottom_div).hide();
    var spacer = $(document.createElement("span")).attr("class", "spacer").appendTo(bottom_div).hide();
    var gallery_insert = $(document.createElement("a")).attr("id","gallery_insert").appendTo(bottom_div).hide();
    
		//$("#upload_div").append('<form><table id="mw-htmlform-description"><tbody><tr><td id="wpDestFile-warning" colspan="2">&nbsp;</td></tr><tr class="mw-htmlform-field-HTMLTextField"><td class="mw-label"><label for="wpNickName">&lt;人物名&gt;</label></td><td class="mw-input"><input id="wpNickName" name="wpNickName" size="60"></td></tr><tr class="mw-htmlform-field-HTMLTextField"><td class="mw-label"><label for="wpAuthor">&lt;作者&gt;</label></td><td class="mw-input"><input id="wpAuthor" name="wpAuthor" size="60"></td></tbody></table></form>');

       var uploader = new plupload.Uploader({
    		//runtimes : 'html5,flash',
    		runtimes : 'html5,flash,silverlight,html4',
    		browse_button : 'upload_select',
    		container : container_msu,
    		max_file_size : '100mb',
    		drop_element: 'upload_drop',
    		unique_names: false,
    		//multipart_params: {} ,     
        	url : msu_vars.path+'/../../api.php',
    		flash_swf_url : msu_vars.path+'/js/plupload/plupload.flash.swf',
    		silverlight_xap_url : msu_vars.path+'/js/plupload/plupload.silverlight.xap'
    		
	     /*
	     // Specify what files to browse for
        filters : [
	            {title : "Image files", extensions : "jpg,gif,png"},
	            {title : "Zip files", extensions : "zip"}
        ],
        // resize pictures
        //resize : {width : 320, height : 240, quality : 90}
        */	
    	});
    
    	uploader.bind('Init', function(up, params) {
    		status_div.html("<b>Debug</b> runtime: " + params.runtime + " drag/drop: "+ (!!up.features.dragdrop));
    		if(msu_vars.debugMode == 'false') status_div.hide(); //hide status if debug mode is disabled

    		if(up.features.dragdrop){
	        	
	        	var upload_drop = $(document.createElement("div")).attr("id","upload_drop").html('<span class="drop_text">'+mw.msg('msu-dropzone')+'</span>').insertAfter(status_div); 
	        	upload_drop.bind('dragover',function(event){
					   $(this).addClass('drop_over').css('padding','30px');
				}).bind('dragleave',function(event){
					   $(this).removeClass('drop_over').css('padding','0px');
				}).bind('drop',function(event){
					   $(this).removeClass('drop_over').css('padding','0px');
				});

	        }
    		
    	});


      uploader.bind('FilesAdded', function(up, files) {
    		$.each(files, function(i, file){
    			file.li = $(document.createElement("li")).attr("id",file.id).attr("class","file").appendTo(upload_list);
          file.li.type = $(document.createElement("span")).attr("class","file-type").appendTo(file.li);
          file.li.title = $(document.createElement("span")).attr("class","file-title").text(file.name).appendTo(file.li);
          file.li.size = $(document.createElement("span")).attr("class","file-size").text(plupload.formatSize(file.size)).appendTo(file.li);
          file.li.warning = $(document.createElement("span")).attr("class","file-warning").appendTo(file.li);
          file.li.container = $(document.createElement("span")).appendTo(file.li);
  				// file.li.remark = $(document.createElement("input")).attr("type","text").addClass("file-remark").appendTo(file.li).val("摘要").click(function(){
  				// 	if($(this).val()=="摘要")
  				// 		$(this).val("");
  				// }).blur(function(){
  				// 	if($(this).val()=="")
  				// 		$(this).val("摘要")
  				// });   
	        check_extension(file,up); 
	            
          file.li.remark = $('<table id="mw-htmlform-description"><tbody><tr class="mw-htmlform-field-HTMLTextField"><td class="mw-label"><label for="wpAuthor">&lt;作者&gt;</label></td><td class="mw-input"><input size="60" name="wpAuthor" id="wpAuthor"></td></tr><tr class="mw-htmlform-field-HTMLTextField"><td class="mw-label"><label for="wpSrcUrl">&lt;源地址&gt;</label></td><td class="mw-input"><input size="60" name="wpSrcUrl" id="wpSrcUrl"></td></tr></tbody></table>')
          .appendTo(file.li);
            	
    		});
    		up.refresh(); // Reposition Flash/Silverlight
    	});
	
     uploader.bind('QueueChanged', function(up) {
		uploader.trigger("CheckFiles", up);
     });
      
     uploader.bind('StateChanged', function(up) {
		if(msu_vars.debugMode == 'true') console.log(up.state);
		
		if (up.files.length === (up.total.uploaded + up.total.failed)) {
			//console.log('state: '+up.files.length)// all files uploaded --> trigger
		}
	});
	
	uploader.bind('FilesRemoved', function(up,files) {
		if(msu_vars.debugMode == 'true') console.log('file removed');
		uploader.trigger("CheckFiles", up);
	});

    uploader.bind('BeforeUpload', function(up, file) {
    	   	
    	file.li.title.text(file.name).show(); //show title
    	$('#' + file.id + " input.input_change").hide(); //hide input
    	
      var catagory = mw.config.get("wgPageName");
      var author = file.li.remark.find("#wpAuthor").val();
      var url = file.li.remark.find("#wpSrcUrl").val();
      var comment = "[[分类:"+catagory+"]]";
      if(author)comment+=" [[分类:作者:"+author+"]]";
      if(url)comment+=" 源地址:["+url+"]";

    	up.settings.multipart_params = {
    		filename : file.name,
    		token: mw.user.tokens.get( 'editToken' ),
    		action:"upload",
    		ignorewarnings:true,
    		comment:comment,
    		format:"json"
    	}; //set multipart_params
    	$('#' + file.id + " div.file-progress-bar").progressbar({value: '1'});
    	$('#' + file.id + " span.file-progress-state").html("0%");
    	
     });
      
     uploader.bind('UploadProgress', function(up, file) {
    	
    		$('#' + file.id + " span.file-progress-state").html(file.percent + "%");
        	$('#' + file.id + " div.file-progress-bar").progressbar({value: file.percent});
      		$('#' + file.id + ' div.file-progress-bar .ui-progressbar-value').removeClass('ui-corner-left');
      });
   
     uploader.bind('Error', function(up, err) {
    		
        	$('#' + err.file.id + " span.file-warning")
        	.html("Error: " + err.code +", Message: " + err.message + (err.file ? ", File: " + err.file.name : ""));
        	
    		status_div.append(err.message);
    		up.refresh(); // Reposition Flash/Silverlight
     });
    
     uploader.bind('FileUploaded', function(up, file, success) {

		if(msu_vars.debugMode == 'true') console.log(success);
		
		file.li.title.unbind('click');
		file.li.title.unbind('mouseover');
			
        $('#' + file.id + " div.file-progress").fadeOut("slow");
        $('#' + file.id + " div.file-progress-bar").fadeOut("slow");
        $('#' + file.id + " span.file-progress-state").fadeOut("slow");
            
            
		try{
			result = jQuery.parseJSON( success.response );
			
			if(result.error){
				//{"servedby":"taken-alpha","error":{"code":"nofilename","info":"The filename parameter must be set"}}
				file_error(file,result.error.info);
				
			} else {
			
			//alert(result.upload.result);
			/*{"upload":{"result":"Success",
						"filename":"Msupload_v8.4.jpg",
						"imageinfo":{
							"timestamp":"2012-02-28T14:52:05Z",
							"user":"L\u00fctz",
							"userid":4,
							"size":35491,
							"width":865,
							"height":292,
							"parsedcomment":"MsUpload",
							"comment":"MsUpload",
							"url":"...",
							"descriptionurl":"...",
							"sha1":"...",
							"metadata":...,
							"mime":"image\/jpeg",
							"mediatype":"BITMAP",
							"bitdepth":8
			}}}*/
			
			file.li.remark.hide();
			file.li.type.addClass('ok');
            file.li.addClass('green');
            file.li.warning.fadeOut("slow");

    		if(file.kat == true){ //should the categroy be set?
		        
		         sajax_do_call( 'wfMsUploadSaveKat', [file.name,wgPageName],function (response) {
		             //alert(response.responseText);
		         });
		        
		     } //if
    		
    		$(document.createElement("a")).text(mw.msg('msu-insert_link')).click(function(e) { //click
  			    if(msu_vars.use_mslinks == 'true'){
  			    	msu_vorlage_insert('{{#l:'+file.name+'}}','',''); // insert link		
  			    } else {
  			    	msu_vorlage_insert('[[:File:'+file.name+']]','',''); // insert link
  			    }
  			    
        	}).appendTo(file.li);
    		
            if (file.group == "pic"){
        		  
        		gallery_arr.push(file.name);	

        		  		
        		  if(gallery_arr.length== 2){ //only at first time add click function
	        		  		gallery_insert.click(function(e) { //click
	  			
	  							add_gallery(); //to take always the actual list

	        				}).text(mw.msg('msu-insert_gallery')).show();
	        				//spacer.show();
        		  } else if(gallery_arr.length< 2) {
        		  		
        		  	gallery_insert.html('');
        		  }

        		$(document.createElement("span")).text(' | ').appendTo(file.li);
        		$(document.createElement("a")).text(mw.msg('msu-insert_picture')).click(function(e) { //click
        			
        			msu_vorlage_insert('[[File:'+file.name+'|400px]]','','');
        			
        		}).appendTo(file.li);
        		
                
        	} else if (file.group == "mov") { //mov  
        		  
        		
        		$(document.createElement("span")).text(' | ').appendTo(file.li);
        		$(document.createElement("a")).text(mw.msg('msu-insert_movie')).click(function(e) { //click

        			msu_vorlage_insert('[[File:'+file.name+']]','','');
        			
        		}).appendTo(file.li);

        	} //movie
        	
        	}//else error
        	
        }catch(e){//try
			
			file_error(file,"Error: " + success.response.replace(/(<([^>]+)>)/ig,"")); //remove html tags

		}
		
		up.removeFile(file); //for preventing a second upload afterwards
		
     });
     
	 uploader.bind('UploadComplete', function(up, files) { 
	 		
	    	uploader.trigger("CheckFiles", up);  //trigger --> state changed
	    	start_button.hide();

	 });
	 
    uploader.bind('CheckFiles', function(up) { 

	   	if(msu_vars.debugMode == 'true') console.log(up.files.length);

	    if(gallery_arr.length >= 2){ 
	    	gallery_insert.show();
	        spacer.show();	
	   	}else{
	   		spacer.hide();
         	gallery_insert.hide();
	   	}
	   	
	    if (up.files.length==1){
        	bottom_div.show();
        	start_button.text(mw.msg('msu-upload_this')).show();
        } else if (up.files.length>1){
        	bottom_div.show();
        	start_button.text(mw.msg('msu-upload_all')).show();
        } else {
        	//bottom_div.hide();
         	start_button.hide();
         	if(gallery_arr.length < 2){ 
	    	bottom_div.hide();
	    	}
         	
        }
        
        up.refresh();
	 });
    	
    	
    	$('#upload_files').click(function(e) {
    		uploader.start();
    		e.preventDefault();
    	});
    	
    /*
    $('uploadfiles').onclick = function() {
          	uploader.start();
          	return false;
          };
        */
	
                
   uploader.init();

	

};//function

function add_gallery(){
	gallery_text = "Image:";
	gallery_text += gallery_arr.join("\nImage:");
	gallery_text +='\n';
	msu_vorlage_insert(gallery_text,'<gallery>\n\n','\n</gallery>\n'); 
}

function check_extension(file,uploader){
		if(msu_vars.debugMode == 'true') console.log(file);
		
        file.li.warning.html("<img src='"+msu_vars.path+"/images/loading.png'>");
		file.extension = file.name.split('.').pop().toLowerCase();

		if($.inArray(file.extension, wgFileExtensions) != -1) {
		    
		    switch(file.extension) {

       	 	  case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': case 'tif': case 'tiff': //pictures
       	 		file.group = "pic";
       	 		file.li.type.addClass('picture');
            	break;
			  case 'mov':
       	 		file.group = "mov";
             	break;
        	//case 'pdf':
            /* handle */
            //break;
    		}
    		
            check_file(file.name,file.li);
                   				
	        file.li.cancel = $(document.createElement("span")).attr("title",mw.msg('msu-cancel_upload')).click(function(e) {
	                file.li.fadeOut("slow");

	                if (file.group == "pic"){
					 	var idx = gallery_arr.indexOf(file.name); 	// Find the index
					 	if(idx!=-1) gallery_arr.splice(idx, 1); 	// Remove it if really found!
					 	uploader.trigger("CheckFiles", uploader); 	// If Picture is removed
        			}
        			uploader.removeFile(file);
        			uploader.refresh(); 
        			
	        }).attr("class","file-cancel").appendTo(file.li);
	            
            build(file); // alles aufbauen
            	

      } else { // wrong datatype
				
			file.li.container.hide(1, function() { //create callback
				uploader.removeFile(file);
				uploader.refresh();  	
			});

            file_error(file,mw.msg('msu-ext_not_allowed')+' '+wgFileExtensions.join(','));

      }//else
}

function check_file(filename,file_li){
		 	
          file_li.warning.html("<img src='"+msu_vars.path+"/images/loading.png'>");
              		         
          sajax_do_call( 'SpecialUpload::ajaxGetExistsWarning', [filename], 
        		function (result) {
        				
        		warning = result.responseText.replace(/(<([^>]+)>)/ig,"");

        		if ( warning == '' || warning == '&nbsp;' || warning =='&#160;') {
        			
        			file_li.warning.text(mw.msg('msu-upload_possible')).removeClass('small_warn');

        		} else {
        		
                	// errorhandling (string eventuell noch kuerzen)
                	file_li.warning.html('<span class=\'small_warn\'>'+warning+'</span>');
             
                } //else
       				
        	});
}

function file_error(file,error_text){
	
	file.li.warning.text(error_text);
    //file.li.type.addClass('document');
    file.li.addClass('yellow');
    file.li.type.addClass('error');
    
    file.li.click(function(e) { //bei klick li löschen
	   file.li.fadeOut("slow");
	})
	
	
}


function build(file){
   

      //fileindexer
      //if(autoIndex){
        	// new Element('input', {name:'fi['+file.id+']', 'class':'check_index',type: 'checkbox', 'checked': true}).inject(file.ui.title, 'after');
    	  //new Element('span', {'class':'check_span',html: 'Index erstellen'}).inject(file.ui.title, 'after'); 
      //}

      //autokat
      if(msu_vars.autoKat){
      	file.kat = false;
        if(wgNamespaceNumber==14){ //category page
        	
        	if(msu_vars.autoChecked=='true')  file.kat = true; //predefine

        	$(document.createElement("input")).attr({
        		'class':'check_index',	
        		type: 'checkbox',
        		'checked': file.kat
        	}).change(function(e) {
	        
	          file.kat = this.checked; // save
	        
	        }).appendTo(file.li);
    	  	
    	  	$(document.createElement("span")).attr("class","check_span").text(wgPageName.replace(/_/g, " ")).appendTo(file.li); 
   
        }
      } 
      

    	file.li.title.mouseover(function() { //mouseover
			$(this).addClass('title_over');
    	 }).mouseleave(function() {		//mouseout	
    		$(this).removeClass('title_over');
  		}).click(function(e) { //click
  			
  			$(this).hide();
  			var input_change = $(document.createElement("input")).attr({
	          'class':'input_change',
	          size:file.name.length,
	          //id: 'input_change-'+file.id,
	          name:'filename',
	          value:file.name
        	}).insertAfter($(this));  
        
	        input_change.change(function(e) {
	        
	          file.name = this.value; //neuen namen speichern
	          check_file(this.value,file.li);
	        
	        });
  			
  		});

    file.li.append('<div class="file-progress"><div class="file-progress-bar"></div><span class="file-progress-state"></span></div>'); 
}