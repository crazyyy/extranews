<?php 
function admin_form_fx(){?>
<div id="support_inlineform_inner">
<form id="contact_devs_" enctype="multipart/form-data" action="" method="post">            
<input type="hidden" name="dev_contacted" value="yes" />
<input type="hidden" name="software_name" value="<?php echo SOFTWARE_NAME; ?>" />
<div id="rmatrix_hange"><?php _e('Notice that sending this form will create an entry in our forum if need be. The email and name you enter will be used as the account holders for that forum entry if one is created','rmatrix'); ?></div>
            <?php
            global $current_user;
                  get_currentuserinfo();
            
             ?>
            <div class="rmatrix_row">
                <div class="label_name"><?php _e('Name','rmatrix') ?>:</div>
                <div class="label_content"><input type="text" name="user_name" value="<?php echo $current_user->display_name; ?>" /><input type="hidden" name="user_login" value="<?php echo $current_user->user_login; ?>" /></div>
            </div><br class="clear" />
            <div class="rmatrix_row">
                <div class="label_name"><?php _e('E-mail','rmatrix') ?>:</div>
                <div class="label_content"><input type="text" name="user_email" value="<?php echo get_option("admin_email"); ?>" /></div>
            </div><br class="clear" />
            <div class="rmatrix_row">
                <div class="label_name"><?php _e('Reason','rmatrix') ?>:</div>
                <div class="label_content">
                <select name="contact_reason">
                <option value="tech-support"><?php _e('Technical Support','rmatrix') ?></option>
                <option value="bug report"><?php _e('Bug report','rmatrix') ?></option>
                <option value="feature-request"><?php _e('Feature request','rmatrix') ?></option>
                <option value="other"><?php _e('Other','rmatrix') ?></option>
                </select></div>
            </div><br class="clear" />
            <div class="rmatrix_row">
                <div class="label_name"><?php _e('Content','rmatrix') ?>:</div>
                <div class="label_content">
                <?php /** $settings = array( 'media_buttons' => false,'tinymce' => array(
        'theme_advanced_buttons1' => 'bold,italic,underline',
        'theme_advanced_buttons2' => '',
        'theme_advanced_buttons3' => ''
    ));

wp_editor( '', 'rmatrix_admin_emails', $settings ); */?>
				<textarea name="rmatrix_admin_emails" id="rmatrix_admin_emails" cols="20"></textarea>
                </div>
            </div><br class="clear" />
            <div class="rmatrix_row">
              <input type="submit" name="send_request" id="send_request" value="Send Request" />
              <input type="button" id="cancel_send" value="Cancel" />
            </div> 
 </form>
<div class="clear"></div> 
</div>
<?php }

?>