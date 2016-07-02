<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function rmatrix_core_set_charset() {
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	/* Wpdating component DB schema */
	if ( !empty($wpdb->charset) )
		return "DEFAULT CHARACTER SET $wpdb->charset";

	return '';
}
function rmatrix_core_install_matrix() {
	global $wpdb,$installed_ver;
$installed_ver = get_option( "rmatrix_version" );

if( $installed_ver != RMATRIX_DATABASE_VERSION ) {
	$charset_collate = rmatrix_core_set_charset();
	$rmatrix_prefix = rmatrix_core_get_table_prefix();
	$sql[] = "CREATE TABLE {$rmatrix_prefix}rmatrix_fields (
	  		    field_id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    matrix_id bigint(20) NOT NULL,
	  		    field_title varchar(70) NOT NULL,
				field_slug varchar(70) NOT NULL,
				rating_out_of bigint(20) NOT NULL,
				field_ratings_total bigint(20) NOT NULL,
				field_count bigint(20) NOT NULL,
			    KEY field_id (field_id)
		       ) {$charset_collate};";
	$sql[] = "CREATE TABLE {$rmatrix_prefix}rmatrix_ratings(
	  		    rating_id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    matrix_field_id bigint(20) NOT NULL,
	  		    rating_value bigint(20) NOT NULL,
				rating_user bigint(20) NOT NULL,
				rating_IP varchar(70) NOT NULL,	
				date_recorded datetime NOT NULL,	
				date_recorded_gmt datetime NOT NULL,	
				rating_status varchar(70) NOT NULL,	
			    KEY rating_id (rating_id)
		       ) {$charset_collate};";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta($sql);	

	update_option( 'rmatrix_version', RMATRIX_DATABASE_VERSION );
	update_option( 'rmatrix_build', RMATRIX_BUILD );
	}

}