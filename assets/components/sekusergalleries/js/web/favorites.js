$(document).ready(function(){ 

	$("#favoriteListWrap li:first").hide();

	$(".favorite_link a").click(function() {
		var albumItemIDValSplitter	= (this.id).split("_");
		var albumItemIDVal = albumItemIDValSplitter[1];
		
		var productX = $("#productImageWrapID_" + albumItemIDVal).offset().left;
		var productY = $("#productImageWrapID_" + albumItemIDVal).offset().top;
		
		if( $("#albumItemID_" + albumItemIDVal).length > 0){
			var basketX = $("#albumItemID_" + albumItemIDVal).offset().left;
			var basketY = $("#albumItemID_" + albumItemIDVal).offset().top;
		} else {
			var basketX = $("#favoriteTitleWrap").offset().left;
			var basketY = $("#favoriteTitleWrap").offset().top;
		}
		
		var gotoX = basketX - productX;
		var gotoY = basketY - productY;
		
		var newImageWidth = $("#productImageWrapID_" + albumItemIDVal).width() / 3;
		var newImageHeight = $("#productImageWrapID_" + albumItemIDVal).height() / 3;
		
		$("#productImageWrapID_" + albumItemIDVal + " img")
		.clone()
		.prependTo("#productImageWrapID_" + albumItemIDVal)
		.css({'position' : 'absolute'})
		.animate({opacity: 0.4}, 100 )
		.animate({opacity: 0.1, marginLeft: gotoX, marginTop: gotoY, width: newImageWidth, height: newImageHeight}, 1200, function() {

			$("#notificationsLoader").html('<img src="'+image_loader_url+'">');
		
			$.ajax({  
				type: "POST",  
				url: helper_url,
				data: { albumItemID: albumItemIDVal, action: "addToFavorites"},
				success: function(theResponse) {
					
					if( $("#albumItemID_" + albumItemIDVal).length > 0){
						$("#albumItemID_" + albumItemIDVal).animate({ opacity: 0 }, 500);
						$("#albumItemID_" + albumItemIDVal).before(theResponse).remove();
						$("#albumItemID_" + albumItemIDVal).animate({ opacity: 0 }, 500);
						$("#albumItemID_" + albumItemIDVal).animate({ opacity: 1 }, 500);
						$("#notificationsLoader").empty();
						
					} else {
						$("#favoriteListWrap li:first").before(theResponse);
						$("#favoriteListWrap li:first").hide();
						$("#favoriteListWrap li:first").show("slow");
						$("#notificationsLoader").empty();			
					}
					
				}  
			});  
		
		});
		
	});
	
	$("#favoriteListWrap li img").live("click", function(event) {
		var albumItemIDValSplitter 	= (this.id).split("_");
		var albumItemIDVal 			= albumItemIDValSplitter[1];

		$("#notificationsLoader").html('<img src="'+image_loader_url+'">');
	
		$.ajax({  
			type: "POST",  
			url: helper_url,
			data: { albumItemID: albumItemIDVal, action: "removeFromFavorites"},
			success: function(theResponse) {
				
				$("#albumItemID_" + albumItemIDVal).hide("slow",  function() {$(this).remove();});
				$("#notificationsLoader").empty();
			
			}  
		});  
		
	});

});
