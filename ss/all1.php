<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" /> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
</head>
<body>
<table>
<tr><td>
<div id="cam0"></div>
</td><td>
<div id="scr0"></div></td></tr>
<tr><td>
<div id="cam1"></div>
</td><td>
<div id="scr1"></div></td></tr>
<tr><td>
<div id="cam2"></div>
</td><td>
<div id="scr2"></div></td></tr>
<tr><td>
<div id="cam3"></div>
</td><td>
<div id="scr3"></div></td></tr>
</table>
</body>
<script>
$(document).ready(function(){
	$.ajaxSetup({
async: false
});
users=<?php echo $_GET['users'];?>;
hm=<?php echo $_GET['hm'];?>;
var start = '';
user_ar=users.split(':');
$.each( user_ar, function( i, u_name ){	
	template = "<img class='cam_"+u_name+"' style='display:none' src='uploads/"+u_name+"/cam/{src}'></img>";

  		$.getJSON('browse_cam.php',{'start':start,'u_name':u_name,'hm':hm},function(r){	

			$.each(r.files,function(j,filename){
				$('#cam'+i).append(templateReplace(template,{src:filename}));

			});
	w		$('.cam_'+u_name).first().attr('style','display:block'); 
					
			$('.cam_'+u_name).bind("mousewheel DOMMouseScroll", function (e) {
	        if(e.originalEvent.detail > 0  ||  e.originalEvent.wheelDelta < 0 ) {
				if($(this).next().attr('style')){
					$(this).attr('style','display:none');
					$(this).next().attr('style','display:block');
				}
	w		}
			else{
			if($(this).prev().attr('style')){
					$(this).attr('style','display:none');
	w				$(this).prev().attr('style','display:block');
				}
			}
			});

		});		
 		template1 = "<img class='scr_"+u_name+"'style='display:none' src='uploads/"+u_name+"/scr/{src}'></img>";
  		$.getJSON('browse_scr.php',{'start':start,'u_name':u_name,'hm':hm},function(r){
			$.each(r.files,function(j,filename){$('#scr'+i).append(templateReplace(template1,{src:filename}));});
			$('.scr_'+u_name).first().attr('style','display:block'); 

			$('.scr_'+u_name).bind("mousewheel DOMMouseScroll", function (e) { // прокручиватель фоток
	        if(e.originalEvent.detail > 0  ||  e.originalEvent.wheelDelta < 0 ) { //это для FF и хрома 
				if($(this).next().attr('style')){
					$(this).attr('style','display:none');
					$(this).next().attr('style','display:block');
				}
			}
			else{
			if($(this).prev().attr('style')){
					$(this).attr('style','display:none');
					$(this).prev().attr('style','display:block');
				}
			}
			});

		});   
		
});
});
		function templateReplace(template,data){
		return template.replace(/{([^}]+)}/g,function(match,group){
			return data[group.toLowerCase()];
		});
	}
		/* function add_pic(u_name,ii){
				las_cam=$('.cam_'+u_name).first().attr('src').substr(-12);
				las_scr=$('.scr_'+u_name).first().attr('src').substr(-12);
  		$.getJSON('add_pic.php',{'last_scr':las_scr,'last_cam':las_cam,'u_name':u_name},function(r){
		$.each(r.scr,function(j,filename){$('#scr+ii).append(templateReplace(template1,{src:filename}));});
		$.each(r.cam,function(j,filename){$('#cam+ii).append(templateReplace(template,{src:filename}));});
		$('.scr_'+u_name).first().attr('style','display:block'); 
		$('.scr_'+u_name).bind("mousewheel DOMMouseScroll", function (e) { // прокручиватель фоток
	        if(e.originalEvent.detail > 0  ||  e.originalEvent.wheelDelta < 0 ) { //это для FF и хрома 
				if($(this).next().attr('style')){
					$(this).attr('style','display:none');
					$(this).next().attr('style','display:block');
				}
			}
			else{
			if($(this).prev().attr('style')){
					$(this).attr('style','display:none');
					$(this).prev().attr('style','display:block');
				}
			}
			});

		});   
	n = setTimeout(arguments.callee, 10000);
	}		}	 */
</script>















</html>