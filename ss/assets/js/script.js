$(document).ready(function(){
photos1=$('#photos1');
photos2=$('#photos2');
photos3=$('#photos3');
photos4=$('#photos4');
	var template = "<img class='cam' style='display:none' src='uploads/Ann/cam/{src}'>";
		template1 = "<img  class='scr' style='display:none' src='uploads/Ann/scr/{src}'>";
	var start = '';
		var start1 = '';
		function templateReplace(template,data){
		return template.replace(/{([^}]+)}/g,function(match,group){
			return data[group.toLowerCase()];
		});
	}	
	template1 = "<img  class='scr' style='display:none' src='uploads/Ann/scr/{src}'>";
	function loadPics(){
		if(this != window){
			if($(this).html() == 'Loading..'){
				// Preventing more than one click
				return false;
			}
			$(this).html('Loading..');
	}
		$.getJSON('browse.php',{'start':start},function(r){
			photos1.find('a').show();
/* 			var loadMore = $('#loadMore').detach();
			if(!loadMore.length){
				loadMore = $('<span>',{
					id			: 'loadMore',
					html		: 'Load More',
					click		: loadPics
				});
			} */
			$.each(r.files,function(i,filename){
			photos1.append(templateReplace(template,{src:filename}));
			});
			$('.cam').first().attr('style','display:block'); 
			$('.cam').bind("mousewheel DOMMouseScroll", function (e) {
	        if(e.originalEvent.detail > 0  ||  e.originalEvent.wheelDelta < 0 ) {
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
			// If there is a next page with images:			
			if(r.nextStart){
				// r.nextStart holds the name of the image
				// that comes after the last one shown currently.
				start = r.nextStart;
				photos1.find('a:last').hide();
//				photos1.append(loadMore.html('Load More'));
			}
		});		
		$.getJSON('browse1.php',{'start1':start1},function(r){
/* 			photos2.find('a').show();
			var loadMore1 = $('#loadMore1').detach();
			if(!loadMore1.length){
				loadMore1 = $('<span>',{
					id			: 'loadMore1',
					html		: 'Load More',
					click		: loadPics
				});
			} */
			$.each(r.files,function(i,filename){
				photos2.append(templateReplace(template1,{src:filename}));
			});
			$('.scr').first().attr('style','display:block');
$('.scr').bind("mousewheel DOMMouseScroll", function (e) {
	        if(e.originalEvent.detail > 0 ||  e.originalEvent.wheelDelta < 0 ) {
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
			// If there is a next page with images:
			if (r.nextStart){
				// r.nextStart holds the name of the image
				// that comes after the last one shown currently.
				start1 = r.nextStart;
				photos2.find('a:last').hide();
//				photos2.append(loadMore1.html('Load More'));
			}
		});
		return false;
	}
loadPics();
});