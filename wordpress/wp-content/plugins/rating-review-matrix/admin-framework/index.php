<?php
/*
Description: This File is the main one for the RMATRIX admin framework
Usage: 
Credit: Joshua D'Amour, Janvier Manishimwe
Version: 0.0.1
*/
define( 'RMATRIX_ADMIN_DIR', RMATRIX_PLUGIN_DIR . '/admin-framework' );
define( 'RMATRIX_ADMIN_URL', RMATRIX_PLUGIN_URL . '/admin-framework' );
require("admin-form.php");
    add_action( 'admin_init', 'rmatrix_admin_init' );
    add_action( 'admin_menu', 'rmatrix_admin_menu' );

    function rmatrix_admin_init() {

    }

    function rmatrix_admin_menu() {
    $page_hook_suffix_main = add_menu_page(__("RMatrix Main","rmatrix"), __("RMatrix Main","rmatrix"),'manage_options', "review-matrix", "rmatrix_admin",RMATRIX_PLUGIN_URL.'/images/rmatrix-menu-icon.png');
  
        /* Add our plugin submenu and administration screen */
        $page_hook_suffix = add_submenu_page( 'review-matrix', // The parent page of this submenu
                                  __( 'Rating Matrices', 'rmatrix' ), // The submenu title
                                  __( 'Rating Matrices', 'rmatrix' ), // The screen title
									  'manage_options', // The capability required for access to this submenu
									  'rmatrix-options', // The slug to use in the URL of the screen
                                      'rmatrix_manage_menu', // The function to call to display the screen
								  RMATRIX_PLUGIN_URL.'/images/rmatrix-menu-icon.png'
                               );

        /*
          * Use the retrieved $page_hook_suffix to hook the function that links our script.
          * This hook invokes the function only on our plugin administration screen,
          * see: http://codex.wordpress.org/Administration_Menus#Page_Hook_Suffix
          */
		add_action('admin_print_scripts-'. $page_hook_suffix_main, 'rmatrix_admin_scripts');
		add_action('admin_print_styles-'. $page_hook_suffix_main, 'rmatrix_admin_scripts');
        add_action('admin_print_scripts-'. $page_hook_suffix, 'rmatrix_admin_scripts');
		add_action('admin_print_styles-'. $page_hook_suffix, 'rmatrix_admin_scripts'); 
    }
    function rmatrix_admin_scripts() {
        /* Link our already registered script to a page */
  wp_enqueue_script( 'rmatrix-adminScrit1',  RMATRIX_ADMIN_URL . '/js/rmatrix.js',  array(), '', 'screen' );
  wp_enqueue_script( 'rmatrix-adminScrit4',  RMATRIX_ADMIN_URL . '/js/smk-accordion.js',  array(), '', 'screen' );
  wp_enqueue_script( 'rmatrix-adminScrit6',  RMATRIX_ADMIN_URL . '/js/jquery.easing.js',  array(), '', 'screen' );
  wp_enqueue_script( 'rmatrix-adminScrit8',  RMATRIX_ADMIN_URL . '/js/easyResponsiveTabs.js',  array(), '', 'screen' );
   
  wp_enqueue_style( 'rmatrix-adminStyle1',  RMATRIX_ADMIN_URL . '/css/rmatrix.css',  array(), '', 'screen' );
  wp_enqueue_style( 'rmatrix-adminStyle2',  RMATRIX_ADMIN_URL . '/css/style.css',  array(), '', 'screen' );

  wp_enqueue_style( 'rmatrix-adminStyle4',  RMATRIX_ADMIN_URL . '/css/magnific-popup.css',  array(), '', 'screen' );
    }
//*************** Admin function ***************
function rmatrix_admin() {
	 rmatrix_admin_html_admin();
}
function rmatrix_manage_menu() {
        /* Display our administration screen */
		rmatrix_admin_html_main();
}

