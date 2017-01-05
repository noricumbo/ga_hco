<?php
/**
 * @package GA_hco
 * @version 1.0
 */
/*
Plugin Name: Google Analytics HCO
Plugin URI: https://github.com/noricumbo/GA_hco
Description: Simply prints Google Analytics Tag to your footer. <strong>Hecho por Los Maquiladores.</strong>
Author: Jorge Noricumbo (Hacemos Código)
Version: 1.0
Author URI: https://hacemoscodigo.com
*/
$title_ga_hco = __('Google Analytics HCO Settings');

function register_ga_hco_settings() {
	register_setting( 'ga-hco-settings-group', 'ga_hco', 'esc_html' );
} 

add_action( 'admin_init', 'register_ga_hco_settings' );

function ga_hco_menu() {
	global $title_ga_hco;
	add_options_page( $title_ga_hco, 'Google Analytics HCO', 'manage_options', 'ga_hco.php', 'ga_hco_settings');
}

add_action('admin_menu', 'ga_hco_menu');

function ga_hco_settings() {
	global $title_ga_hco;
 	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>

	<div class="wrap">

		<?php screen_icon(); ?>
		
		<h2><?php echo esc_html( $title_ga_hco ); ?></h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'ga-hco-settings-group' ); ?>

			<table class="form-table">
			
				<tr valign="top">
					<th scope="row"><label for="weekdays"><?php _e('Google Analytics Profile ID') ?></label></th>
					<td>
						<input name="ga_hco" type="text" id="ga_hco" value="<?php form_option('ga_hco'); ?>" class="regular-text ltr" />
					</td>
				</tr>
			
			</table>
			<?php do_settings_sections('ga-hco-refresh'); ?>
			<?php submit_button(); ?>
		</form>
	
	</div>

<?php
 }

function ga_hco() {

	$ga_hco_option = get_option('ga_hco');

	$ga_hco = "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', '";

	$ga_hco .= "$ga_hco_option";

	$ga_hco .= "', 'auto');ga('send', 'pageview');</script>";
 
	echo $ga_hco;

}

add_action('wp_footer', 'ga_hco');