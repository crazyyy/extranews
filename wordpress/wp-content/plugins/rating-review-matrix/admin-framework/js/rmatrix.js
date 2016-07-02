jQuery(document).ready(function($){
	$("#admin_tabs li").live("click",function(event){
	$(this).siblings().removeClass('selected');
	$(this).addClass('selected');
	var the_content = $(this).data("the_content");
	$("#container_body .settings-container").hide();
	$("#"+the_content).slideDown("slow");
	
	});
	
	$(".accordion").smk_Accordion({ 
			showIcon: true, //boolea
			animation: true, //boolea
			closeAble: false, //boolean
			slideSpeed: 300 //integer, miliseconds
	});
	$("#contact_us_here").live("click",function(event){
		$("#support_inlineform").show("slow");
	});
	$("#cancel_send").live("click",function(event){
		$("#support_inlineform").hide("slow");
	});
	

/****************** Toggles **************************/
	$(".toggle_").live("click",function(event){
		var the_ID = $(this).attr("id");
		var the_input = $("#"+the_ID).data('toggle-name');	
		var main_right = $("#"+the_ID).find('.right');
		var main_left = $("#"+the_ID).find('.left');
 		$(main_right).removeClass("right").addClass("left");
		$(main_left).removeClass("left").addClass("right");
		
		if($("#"+the_ID+ " .the_words").html()=='Yes'){
			$("#"+the_ID+ " .the_words").html(function(n){ return "No"; } );
			$(this).removeClass("yes").addClass("no")
			}else{
			$("#"+the_ID+ " .the_words").html(function(n){ return "Yes"; } );
			$(this).removeClass("no").addClass("yes");
			}
		if($("input[id="+the_input+"]").val()=='0'){
			$("input[id="+the_input+"]").val("1")
			}else{
			$("input[id="+the_input+"]").val("0")
			}

		
	})
/**************************************** / Toggles *************************************/
/************************************* AJAX AND FORM STUFF ******************************/
$(".save_settings_1").live( "click", function( event ) {
	var the_Form = $(this ).closest( "form" ).attr("id");
	var return_msg = $("#"+the_Form+" .message_saving" );
  event.preventDefault();
  console.log( $(  "#"+the_Form ).serialize() ); //serialize form on client side
  var pdata = {
     action: "saveRmatrixSettings",
	 curret_user: $("#current_user_id").val(),
     postdata: $("#"+the_Form).serialize(),
  }
  $.post(ajaxurl, pdata, function( data ) {
    $(return_msg).html(data).show("slow").delay(5000).hide("slow");
		
	  });
	
	});
/************************************* /AJAX AND FORM STUFF ******************************/

/**************************************/
	jQuery('#cancel_send').live("click", function(event){ 
		$('#rmatrix_admin_emails').val(''); 
		
	});	
	$("#send_request").live("click",function(event){
  event.preventDefault();
  console.log( $(  "#contact_devs_" ).serialize() ); //serialize form on client side
	  var pOSTINdata = {
		 action: "contactDevsRmatrix",
		 postdata2: $("#contact_devs_").serialize(),
	  }
	  $.post(ajaxurl, pOSTINdata, function( response ) {
		  alert(response);
		$('#support_inlineform').hide();
			
		  });
	});
	$("#cancel_send").live("click",function(event){
		$(parent.document).find('#support_inlineform').hide();
	});
/**************************************/
});