function rmatrix_admin_html_admin(){
	global $current_user;
      get_currentuserinfo();
	
	$username = $current_user->user_login; 
	$user_id = $current_user->ID;
	?>
<div id="rmatrix_container">

<input type="hidden" name="current_user_id" id="current_user_id" value="<?php echo $user_id;?>" />
	<div id="nav_tabs">
    <ul id="admin_tabs">
    <li data-the_content="1" class="selected"><?php _e('Main Settings','rmatrix'); ?></li>
    <li data-the_content="2" ><?php _e('Appearance','rmatrix'); ?></li>
    <li data-the_content="3" ><?php _e('Help & Support','rmatrix'); ?></li>
    </ul>
    </div><div class="clear"></div>
	<div id="container_body">
    	<div id="1" class="settings-container">
        <h2><?php _e('RMATRIX main settings','rmatrix'); ?></h2>
        <?php general_settings_fx(); ?>
        <div style="position:relative; float:right; width: 200px;">
            
        </div>
        </div>
    	<div id="2" class="settings-container" style="display:none">
        <?php rmatrix_appearances_fx(); ?>
        </div>
    	<div id="3" class="settings-container" style="display:none">
				<?php help_support_fx(); ?>
        	<div id="support_inlineform">
            <?php admin_form_fx(); ?>
            </div>
        </div>
      </div>
 </div>
<?php }
function general_settings_fx(){?>
<form enctype="multipart/form-data" name="rmatrix_general_settings" method="post" id="rmatrix_general_settings">
<div class="accordion smk_accordion acc_with_icon"> 							
	<!-- Section 1 -->
	<div class="accordion_in  acc_active">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('General Options','rmatrix'); ?></span> <div class="message_saving"></div> <div class="clear"></div></div>
		<div class="acc_content">
        <div class="nexus_row">
        	<div class="label_title"><?php _e('Force User login before Voting','rmatrix'); ?></div>
        	<div class="row_content">
                <div class="toggle_ <?php if(get_option("rmatrix_force_user_login")=='1') echo 'yes';  else echo 'no';?>" id="1a" data-toggle-name="rmatrix_force_user_login" >
                    <div class="the_round <?php if(get_option("rmatrix_force_user_login")=='1') echo 'right';  else echo 'left';?>"></div>
                    <div class="the_words <?php if(get_option("rmatrix_force_user_login")=='1') echo 'left';  else echo 'right';?>"><?php if(get_option("rmatrix_force_user_login")=='1') echo __('Yes','rmatrix');  else echo __('No','rmatrix');?></div>
               </div>
               <input type="hidden" name="rmatrix_force_user_login"	id="rmatrix_force_user_login" value="<?php if(get_option("rmatrix_force_user_login")=='1') echo '1';  else echo '0';?>" />	
            </div><div class="clear"></div>	 
        </div><!-- / nexus_row -->
 
        <div class="nexus_row">
        	<div class="label_title"><?php _e('Allow User Comments','rmatrix'); ?></div>
        	<div class="row_content">
                <div class="toggle_ <?php if(get_option("rmatrix_allow_user_comments")=='1') echo 'yes';  else echo 'no';?>" id="1b" data-toggle-name="rmatrix_allow_user_comments" >
                    <div class="the_round <?php if(get_option("rmatrix_allow_user_comments")=='1') echo 'right';  else echo 'left';?>"></div>
                    <div class="the_words <?php if(get_option("rmatrix_allow_user_comments")=='1') echo 'left';  else echo 'right';?>"><?php if(get_option("rmatrix_allow_user_comments")=='1') echo __('Yes','rmatrix');  else echo __('No','rmatrix');?></div>
               </div>
               <input type="hidden" name="rmatrix_allow_user_comments"	id="rmatrix_allow_user_comments" value="<?php if(get_option("rmatrix_allow_user_comments")=='1') echo '1';  else echo '0';?>" />	
            </div><div class="clear"></div>	 
        </div><!-- / nexus_row -->
        <div class="nexus_row">
        	<div class="label_title"><?php _e('Choose Content Supported','rmatrix'); ?></div>
        	<div class="row_content">
            <?php
				
				$args = array(
				   'public'   => true,
				   '_builtin' => false
				);
				
				$output = 'names'; // names or objects, note names is the default
				$operator = 'and'; // 'and' or 'or'
				
				$post_types = get_post_types( $args, $output, $operator ); 
				$k= 1010;
				echo '<p><input type="checkbox" name="rmatrix_post_allowed" value="1" checked disabled="disabled">Post ['.__('Supported','rmatrix').']<br></p>';
				echo '<p><input type="checkbox" name="rmatrix_page_allowed" value="1" checked disabled="disabled">Page['.__('Supported','rmatrix').']<br></p>';
				foreach ( $post_types  as $post_type ) {
					global $wp_post_types;
					$obj = $wp_post_types[$post_type];
					//echo $obj->labels->singular_name; ?>
                    <div><?php echo '<div style="float: left; margin-right:10px; padding-top: 7px; width:100px;">'.$obj->labels->singular_name.'</div>'; ?>
                    <div style="float:left">
                    <div class="toggle_ <?php if(get_option('rmatrix_'.$post_type.'_allowed')=='1') echo 'yes';  else echo 'no';?>" id="1<?php  echo $k;?>" data-toggle-name="<?php echo 'rmatrix_'.$post_type.'_allowed'; ?>" >
                                        <div class="the_round <?php if(get_option('rmatrix_'.$post_type.'_allowed')=='1') echo 'right';  else echo 'left';?>"></div>
                                        <div class="the_words <?php if(get_option('rmatrix_'.$post_type.'_allowed')=='1') echo 'left';  else echo 'right';?>"><?php if(get_option('rmatrix_'.$post_type.'_allowed')=='1') echo __('Yes','rmatrix');  else echo __('No','rmatrix');?></div>
                                   </div>
                                   <input type="hidden" name="<?php echo 'rmatrix_'.$post_type.'_allowed' ?>"	id="<?php echo 'rmatrix_'.$post_type.'_allowed' ?>" value="<?php if(get_option('rmatrix_'.$post_type.'_allowed')=='1') echo '1';  else echo '0';?>" />
                   </div>
                   </div>
		<?php $k++;} ?>
        			
            </div><div class="clear"></div>	 
        </div><!-- / nexus_row -->
        
        <div class="nexus_row">
        	<div class="label_title"><?php _e('Languages and translations','rmatrix'); ?></div>
        	<div class="row_content">
                <?php 
			    if ($handle = opendir(RMATRIX_PLUGIN_DIR.'/languages')) {
						while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
								if($entry=='rmatrix.po'){$entry = 'en_EN';}
								echo "$entry\n";
								
							}
						}
						closedir($handle);
				   }
				?>
            </div><div class="clear"></div>	 
        </div><!-- / nexus_row -->          
		</div>
	</div>							
	<!-- Section 2 -->
	<div class="accordion_in">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('Security','rmatrix'); ?></span> <label class="digits active"><?php echo 0; ?></label> <div class="clear"></div></div>
		<div class="acc_content" style="display: none;">
		<div class="nexus_row">
        	<div class="label_title"><?php _e('Allow Ajax Login','rmatrix'); ?></div>
        	<div class="row_content">
                <div class="toggle_ <?php if(get_option("rmatrix_allow_ajax_login")=='1') echo 'yes';  else echo 'no';?>" id="2a" data-toggle-name="rmatrix_allow_ajax_login" >
                    <div class="the_round <?php if(get_option("rmatrix_allow_ajax_login")=='1') echo 'right';  else echo 'left';?>"></div>
                    <div class="the_words <?php if(get_option("rmatrix_allow_ajax_login")=='1') echo 'left';  else echo 'right';?>"><?php if(get_option("rmatrix_allow_ajax_login")=='1') echo __('Yes','rmatrix');  else echo __('No','rmatrix');?></div>
               </div>
               <input type="hidden" name="rmatrix_allow_ajax_login"	id="rmatrix_allow_ajax_login" value="<?php if(get_option("rmatrix_allow_ajax_login")=='1') echo '1';  else echo '0';?>" />	
            </div><div class="clear"></div>	 
        </div><!-- / nexus_row -->

		</div>
	</div>	
    <!-- /Section 2 -->	
	<!-- Section 3 -->
	<div class="accordion_in">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('Miscelleneous','rmatrix'); ?> </span> <label class="digits active"><?php _e('0','rmatrix'); ?></label> <div class="clear"></div></div>
		<div class="acc_content" style="display: none;">

		</div>
	</div>	
    <!-- /Section 3 -->						
