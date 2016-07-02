<?php function rmatrix_admin_html_main(){?>
<style>
.clear{ clear:both}
/* get rid of those system borders being generated for A tags */
a:active {
    outline:none;
}
a{ font-style:normal;}
:focus {
    -moz-outline-style:none;
}

/* root element for tabs  */
ul.tabs {
    list-style:none;
    margin:0 !important;
    padding: 20px 20px 0px 55px;
    border-bottom:1px solid #666;
    height:30px;
}

/* single tab */
ul.tabs li {
    float:left;
    text-indent:0;
    padding:0;
    margin:0 !important;
    list-style-image:none !important;
}

/* link inside the tab. uses a background image */
ul.tabs a {
    background: url(<?php echo RMATRIX_PLUGIN_URL; ?>/images/blue.png) no-repeat -420px 0;
    font-size:11px;
    display:block;
    height: 30px;
    line-height:30px;
    width: 134px;
    text-align:center;
    text-decoration:none;
    color:#333;
    padding:0px;
    margin:0px;
    position:relative;
    top:1px;
}

ul.tabs a:active {
    outline:none;
}

/* when mouse enters the tab move the background image */
ul.tabs a:hover {
    background-position: -420px -31px;
    color:#fff;
}

/* active tab uses a class name "current". its highlight is also done by moving the background image. */
ul.tabs a.current, ul.tabs a.current:hover, ul.tabs li.current a {
    background-position: -420px -62px;
    cursor:default !important;
    color:#000 !important;
}

/* Different widths for tabs: use a class name: w1, w2, w3 or w2 */


/* width 1 */
ul.tabs a.s { background-position: -553px 0; width:81px; }
ul.tabs a.s:hover { background-position: -553px -31px; }
ul.tabs a.s.current  { background-position: -553px -62px; }

/* width 2 */
ul.tabs a.l { background-position: -248px -0px; width:174px; }
ul.tabs a.l:hover { background-position: -248px -31px; }
ul.tabs a.l.current { background-position: -248px -62px; }


/* width 3 */
ul.tabs a.xl { background-position: 0 -0px; width:248px; }
ul.tabs a.xl:hover { background-position: 0 -31px; }
ul.tabs a.xl.current { background-position: 0 -62px; }

.tabs .selected{background-position: 0 -31px !important}
/* initially all panes are hidden */
.panes .pane {
    display:none;
}
/* tab pane styling */
.panes div {
    padding:15px 10px;
    border-top:0;
    font-size:14px;
    background-color:#fff;
}    /* tooltip styling. by default the element to be styled is .tooltip  */
  .tooltip {
    display:none;
    background:transparent url(<?php echo RMATRIX_PLUGIN_URL; ?>/images/black_arrow.png);
    font-size:12px;
    height:70px;
    width:160px;
    padding:25px;
    color:#eee;
	text-align:center;
  }
    /* style the trigger elements */
  #demo img {
    border:0;
    cursor:pointer;
    margin:0 1px;
  }
 .container__{}
