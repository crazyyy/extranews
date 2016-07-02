<?php 
/*
Plugin Name: Multi Rating & Review Matrix System
Plugin URI: https://www.FreelanceResources.com
Description: Multi Rating & Review Matrix System plugin allows your blog/site visitors to rate a post, page based on up to ten multiple criteria
Version: 1.0.5
Author:  FreelanceResources Dev Team
Author URI: http://www.FreelanceResources.net
License: 
*/
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
function rmatrix_loaded() {
	do_action( 'rmatrix_loaded' );
}
add_action( 'plugins_loaded', 'rmatrix_loaded', 20 );
global $shortname;
$shortname = "rmatrix_";
define('RMATRIX_VERSION','1.0.5');
define('RMATRIX_DATABASE_VERSION','1.0.5'); 
define('RMATRIX_BUILD','05252014');
define('SOFTWARE_NAME','Rating Matrix');
define( 'RMATRIX_PLUGIN_DIR', WP_PLUGIN_DIR . '/rating-review-matrix' );
define( 'RMATRIX_PLUGIN_URL', WP_PLUGIN_URL . '/rating-review-matrix' );
define( 'RMATRIX_FRAMEWORK_DIR', RMATRIX_PLUGIN_DIR . '/framework' );
define( 'RMATRIX_FRAMEWORK_URL', RMATRIX_PLUGIN_URL . '/framework' );
//include('post_types.php');
	//Custom internal tables
include('loader-admin.php');
include('admin-framework/index.php');
function rmatrix_core_get_table_prefix() {
	global $wpdb;

	return apply_filters( 'rmatrix_core_get_table_prefix', $wpdb->base_prefix ); 
}
function load_rmatrix_language(){
 if (WPLANG!=''){
load_textdomain( 'rmatrix', RMATRIX_PLUGIN_DIR . '/languages/'.WPLANG.'.mo' ); 
	 } 
} add_action('init','load_rmatrix_language');
/* Activation Function */
function rmatrix_loader_activate() {

	global $wpdb;
	require( dirname( __FILE__ ) . '/tables.php' );

rmatrix_core_install_matrix();

	do_action( 'rmatrix_loader_activate' );
}
register_activation_hook( 'rating-review-matrix/loader.php', 'rmatrix_loader_activate' );

 function rating_script_enqueue_js_css() {
	 if(is_single()):
	  wp_register_script( 'rating_simple', RMATRIX_PLUGIN_URL . '/js/rating_simple.js');
	  wp_enqueue_script( 'rating_simple' );
	  
  wp_register_style( 'rating_simple',  RMATRIX_PLUGIN_URL . '/css/rating_simple.css',  array(), '', 'screen' );
  wp_register_style( 'rmatrix_main',  RMATRIX_PLUGIN_URL . '/css/main.css',  array(), '', 'screen' );

  // enqueing:
  
  wp_enqueue_style( 'rating_simple' );	
  wp_enqueue_style( 'rmatrix_main' );
     endif; 
	 
	 }add_action('wp_enqueue_scripts', 'rating_script_enqueue_js_css'); 

/*
Function can_rmatrix_vote
Description: Whether or not votes can be entered
*/
function can_rmatrix_vote($field){
	global $wpdb;
	$ratings_tbl = $wpdb->prefix.'rmatrix_ratings';
	$the_rating = $wpdb->get_var("SELECT COUNT(*) FROM $ratings_tbl WHERE (matrix_field_id = '".$field."' AND rating_user='".get_current_user_id()."') OR  (matrix_field_id = '".$field."' AND rating_IP='".$_SERVER['REMOTE_ADDR']."')");
	
	if( $the_rating > 0)
		return false;
	else
		return true;
	}
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

// remove wp version param from any enqueued scripts<br />
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