</div>
<div id="save_settings"><button type="submit" name="save_settings_1" class="save_settings_1"><?php _e('Save Settings','rmatrix'); ?></button></div>
</form>
<?php }
function rmatrix_appearances_fx(){?>
<form enctype="multipart/form-data" name="rmatrix_appearance_settings" method="post" id="rmatrix_appearance_settings">
<div class="accordion smk_accordion acc_with_icon"> 							
	<!-- Section 1 -->
	<div class="accordion_in  acc_active">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('General Appearance','rmatrix'); ?></span> <div class="message_saving"></div> <div class="clear"></div></div>
		<div class="acc_content">
        
		</div>
	</div>							
	<!-- Section 2 -->
	<div class="accordion_in">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('Templates','rmatrix'); ?></span> <label class="digits active"><?php echo 0; ?></label> <div class="clear"></div></div>
		<div class="acc_content" style="display: none;">


		</div>
	</div>	
    <!-- /Section 2 -->	
					
</div>
<div id="save_settings"><button type="submit" name="save_settings_1" class="save_settings_1"><?php _e('Save Settings','rmatrix'); ?></button></div>
</form>
<?php }
function help_support_fx(){ ?>
<div class="accordion smk_accordion acc_with_icon"> 							
	<!-- Section 1 -->
	<div class="accordion_in  acc_active">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('Forums and Contacts','rmatrix'); ?></span> <div class="message_saving"></div> <div class="clear"></div></div>
		<div class="acc_content">
        <!-- / nexus_row -->
 
        <div class="nexus_row">
<p>
<h2><?php _e('Forums','rmatrix'); ?></h2>
<?php _e('If you encounter an issue, please refer to our Forums to report it. We do not monitor the wordpress Forums periodically. <p>Here is the link to the forums : <a href="http://www.freelanceresources.net/forums/forum/plugins-and-softwares/review-matrix/" target="_blank">http://www.freelanceresources.net/forums/forum/plugins-and-softwares/review-matrix/</a>','rmatrix') ?>
<p style="font-size:25px;"> - - <?php _e('OR','rmatrix') ?> - - </p>
<h3><?php _e('Contact us directly from here','rmatrix'); ?></h3>
<button id="contact_us_here"><?php _e('Contact Us','rmatrix'); ?></button>
        </div><!-- / nexus_row -->
                  
		</div>
	</div>							

	<!-- Section 2 -->
	<div class="accordion_in">
		<div class="acc_head"><div class="acc_icon_expand"></div><span><?php _e('Credits','rmatrix'); ?> </span> <label class="digits active"><?php _e('0','rmatrix'); ?></label> <div class="clear"></div></div>
		<div class="acc_content" style="display: none;">
		<div class="nexus_row">
<p>
<h2><?php _e('Credits and acknowledgements','rmatrix'); ?></h2>
<ol>
<li><a href="http://www.freelanceresources.net">Joshua D'Amour: </a><i><?php _e('PHP cleanup and design','rmatrix'); ?></i></li>
<li><a href="http://www.janvierdesigns.com">Janvier M: </a><i><?php _e('jQuery help with the framework','rmatrix'); ?></i></li>
<li><a href="http://w3layouts.com/ui-kits/">w3layouts: </a><i><?php _e('UI Kit for the part of our backend','rmatrix'); ?></i></li>
</ol>
        
        </div>
		</div>
	</div>	
    <!-- /Section 2 -->						
</div>
<?php }
function call_rmatrix_post_styles_function(){
	
	  $csssrc = RMATRIX_ADMIN_URL.'/css/post.css';
	  
  wp_enqueue_style("rmatrix-post", $csssrc);
  }