.existing_matrices{ min-height: 150px; width: 95%;border-top:#000 dotted 2px; padding: 20px;}
#add_new_matrix_img{ float:left; cursor: pointer; margin: -8px 5px 0 0}
#matrix_id{ margin-left: -44px; width: 323px; height: 30px;}
.lower_line{  width: 90%; text-align:center}
.add_new_matrix{ padding: 20px; border-top: #000 double 3px;}
.container_multi{ padding-top: 20PX; margin-top: 20px;}
.title_matrix_{ background:#E1F5FF; padding: 10px; -moz-border-radius: 5px; border-radius: 5px; margin-top: 5px; display:block}
#server_response{ padding: 20px; font-size:22px; margin-top: 10px;}
.title_matrix_ button{ cursor:pointer;}
.odd{ background:#D1E0D5; padding: 5px;}
.even{ background:#FDEEFD; padding: 5px;}
#rating_container .odd{ background:#D1E0D5; padding: 5px; min-height: 50px;}
#rating_container .even{ background:#FDEEFD; padding: 5px; min-height: 50px;}
#add_matrix_field{ height: 34; width: 34; cursor:pointer}
#ratings_table div{ background: none}
span.field_title_{  margin-right: 200px;}
.invalid{ border:#F00 3px solid !important}
.remove_field{ margin-top: 5px; margin-left: 5px; width: 20px; cursor:pointer;}
.manage_matrices{ width: 99%}
.matrix_row{ width: 95%;}
.matrix_row .matrix_title_ , .matrix_row .matrix_entries_, .matrix_row .matrix_manage_,.matrix_row .matrix_other_ { float:left; min-width: 220px; min-height: 25px; padding: 10px; font-size:16px; font-weight: bold}
 .matrix_row_{ height: 35px;}
 .matrix_row_ div{ float:left;}
 .rating_id{ width: 175px;}
 .rating_value{ width: 175px;}
 .rating_user{ width: 175px;}
 .rating_time{ width: 175px;}
 .matrix_manage_ div{ border-radius: 5px; padding: 5px; background:#060 !important; display: none; color: #FFF; cursor: pointer;}
</style>
<!-- the tabs -->
<title>rating_id rating_value rating_user rating_time</title>
<ul class="tabs">
	<li data-the_content="main"><a href="#" class="current"><?php _e('Manage Matrices','rmatrix') ?></a></li>
	<li data-the_content="ratings"><a href="#"><?php _e('Matrix Ratings','rmatrix') ?></a></li>
</ul>
 
<!-- tab "panes" -->
<div class="panes">

  <div data-the_content="main" class="container__">
    <h1><?php _e('Create Rating Matrices','rmatrix') ?></h1>
    <p><i><?php _e('In this section, you will create matrices that will be used for rating','rmatrix'); ?></i></p>
    <section class="add_new_matrix">
    <span>
    <img src="<?php echo RMATRIX_PLUGIN_URL; ?>/images/add-matrix.png" title="Click on this to add a new Matrix of ratings" id="add_new_matrix_img" /> <i><?php _e('You will be able to set the Matrix components after you create it','rmatrix'); ?></i>
    </span><br class="clear" />
    <span id="messages">
    
    <br class="clear" />
    </span>
    
    <br class="clear" />
    <span class="container_multi">
    
    </span>
        <response id="server_response"></response><br class="clear" />
    </section>
    <br class="lower_line"  />

   <section class="existing_matrices">
    <h1><?php _e('Existing Matrices','rmatrix') ?></h1>
    <?php 
	global $wpdb;
	$existing_ones = $wpdb->get_results( "SELECT * 	FROM $wpdb->posts WHERE post_type = 'review_matrix' ORDER BY ID DESC");
	$i = 0;?>
    <table >
  <tr class="matrix_row odd" style="height:40px;">
 	<td class="matrix_title_" width="30"><?php _e('ID','rmatrix'); ?></td>
    <td class="matrix_title_" width="200"><?php _e('Matrix title','rmatrix'); ?></td>
    <td class="matrix_entries_" width="200"><?php _e('Matrix entries','rmatrix'); ?></td>
    <td class="matrix_manage_" width="150"><?php _e('Manage the matrix','rmatrix'); ?></td>
  </tr>
	<?php 
foreach ( $existing_ones as $existing_one ) { ?>


  <tr class="matrix_row <?php echo is_number_odd_even($i); ?>">
  	<td class="matrix_title_" width="30"><?php echo $existing_one ->ID; ?></td>
    <td class="matrix_title_" width="200" style="font-weight:200"><?php echo $existing_one ->post_title; ?></td>
    <td class="matrix_entries_" width="200"><?php 
	
	global $wpdb;
	$matrix_fields = $wpdb->get_results( "SELECT * 	FROM ".$wpdb->prefix."rmatrix_fields". " WHERE matrix_id = '".$existing_one ->ID."'"); foreach($matrix_fields as $matrix_field){ echo "[".$matrix_field->field_title."]<br>";} ?></td>
    <td class="matrix_manage_" width="150" id="<?php echo $existing_one->ID ;?>"><select name="manage_matrix" id="manage_matrix">
    					<option value="none" selected><?php _e(' - - - - - ','rmatrix'); ?></option>
    					<option value="delete"><?php _e('Delete','rmatrix'); ?></option>
                        <option value="update" disabled="disabled"><?php _e('Update','rmatrix'); ?></option>
                        <option value="reset"  disabled="disabled"><?php _e('Reset the Ratings','rmatrix'); ?></option>
                        </select><div data-confirmer="confirm_action" data-matrix-now="<?php echo $existing_one->ID ;?>" id="confirm-<?php echo $existing_one->ID ;?>"></div>
     </td>
  </tr>


<?php $i=$i +1;}  ?>
</table>
    </section>
    </div>
	<div data-the_content="ratings" class="container__" style="display:none">
	<h1><?php _e('Matrix Ratings','rmatrix') ?></h1>
	<div id="rating_container">
    <?php
	global $wpdb;
	$matrix_ratings = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."rmatrix_ratings"); 
	$i=1;
	echo '<div id="ratings_table">';
		echo '<div class="matrix_row_">';
		echo '<div class="rating_id">'.__('Rating ID','rmatrix').'</div>';
		echo '<div class="rating_value">'.__('Rating Value','rmatrix').'</div>';
		echo '<div class="rating_user">'.__('Rating User','rmatrix').'</div>';
		echo '<div class="rating_time">'.__('Time recorded','rmatrix').'</div>';
		echo '</div><div class="clear"></div>';
	foreach($matrix_ratings as $matrix_rating){
		$field_ID = $matrix_rating->matrix_field_id;
		$myField = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.'rmatrix_fields'." WHERE field_id = '$field_ID'", ARRAY_A);
		$the_Date = date("D, d M Y", strtotime($matrix_rating->date_recorded));
		echo '<div class="matrix_row_ '.is_number_odd_even($i).'">';
		echo '<div class="rating_id">'.$matrix_rating->rating_id.'</div>';
		echo '<div class="rating_value">'.$matrix_rating->rating_value.'/'.$myField['rating_out_of'].'</div>';
		echo '<div class="rating_user">'.$matrix_rating->rating_user.'</div>';
		echo '<div class="rating_time">'.$the_Date.'</div>';
		echo '</div>';
		$i++;
		}
	echo '</div>';
	?>
    </div> 
    <div class="pagination"><?php //pagination_backend();  ?></div> 
    </div>
</div>
<!-- activate tabs with JavaScript -->

<script>
jQuery(document).ready(function($){

					function loading_show_self(){
		jQuery(this).html("<img src='<?php echo RMATRIX_PLUGIN_URL; ?>/images/load.gif'/> <?php _e('Please wait...','rmatrix'); ?>").fadeIn();
					}
					function loading_show(){
	 jQuery('#messages').html("<img src='<?php echo RMATRIX_PLUGIN_URL; ?>/images/load.gif'/> <?php _e('Please wait...','rmatrix'); ?>").fadeIn();
					}
					function loading_hide(){
						jQuery('#messages').fadeOut();
					}   // END loading_hide()
					function enable_more_fields(){  
						 
						jQuery("#add_matrix_field").removeAttr("disabled");
					}
					function disable_more_fields(){  
						 
						jQuery("#add_matrix_field").attr("disabled","disabled");
					}
					function enable_submit(){
							var empties = jQuery("input[is_field='yes']").filter(function () {
								return jQuery.trim(jQuery(this).val()) == '';
							});
							if (empties.length) { /* Error!  alert('One of the fields is empty');*/
							jQuery("#create_matrix").attr("disabled","disabled");
							
							}else{
								 //alert('NONE is empty');
								 jQuery("#create_matrix").removeAttr('disabled');
								}
						}
					function validate_fields(field_id){
						var matrix_field_value = jQuery("#"+field_id).val();
						if(matrix_field_value==''){
							// jQuery(this).addClass("validate");
							 //alert(matrix_field_value);
							}
						
					}
					function remove_field(field_to_remove){
						jQuery('span').remove('#'+field_to_remove);
						}
					function is_lower(field_position,comparer){
						var current_position = parseInt(field_position);  
						return !!(field_position < parseInt(comparer));
						}
					function resetForm($form) {
						$form.find('input:text, input:password, input:file, select, textarea').val('');
						$form.find('input:radio, input:checkbox')
							 .removeAttr('checked').removeAttr('selected');
					}
					// to call, use:
					// resetForm($('#myform')); by id, recommended
					
					function add_new_matrix(){
						jQuery('.container_multi').html('<span class="title_matrix_"><span class="field_title_"><?php _e('New matrix Title','rmatrix'); ?></span><input type="text" name="matrix_title" id="matrix_id" /></span><input type="hidden" name="field_counter" id="field_counter" value="2" />').fadeIn();
						jQuery('.container_multi').append('<span class="title_matrix_"><span class="field_title_"><?php _e('Out of','rmatrix'); ?></span><select name="matrix_out_of" id="matrix_out_of"><option value="5">/5</option><option value="10" selected="selected">/10</option></select>').fadeIn();
						jQuery('.container_multi').append('<span class="title_matrix_"><span class="field_title_"><?php _e('Field #1','rmatrix'); ?></span><input type="text" name="field_1_title" id="field_1_title" is_field="yes" field_position="1"/><input type="text" name="field_1_slug" id="field_1_slug" is_slug="yes" readonly /></span>');
						jQuery('.container_multi').append('<span class="title_matrix_"><span class="field_title_"><?php _e('Field #2','rmatrix'); ?></span><input type="text" name="field_2_title" id="field_2_title" is_field="yes" field_position="2"/><input type="text" name="field_2_slug" id="field_2_slug" is_slug="yes" readonly /></span><span id="more_fields_in_case"></span>');
						jQuery('.container_multi').append('<span class="title_matrix_" id="add_matrix_last"><input type="button" id="add_matrix_field" value="<?php _e('Add new field','rmatrix'); ?>" /><input type="button" value="<?php _e('Create','rmatrix'); ?>" id="create_matrix" disabled="disabled"></span>');
						}
					function add_more_fields(field_number){
						var counter = parseInt(jQuery('#field_counter').val());
						var new_index = counter + 1;
						var new_counter = counter + field_number; 
						var remaining_fields = 10 - new_counter;
						//alert(remaining_fields); 
						jQuery("#field_counter").val(new_counter);
						for(var i = new_index; i <= new_counter; i++) {
							if(i === 10){disable_more_fields();}else{
jQuery('#more_fields_in_case').append('<span class="title_matrix_" id="field_id_'+i+'"><span class="field_title_"><?php _e('Field ','rmatrix'); ?> #'+i+'</span><input type="text" name="field_'+i+'_title" id="field_'+i+'_title" is_field="yes" field_position="'+i+'"/><input type="text" name="field_'+i+'_slug" id="field_'+i+'_slug" is_slug="yes" readonly /><img src="<?php echo RMATRIX_PLUGIN_URL; ?>/images/remove-field.png" id="field_'+i+'_title_image"  class="remove_field" data-counter="'+i+'" /></span>'); 
							}
						 }/**/
						//disable_more_fields();				
						}
					function create_slug(origin_element , destination_element ){
					var field_counter = jQuery("#field_counter").val();
					var str = jQuery("#"+origin_element).val();						
						str = str.replace(/[^a-zA-Z0-9-_\s]/g,"");						
						str = str.toLowerCase();						
						str = str.replace(/\s/g,'-');						
						//document.write(str);
						//alert (str);
						jQuery("#"+destination_element).val(str);	
						
						}
					function validate_fields(){
							jQuery("input[is_field='yes']").each(function() {
							var field_name = 'field_'+jQuery(this).attr('field_position')+'_title';
    						var field_entered_value = jQuery("#"+field_name).val();
							if(field_entered_value==''){
								jQuery(this).addClass( "invalid" );	
							}
							});
						}
$(".tabs li").live("click",function(event){
	var the_content = $(this).data("the_content");
	$(".panes .container__").hide();
	$("div[data-the_content='" + the_content +"']").show("slow");
});
$(".tabs li a").live("click",function(event){
	$('.tabs a').removeClass("current");
	$(this).addClass("current");
});
jQuery("#add_new_matrix_img").live("click", function(event){	
			loading_show();
			//enable_review_form();
			add_new_matrix();
			loading_hide()
		});
jQuery(".remove_field").live("click", function(event){
	
	var counter_ =  parseInt(jQuery(this).data("counter")); //"CommonLi"
	
	var all_fields_count =parseInt(jQuery('#field_counter').val());
	var new_counter = (all_fields_count - counter_ )+2;
	var fields_above = counter_ -1;
	var fields_below = all_fields_count - counter_;
	var $parent = jQuery(this).parent();
		$parent.nextAll().remove();
		$parent.remove();
	var new_counter_final = fields_above +fields_below;
		
		jQuery("#field_counter").val(fields_above);
		add_more_fields(fields_below);
		//alert(fields_below);
	
	enable_more_fields();
	enable_submit();
	});


jQuery("#add_matrix_field").live("click", function(event){	
			loading_show();
			//enable_review_form();
			add_more_fields(1);
			enable_submit();
			validate_fields();
			
			loading_hide()
		});
jQuery("input[is_field='yes']").live('keyup',function(){
   //alert('test');
   var field_name = 'field_'+jQuery(this).attr('field_position')+'_title';
   var field_slug = 'field_'+jQuery(this).attr('field_position')+'_slug';
   
   create_slug(field_name, field_slug);
   jQuery(this).removeClass("invalid");
//   if jQuery(this).val() != ''){}
enable_submit();
}); 
/*
jQuery("input[is_field='yes']").live("click",function(){
   //alert('test');
   var field_name = 'field_'+jQuery(this).attr('field_position')+'_title';
    var field_entered_valuu = jQuery("#"+field_name).val();
	jQuery("p").addClass("myClass yourClass");
   
}); */	
jQuery(".container_multi #create_matrix").live("click", function(event){	

			//alert('You just  clicked the button');
		var given_martix_title = jQuery('input[id=matrix_id]').val();
		if(given_martix_title =='' ){alert('<?php _e('You can`t Proceed...The ** MATRIX TITLE ** is empty','rmatrix'); ?>')}else{
		//alert('TRIED');
		jQuery('#server_response').empty();
		$('#add_matrix_field').attr("disabled","disabled");
		$(this).attr("disabled","disabled");
		loading_show_self();	
		var data = {
		action: 'create_new_matrix',
		matrix_title: given_martix_title,
		matrix_out_of: jQuery('select[name="matrix_out_of"]').val(),
		matrix_field_1_title: jQuery('#field_1_title').val(),
		matrix_field_2_title: jQuery('#field_2_title').val(),
		matrix_field_3_title: jQuery('#field_3_title').val(),
		matrix_field_4_title: jQuery('#field_4_title').val(),
		matrix_field_5_title: jQuery('#field_5_title').val(),
		matrix_field_6_title: jQuery('#field_6_title').val(),
		matrix_field_7_title: jQuery('#field_7_title').val(),
		matrix_field_8_title: jQuery('#field_8_title').val(),
		matrix_field_9_title: jQuery('#field_9_title').val(),
		matrix_field_10_title: jQuery('#field_10_title').val(),
		matrix_field_1_slug: jQuery('#field_1_slug').val(),
		matrix_field_2_slug: jQuery('#field_2_slug').val(),
		matrix_field_3_slug: jQuery('#field_3_slug').val(),
		matrix_field_4_slug: jQuery('#field_4_slug').val(),
		matrix_field_5_slug: jQuery('#field_5_slug').val(),
		matrix_field_6_slug: jQuery('#field_6_slug').val(),
		matrix_field_7_slug: jQuery('#field_7_slug').val(),
		matrix_field_8_slug: jQuery('#field_8_slug').val(),
		matrix_field_9_slug: jQuery('#field_9_slug').val(),
		matrix_field_10_slug: jQuery('#field_10_slug').val(),
		counter: jQuery('#field_counter').val(),
			};
		
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				//alert('Got this from the server: ' + response);
				jQuery('#server_response').html('<?php _e('Final Message','rmatrix'); ?>: <b>'+response+'</b>').fadeIn();
				resetForm($('form[type=text]')); // by name
				
			});	
			}
		});
		
		$("#manage_matrix").live("change",function(){
		var chosen_action = $(this).val();
		var the_td = $(this).closest(".matrix_manage_").attr("id");
		var ConfirMer =$(this).next().attr("id");
		//$(this).closest("tr").remove();
		
		
		if(chosen_action=='reset'){ //alert("Reset");
			$("#"+ConfirMer).html("<?php _e('Confirm Reset','rmatrix'); ?>").show("slow");
			$("#"+ConfirMer).removeClass();
			$("#"+ConfirMer).addClass("reset");
				//var dataReset = { action: 'rmatrixResetMatrix', matrix_id:the_td};
				//jQuery.post(ajaxurl, dataReset, function(response) {
					//alert(response);
				//});	
		}
		if(chosen_action=='delete'){
			$("#"+ConfirMer).html("<?php _e('Confirm Matrix Delete','rmatrix'); ?>").show("slow");
			$("#"+ConfirMer).removeClass();
			$("#"+ConfirMer).addClass("delete");
	
		}
		});
		$('*[data-confirmer="confirm_action"]').live("click", function(event){
		var maMatrix = $(this).data('matrix-now');
		var acionTodo = $(this).attr('class');
		var myTr = $(this).closest("tr").remove();
		//alert(myTr);
		if(acionTodo=='reset'){
				var dataReset = { action: 'rmatrixResetMatrix', matrix_id:maMatrix};
				jQuery.post(ajaxurl, dataReset, function(response) {
					alert(response);
				});	
		}else if(acionTodo=='delete'){
				var dataDelete = { action: 'rmatrixDeleteMatrix', matrix_id:maMatrix};
					jQuery.post(ajaxurl, dataDelete, function(response) {
					alert(response);
					$(this).closest("tr").remove();
				});	
		}
		
			});
	});
</script>
<?php }
/*
Functon: rmatrix_delete_matrix
Descrition: Remove a selected matrix
*/
function rmatrix_delete_matrix(){
	$post_togo = $_POST['matrix_id'];
	$matrix_deleted = wp_delete_post($post_togo, true);
	if($matrix_deleted){ _e("Matrix Successfully deleted","rmatrix");}else{_e("Something went wrong","rmatrix");}
die();
}add_action('wp_ajax_rmatrixDeleteMatrix', 'rmatrix_delete_matrix');

function rmatrix_reset_matrix(){
	$post_togo = $_POST['matrix_id'];
	global $wpdb;
$matrix_fields = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."_rmatrix_fields"." WHERE matrix_id = '".$post_togo."'");

foreach ( $matrix_fields as $matrix_field ) 
{
	delete_matrix_ratings($matrix_field->field_id);
}
die();
}add_action('wp_ajax_rmatrixResetMatrix', 'rmatrix_reset_matrix');

function delete_matrix_ratings($field){
global $wpdb;
$deleted = $wpdb->query("DELETE FROM ".$wpdb->prefix."_rmatrix_ratings"." WHERE matrix_field_id > $field");
	
}
?>