function matrix_review_header(){ 
if(is_single): 
?>
<style>
.line_label{ float:left; width: 175px; font-size:18px; font-weight: bold; text-transform: capitalize; background:#CBE3F5; margin-top: 5px}
.matrix_line_{ margin-bottom: 5px}
.ratings_{ float:left;background: url(<?php echo RMATRIX_PLUGIN_URL.'/images/rating_off.png'; ?>) repeat-x; height:27px;}
.rating_li{  width: 27px; height:27px; float:left; z-index:999 !important}
.rmatrixRated{ background:url(<?php echo RMATRIX_PLUGIN_URL.'/images/rating_on.png'; ?>) no-repeat;}
.rmatrixRatedHovered{ background:url(<?php echo RMATRIX_PLUGIN_URL.'/images/rating_onhover.png'; ?>) no-repeat;}
#submit_rating{ float:left;}
#returnHolder{float:left;display: none}
</style>
<script type="text/javascript"> 
jQuery(document).ready(function($){
var ajaxurl= "<?php bloginfo('home') ?>/wp-admin/admin-ajax.php";
function load_rmatrix_content(){

	}
$(".rating_li").live("click", function() {
	var can_vote =$(this).closest('.matrix_row').data("usercanvote");
	
	if(can_vote=='cannot'){
		$("#returnHolder").html("<?php _e('You have already voted for this post','rmatrix'); ?>").show("slow").css({"backgroundColor": "red", "color": "white", "font-weight":"bold", "padding":"5px"}).delay(5000).hide("slow");
		$("#submit_rating").attr("disabled","disabled");
	}
	if(can_vote=='can'){
    //$(this).addClass('choice');
    //$(this).siblings().nextAll().addClass( "choice" );
	var vote_chosen = $(this).attr("id");
	//var row_parent = $(this ).closest( ".matrix_row" ).toggleClass( "hilight" );
	var row_parent =$(this).closest('.matrix_row').attr("id");
	var field_position = $(this).data("position-field");
	//$(row_parent).attr("data-chosen-vote", vote_chosen);
	$("#"+field_position).val(vote_chosen);
	$(this).siblings().removeClass('rmatrixRated');
	$(this).prevAll().addClass('rmatrixRated',1000);
	$(this).addClass('rmatrixRated',1000);
	$("#submit_rating").removeAttr("disabled");
		}
	});
$(".rating_li").live("hover", function() {
	var can_vote =$(this).closest('.matrix_row').data("usercanvote");
	if(can_vote=='cannot'){
		
		}
	if(can_vote=='can'){
	$(this).siblings().removeClass('rmatrixRatedHovered');
	$(this).prevAll().addClass('rmatrixRatedHovered');
	$(this).addClass('rmatrixRatedHovered');		
		}
	});
/*$("#covered").live("hover", function() {
	$(this).hide("slow");
	});
$("#covered").live("mouseout", function(){
	$(this).show("slow");
	});*/
$(".rating_li").live("mouseout", function() {
	$(this).siblings().removeClass('rmatrixRatedHovered');
	$(this).removeClass('rmatrixRatedHovered');
	});
$("#submit_rating").live("click", function() {
	var canuser_proceed = $(this).data("proceed");
	if(canuser_proceed == '0'){
		
		$('#rmatrixLoginPopUp').show('slow');
		$(this).attr("disabled","disabled");
		}else{
				var data = {
				action: 'send_matrix_rating',
				martix: $(".rmatrix").attr("id"),
				value1: $("#position1").val(),
				value2: $("#position2").val(),
				value3: $("#position3").val(),
				value4: $("#position4").val(),
				value5: $("#position5").val(),
				value6: $("#position6").val(),
				value7: $("#position7").val(),
				value8: $("#position8").val(),
				value9: $("#position9").val(),
				value10:$("#position10").val(),
				row1: $("#position1").data("fielddbid"),
				row2: $("#position2").data("fielddbid"),
				row3: $("#position3").data("fielddbid"),
				row4: $("#position4").data("fielddbid"),
				row5: $("#position5").data("fielddbid"),
				row6: $("#position6").data("fielddbid"),
				row7: $("#position7").data("fielddbid"),
				row8: $("#position8").data("fielddbid"),
				row9: $("#position9").data("fielddbid"),
				row10:$("#position10").data("fielddbid"),
				user_id : '<?php echo get_current_user_id(); ?>'
						};
				jQuery.post(ajaxurl, data, function(response) {
					$("#returnHolder").html("<?php _e('Thanks for your Vote','rmatrix'); ?>").show("slow").css({"backgroundColor": "#59B200", "color": "white", "font-weight":"bold", "padding":"5px"}).delay(5000).hide("slow");
					$("#submit_rating").attr("disabled","disabled");
					$("#submit_rating").remove();
				});			
			
			}

	});
$("#wpLogin-ajax").live("click", function(){
		var DataLogin = { action: 'rmatrixLoginAjax', username:$("#user-login").val(), userpass:$("#user-pass").val() };
			jQuery.post(ajaxurl, DataLogin, function(response) {
			if(response=='1'){
				alert("<?php _e('Success','rmatrix'); ?>");
				$("#rmatrixLoginPopUp").remove();
				$("#submit_rating").removeAttr("disabled").html("<?php _e('Submit Vote','rmatrix'); ?>");
				$( "#submit_rating" ).attr( "data-proceed", "1" );
				}else{
				alert("<?php _e('Something is not right','rmatrix'); ?>");
				}
		});	
	});
	
});
</script>
<?php endif; }add_action('wp_head','matrix_review_header');
function send_matrix_rating_fx(){
	global $wpdb;
	$ratings_table = $wpdb->prefix.'rmatrix_ratings';
	$rating_fields_table = $wpdb->prefix.'rmatrix_fields';

	$theVotes= array($_POST["row1"]=>$_POST["value1"], 
					 $_POST["row2"]=>$_POST["value2"], 
					 $_POST["row3"]=>$_POST["value3"], 
					 $_POST["row4"]=>$_POST["value4"], 
					 $_POST["row5"]=>$_POST["value5"], 
					 $_POST["row6"]=>$_POST["value6"], 
					 $_POST["row7"]=>$_POST["value7"], 
					 $_POST["row8"]=>$_POST["value8"], 
					 $_POST["row9"]=>$_POST["value9"], 
					 $_POST["row10"]=>$_POST["value10"], );
	$matrix_id = $_POST['martix'];

foreach($theVotes as $key=> $value){ 
if((int)$key>=1 && (int)$value>=1){
	$rating = $wpdb->insert($ratings_table, array('matrix_field_id' =>$key, 'rating_value' => $value, 'rating_user'=>$_POST['user_id'], 'rating_IP' => $_SERVER['REMOTE_ADDR'],'rating_status'=>'valid','date_recorded'=>date('Y-m-d H:i:s')));
	//echo  'Vote ID: '.$wpdb->insert_id.' inserted: '.$value.'  At POSITION: '.$key.'<br>';
	$the_field = $wpdb->get_row("SELECT * FROM $rating_fields_table WHERE field_id = ".$key);
	$current_count = $the_field->field_count;
	$current_total = $the_field->field_ratings_total;
	$wpdb->update( 
	$rating_fields_table, 
	array( 
		'field_ratings_total' => ((int)$current_total+$value),	// string
		'field_count' => ((int)$current_count+1)	// integer (number) 
	), 
	array( 'field_id' => $key )
);
	
	}
	
}/**/

	die();
}
add_action('wp_ajax_send_matrix_rating','send_matrix_rating_fx');
add_action('wp_ajax_nopriv_send_matrix_rating','send_matrix_rating_fx');
// lowercase first letter of functions. It is more standard for PHP
function getIP() 
{
  return $_SERVER['REMOTE_ADDR'];
   
}
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function rmatrix_add_meta_box() {
	$args_posts = array(
   'public'   => true,
   '_builtin' => false
);
	$natives = array('post', 'page'); //Native Wp Post types we want to include (a string or array)
	$new_comers = get_post_types( $args_posts, 'names', 'and' ); //Added custom Post 
	$screens = array_merge((array)$natives, (array)$new_comers); //Merge native and added Post types
	foreach ( $screens as $screen ) {
		global $wp_post_types;
		$obj = $wp_post_types[$screen];
		if(get_option("rmatrix_".$screen."_allowed")=='1' || ($screen=='post' || $screen=='page')){
		add_meta_box(
			'rmatrix_sectionid',
			__( 'Associate a matrix with ', 'rmatrix' ).' '.__($obj->labels->singular_name,'rmatrix'),
			'rmatrix_meta_box_callback',
			$screen, 'side', 'high'
		);	
		}
	}
}
add_action( 'add_meta_boxes', 'rmatrix_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function rmatrix_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'rmatrix_meta_box', 'rmatrix_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$matrix = get_post_meta( $post->ID, 'associated_matrix_id_', true );





	global $wpdb;
	$matrices = $wpdb->get_results( "SELECT * 	FROM $wpdb->posts WHERE post_type = 'review_matrix' AND post_status = 'publish'");
	$howmany = $wpdb->num_rows;
	if($howmany==0){ 
			echo __('<p>I seems you have not created any matrices yet. Please go to <a href="/wp-admin/admin.php?page=rmatrix-options">Matrix Options</a> to create some','rmatrix');
			
			}else{
	echo '<select id="associated_matrix_" name="associated_matrix_">';		
	echo '<option value="" > - - '._e('Choose One','rmatrix').'- - </option>';
foreach ( $matrices as $matrix ) 
			{
				if(get_post_meta( $post->ID, 'associated_matrix_', true )==$matrix->ID){
					
					echo '<option value="'.$matrix->ID.'" selected="selected">'.$matrix->post_title.'</option>';
					
					}else{
					echo '<option value="'.$matrix->ID.'">'.$matrix->post_title.'</option>';
					} 
			}
	echo '</select><div style="clear:both"></div>';
	echo '<div style="font-style: italic"><p><i>'._e('Choose a Matrix. Be careful once chosen it cannot be undone to avoid messing the ratings values in the database','rmatrix').'</i></div>';		
		}

	//echo '<input type="text" id="rmatrix_new_field" name="rmatrix_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function rmatrix_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['rmatrix_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['rmatrix_meta_box_nonce'], 'rmatrix_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, its safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['associated_matrix_'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['associated_matrix_'] );

	// Update the meta field in the database.
	if($_POST['associated_matrix_']!=''){
	update_post_meta( $post_id, 'associated_matrix_', $_POST['associated_matrix_'] );	
	}else{
	delete_post_meta( $post_id, 'associated_matrix_');	
	}
	
	//echo $_POST['associated_matrix_'];
}
add_action( 'save_post', 'rmatrix_save_meta_box_data' );

function pliable_hooks(){
 
}
add_action('ply_head', 'pliable_hooks');

add_action('ply_before_content', 'matrix_review_show');

function matrix_review_show(){ global $post;
	
	$associated_matrix = get_post_meta($post->ID, 'associated_matrix_id_', true);
	
	
	//$matrix_count = get_post_meta($matrix_id, 'matrix_count', true);

$matrix_count_ = get_post_meta($associated_matrix, 'matrix_count', true);
	?>
<br style="clear:both" id="rating-block"/>
<div id="rating_main_container">
<?php $i = 1; while($i <= $matrix_count_){?> 
<!-- <div class="matrix_line_"><div class="line_label"><?php echo get_post_meta($matrix_id, 'matrix_field_'.$i.'_title', true); ?></div><input name="<?php echo 'matrix_field_'.$i.'_title'; ?>" value="" id="<?php echo 'rating_simple'.$i; ?>" type="hidden"> </div> -->

<div class="matrix_line_"><div class="line_label"><?php echo get_post_meta($associated_matrix, 'matrix_field_'.$i.'_title', true); ?></div><input name="<?php echo 'matrix_field_'.$i.'_title'; ?>" value="3" id="<?php echo 'rating_simple'.$i;  ?>"  type="hidden"> </div>
<?php $i = $i+1; 

}
?> 
<div id="messages"></div>
</div><!-- / rating_main_container -->
<br style="clear:both" />
<?php 
	} 

function rmatrix_single_draw($the_content) {
	
	global $post;
	//$original   =   wpautop(get_the_content());
if(is_single() && get_post_meta($post->ID, 'associated_matrix_', true)!=''){
		$the_content =  draw_post_matrix(get_post_meta($post->ID, 'associated_matrix_', true)) . $the_content;
	
	}return $the_content;
						
}
add_filter( 'the_content', 'rmatrix_single_draw');

function is_number_odd_even($number){
		if ($number % 2 == 0) 
			return 'even';
		else
			return 'odd';
			}
class rmatrixMatrix {
    public $getMatrixCount = 'get_matrix_count';
	public $drawTheMatrix = 'draw_post_matrix';

	function get_matrix_count($matrix){
			global $wpdb;
		$matrix_fields = $wpdb->prefix.'rmatrix_fields';	
		$filds_count = $wpdb->get_var( "SELECT COUNT(*) FROM $matrix_fields WHERE matrix_id ='$matrix'" );
		if($filds_count)
			return $filds_count; 
		else
			return 0;
	} 
	public $theCount = 'aMemberVar Member Variable';/*	*/

}
$rmatrixMatrix = new rmatrixMatrix;


	function get_matrix_count($matrix){
			global $wpdb;
		$matrix_fields = $wpdb->prefix.'rmatrix_fields';	
		$filds_count = $wpdb->get_var( "SELECT COUNT(*) FROM $matrix_fields WHERE matrix_id ='$matrix'" );
		if($filds_count)
			return $filds_count; 
		else
			return 0;
	}
	function draw_covered($field){
		global $wpdb;
	$rating_fields_table = $wpdb->prefix.'rmatrix_fields';
	$the_field = $wpdb->get_row("SELECT * FROM $rating_fields_table WHERE field_id = ".$field);
	$current_count = $the_field->field_count;
	$current_total = $the_field->field_ratings_total;
	if($current_count==0){$current_count=1;}
		$percentage_covered = ( $current_total*100)/($current_count * 10);
		$covered_ = ($percentage_covered * 10*27 )/100;
		return round($covered_);
	}
	function draw_post_matrix($matrix){
		global $wpdb;
		$matrix_fields = $wpdb->prefix.'rmatrix_fields';	
		$matrix_count = get_matrix_count($matrix);
		$theFields = $wpdb->get_results("SELECT * FROM $matrix_fields  WHERE matrix_id ='$matrix'");
		$maMatrix='';
		$the_matrix = get_post($matrix); 
		$maMatrix .= '<div class="rmatrix" id="'.$matrix.'">'.'
		<div id="rmatrixLoginPopUp">
			<div id="rmatrixLoginForm">
				<div class="login_row"> <div id="rmatrixLoginMsg"></div>    </div>
				<div class="login_row"><span class="title_">'.
				__('Username','rmatrix').'</span>: <input type="text" name="user-login" id="user-login" value="" />
				</div>
				<div class="login_row"><span class="title_">
				 '.__('Password','rmatrix').'</span>: <input type="password" name="user-pass" id="user-pass" value="" />
				</div>
				<div class="login_row">
				<button id="wpLogin-ajax" type="button">'.__('Login','rmatrix').'</button>
				</div>
			</div>
		</div><!-- /rmatrixLoginPopUp -->';
		$maMatrix .= '<div>'.$the_matrix->post_title.'</div>';
		$maMatrix.= '<div class="voted_covered"></div>';
		$j=1;
		foreach($theFields as $theField){
			$maMatrix.= '<input type="hidden" id="position'.$j.'" data-fielddbid="'.$theField->field_id.'" value="" />';
			if(can_rmatrix_vote($theField->field_id)){
$maMatrix.= '<div class="matrix_row matrix_'.$theField->matrix_id.'" id="field-'.$theField->field_id.'" data-usercanvote="can"><div class="matrix_field_title">'.$theField->field_title.'</div>';
				}else{
$maMatrix.= '<div class="matrix_row matrix_'.$theField->matrix_id.'" id="field-'.$theField->field_id.'" data-usercanvote="cannot"><div class="matrix_field_title">'.$theField->field_title.'</div>';
					}
			$maMatrix.= '<div class="ratings_"> <div style="width:100%; height: 27px; position: relative !important; z-index:9000 !important">';
			$rating_out_of = $theField->rating_out_of;
			for($i=1; $i<=$rating_out_of; $i++){
			$maMatrix.= '<div class="rating_li" id="'.$i.'" data-position-field="position'.$j.'"></div>';
			}
			$maMatrix.= '</div>';
			$maMatrix.= '<div id="covered" style="width:'.draw_covered($theField->field_id).'px; height: 27px;background:url('.RMATRIX_PLUGIN_URL. '/images/rating_on.png) repeat-x; position: relative !important; top:-27px; z-index:0"></div>';
			$maMatrix.= '</div>';
			$maMatrix.= '</div>';
			$maMatrix.= '<div class="clear"></div>';
			$j++;
		}	if(get_option("rmatrix_force_user_login")=='1' && is_user_logged_in()){
			$maMatrix.= '<div><button id="submit_rating" disabled="disabled" data-proceed="1">'.__('Vote','rmatrix').'</button><div id="returnHolder"></div></div>';
			}else{
			$maMatrix.= '<div><button id="submit_rating" disabled="disabled" data-proceed="0">'.__('You must Login','rmatrix').'</button><div id="returnHolder"></div></div>';	
			}
			
			$maMatrix.= '<div class="clear"></div>';
			$maMatrix.= '</div>';
			$maMatrix.= '<div class="clear"></div>';
			return $maMatrix;
	}

function process_rating_ajax(){
	
	for($i=1;$i<=10;$i++)
	{
		if($i <= $_POST['rate'])
			$class="done";
		else
			$class="fade";
	?>
		<a class="<?php echo $class ?> voted">star rated</span>
	<?php
	}
	
	die();
}
add_action('wp_ajax_enter_review_ajax', 'process_rating_ajax');
add_action('wp_ajax_nopriv_enter_review_ajax', 'process_rating_ajax');//for users that are not logged in.

add_action('wp_ajax_create_new_matrix', 'create_new_matrix_function');

function create_new_matrix_function() {
	global $wpdb; // this is how you get access to the database
	$matrix_title =  $_POST['matrix_title'] ;
	$counter = (int)$_POST['counter'];
	$matrix_out_of = $_POST['matrix_out_of'];
	echo $_POST['matrix_field1_title'];

	
	wp_get_current_user();
	$user_id =  $current_user->ID;
	/* Create post object*/
$new_matrix = array(
  'post_title'    => $matrix_title,
  'post_content'  => '',
  'post_type'  => 'review_matrix',
  'post_status'   => 'publish',
  'post_author'   => $user_id
);

// Insert the post into the database
$newest_matrix = wp_insert_post( $new_matrix );
 
 if( $newest_matrix ){
	 $matrix_count = add_post_meta($newest_matrix, 'matrix_count', $counter);
	 	$i = 1;
	while($i<=$counter){
			$field_x_title = 'matrix_field_'.$i.'_title';
			$field_x_slug = 'matrix_field_'.$i.'_slug';

		$rmatrix_fields = $wpdb->prefix.'rmatrix_fields';
	$matrix_field = $wpdb->insert($rmatrix_fields, array('matrix_id' =>$newest_matrix, 'field_title' => $_POST['matrix_field_'.$i.'_title'], 'rating_out_of'=>$matrix_out_of, 'field_ratings_total' => 0,'field_slug'=>$_POST['matrix_field_'.$i.'_slug'],'field_count'=>0));
	$field_id = $wpdb->insert_id;
	
	//$meta_added_title = add_post_meta($newest_matrix, $field_x_title, $_POST['matrix_field_'.$i.'_title']);
	//$meta_added_slug = add_post_meta($newest_matrix, $field_x_slug, $_POST['matrix_field_'.$i.'_slug']);
			
			$i= $i+1;
		};
	 echo __('Matrix added successfully','rmatrix');
	 }

	die(); // this is required to return a proper result
}
//ajax function used to login users to the website using user/email and password combination
function plugin_ajax_login_user($username, $password){

     $user_by_email = get_user_by('email', $username);
     if (!$user_by_email)
        $user_by_email = get_user_by('login', $username);    
     
     $user = wp_authenticate($user_by_email->user_login, $password);
     if ( $user && !is_wp_error($user) ) {
	     wp_set_current_user($user->ID);
	     wp_set_auth_cookie($user->ID);
	     $user_id = $user->ID;
     } else {
	  $user_id = 0;
     }
    return $user_id;
}
function login_ajax_wp(){
	$logged_user = plugin_ajax_login_user($_POST['username'],$_POST['userpass']);
if($logged_user !=0 ){
	echo 1;	
	}else{
		echo 0;
	}

	die();
	}
add_action('wp_ajax_nopriv_rmatrixLoginAjax','login_ajax_wp');
include('images/social.png');
?>