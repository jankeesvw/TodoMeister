function checkVersion(){
	$.ajax({
	  url: version_url,
	  cache: false,
	  success: function(html){
			if($('body').hasClass('dontReload') == true){
				$('body').removeClass('dontReload')
				currentVersion = html;
			}else if(currentVersion != html){
				window.location.reload();
			}
	  }

	});
	setTimeout(checkVersion, 10000);
}

$('body').addClass('dontReload');

checkVersion();

//set title of the HTML page
$( "title" ).html(head_title);