$(function() {

	//find links in todos
	$('p.todo').each(function (index, domEle) {
		content = $(domEle).html(); 
		content =  content.replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,"<a href='$1' target='_blank'>$1</a>");
		$(domEle).html(content)
	});
	
	function handleResize(){
		log($('div#centered').outerHeight());
		if($('div#centered').outerHeight() > $(window).height()){
			$('div#centered').css('top','0%');
			$('div#centered').css('margin-top','20px');
			$('div#centered').css('margin-bottom','50px');
		}else{
			$('div#centered').css('top','50%');
			$('div#centered').css('margin-top',-$('div#centered').outerHeight()/2);
			$('div#centered').css('margin-bottom','0px');
		}
		
	
		$('div#centered').css('margin-left',-$('div#centered').outerWidth()/2);
		resizeColorBlocks();
	}

	$(window).resize(function() {
		handleResize();
	});
	
	handleResize();
	
	//remove error after a few seconds
	$('.error').delay(5000).slideUp(300);
	
});

function resizeColorBlocks(){
  $('.color').each(function(index) {
	$(this).height($(this).parent().first().outerHeight()-1);
  });
}


// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
function log(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;  
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});