add_action('admin_print_styles-post.php', 'call_rmatrix_post_styles_function');
add_action('admin_print_styles-post-new.php', 'call_rmatrix_post_styles_function');
function save_rmatrix_settings_ajax(){
$myData = $_POST['postdata']; //The Data we get  from  jQuery (querystring)
$responsible = $_POST['curret_user']; // We get the user who is submitting the form NOT from the array
$arr = array(); 
parse_str( $myData, $arr); //We parse it into an associative array

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$username = $current_user->user_login;
if(is_user_logged_in()){  // USER  IS LOGGED IN 
	if($user_id != $responsible){ // USER is logged in but the ID on the user computer is not the same
		$message = __('You are logged in, but you may have to refresh your browser','rmatrix');
		
		}else{ // User is the same from remote and server 
			foreach ($arr as $key => $value){
				if($key=='current_user_id' || $key=='user_settings_submitted'){
					 /* We don't do anything for the form fields current_user_id and user_settings_submitted 
					 as they are just for system checks only */
					}else{
					//if($key=='current_user_id')
				update_option($key,$value);
				//wp_update_user( array ( 'ID' => $responsible, $key => $value ) ) ;
					}
			}
			$message = __('Options Updated Successfully','rmatrix');
		}
}else{ // USER IS NOT LOGGED IN
	$message = __('You must be logged in to update your information.','rmatrix');
}
	echo $message;
die();
}
add_action('wp_ajax_saveRmatrixSettings','save_rmatrix_settings_ajax');
add_action('wp_ajax_nopriv_saveRmatrixSettings','save_rmatrix_settings_ajax');

function send_devs_message(){
$myData = $_POST['postdata2']; //The Data we get  from  jQuery (querystring)
$responsible = $_POST['curret_user']; // We get the user who is submitting the form NOT from the array
$arr = array(); 
parse_str( $myData, $arr); //We parse it into an associative array

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$username = $current_user->user_login;

   $headers[] = 'From: '.$arr['user_name'].' <'.$arr['user_email'].'>' . "\r\n";
   $headers[] = "Content-type: text/html";
   
$emailSent = wp_mail ( 'devs@freelanceresources.net', 'Contact from Webmaster @ '.get_option('name'), '<p><b>Reason: '.$arr['contact_reason'].'</b></p><p>'.$arr['rmatrix_admin_emails'].'</p>', $headers);
function set_html_content_type()
{
  return 'text/html';
}
remove_filter ( 'wp_mail_content_type', 'set_html_content_type');
if($emailSent){
	
	echo 'Email Was sent successfully';
}
die();
}
add_action('wp_ajax_contactDevsRmatrix', 'send_devs_message');
?>