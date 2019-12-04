jQuery(document).ready(function($) {
    $('.individual-rating').on("click", function(){
		$(this).parent().prev('.rating').find('.rating-value').text($(this).attr('data-rating'));
		$(this).parent().prev('.rating').find('.rating-desc').text($(this).attr('data-desc'));
        $(this).removeClass('active').nextAll('.individual-rating').removeClass('active');
        $(this).addClass('active').prevAll('.individual-rating').addClass('active');
		
		var last=$(this).parent().find('li.active:last');
		$(this).parents('.rating-bar-container').next().val(last.attr('data-rating'));
    });
	
    $('.individual-rating').hover(
		function() {
			$(this).parent().prev('.rating').find('.rating-value').text($(this).attr('data-rating'));
			$(this).parent().prev('.rating').find('.rating-desc').text($(this).attr('data-desc'));
		},
		function() {
			if($(this).parent().find('li.active').length > 0){
				var last=$(this).parent().find('li.active:last');
				$(this).parent().prev('.rating').find('.rating-value').text(last.attr('data-rating'));
				$(this).parent().prev('.rating').find('.rating-desc').text(last.attr('data-desc'));
			}
			else{
				$(this).parent().prev('.rating').find('.rating-value').text('');
				$(this).parent().prev('.rating').find('.rating-desc').text('');
			}
		}
	);
	
	$('#other').on("click", function(){
		if($('#text6').css('display') == 'none')
			$('#text6').css("display", "block");
		else
			$('#text6').css("display", "none");
	});
	$('#everyone').on("click", function(){
		$('#text6').css("display", "none");
	});
	$('#couples').on("click", function(){
		$('#text6').css("display", "none");
	});
	$('#travelers').on("click", function(){
		$('#text6').css("display", "none");
	});
	$('#students').on("click", function(){
		$('#text6').css("display", "none");
	});
	$('#families').on("click", function(){
		$('#text6').css("display", "none");
	});
	
	var j = 0;
    function readURL(input) { 
        
        if(input.files.length>6)
        {
          alert("Plaese Input Maximum 6 Image.");
          
          return;
        }
        
        for(var i=0; i<input.files.length; i++)
		{
			if(input.files[i].size > 5242880){
			    alert("Image Size Must Be 5 MB or Less");
				return;
			}
		}
        
		for(i=0; i<input.files.length; i++)
		{
			if (input.files && input.files[i]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#fileImg'+j).attr('src', e.target.result);
					j++;
				}            
				reader.readAsDataURL(input.files[i]);
			}
		}
		if(i<6)
		{
		   for(i=i; i<6; i++)
		       $('#fileImg'+i).attr('src','');
		    
		}
		j=0;
        
    }    
    $("#inputFile").change(function(){
        readURL(this);
    });
	
	
	//$(".accorTitle").click(function(e) {
	$(".review_part").on("click", ".accorTitle", function(e) {
        $(this).next('.accorConte').slideToggle('slow');
        return false;
    });
	
	var rating_filter;
	
	$("#sort_review").change(function(){
		
		rating_filter = '';
		if($("#rating_5").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_5").val()+' OR ';
		if($("#rating_4").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_4").val()+' OR ';
		if($("#rating_3").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_3").val()+' OR ';
		if($("#rating_2").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_2").val()+' OR ';
		if($("#rating_1").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_1").val();
		
		
		$(".review_part").hide();
		$(".ajax_box").show();
		var info = {
                    action: 'update_sort_by',
					sort_by_rating: rating_filter,
					sort_by: $(this).val(),
                };
		$.post(ajax_url,info,function(msg){
			$(".review_part").show();
			$(".ajax_box").hide();
			$(".review_part").html(msg.update_status);
			$(".nonZeroCount span").text(msg.update_value);
			
			$('.review-photo li a').fancybox();
		}, 'json');
		
	});
	
	$(".rating").click(function(){
		rating_filter = '';
		if($("#rating_5").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_5").val()+' OR ';
		if($("#rating_4").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_4").val()+' OR ';
		if($("#rating_3").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_3").val()+' OR ';
		if($("#rating_2").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_2").val()+' OR ';
		if($("#rating_1").attr('checked'))
			rating_filter = rating_filter + 'wp_survay_table.overall_rating = '+$("#rating_1").val();
		
		$(".review_part").hide();
		$(".ajax_box").show();
		var info = {
                    action: 'update_sort_by',
					sort_by_rating: rating_filter,
					sort_by: $("#sort_review").val(),
                };
		$.post(ajax_url,info,function(msg){
			$(".review_part").show();
			$(".ajax_box").hide();
			$(".review_part").html(msg.update_status);
			$(".nonZeroCount span").text(msg.update_value);
			
			$('.review-photo li a').fancybox();
		}, 'json');
		
	});
	
	
});



function maxLength(el) {	
	if (!('maxLength' in el)) {
		var max = el.attributes.maxLength.value;
		el.onkeypress = function () {
			if (this.value.length >= max) return false;
		};
	}
}
maxLength(document.getElementById("text"));