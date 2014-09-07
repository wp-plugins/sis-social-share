<?php
/*
Plugin Name: Social Share Buttons
Plugin URI: http://wordpress.org/plugins/sis-social-share/
Description: Add various social networking share buttons to your website, including Facebook, Twitter, digg, delicious, StumbleUpon, Pinterest and Linkedin.
Version: 1.0
Author: Sayful Islam
Author URI: http://sayful.net
Text Domain: nivoslider
Domain Path: /languages/
License: GPLv2 or later
*/

// Set up our WordPress Plugin
function sis_social_share_check_WP_ver()
{
	$options_array = array(
      	'show_button' => 'left', 
        'button_top' => '100px', 
        'googleplus' => 'true',
        'facebook' => 'true',
        'twitter' => 'true',
        'digg' => 'true',
        'delicious' => 'true',
        'stumbleupon' => 'true',
        'linkedin' => 'true',
        'pinterest' => 'true',
    );
	if ( get_option( 'sis_social_share_settings' ) !== false ) {
		// The option already exists, so we just update it.
      	update_option( 'sis_social_share_settings', $options_array );
   } else{
   		// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
   		add_option( 'sis_social_share_settings', $options_array );
   }
}
register_activation_hook( __FILE__, 'sis_social_share_check_WP_ver' );

/**
 * Load plugin textdomain.
 */
function sis_social_share_load_textdomain() {
  load_plugin_textdomain( 'socialsharebuttons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'sis_social_share_load_textdomain' );

//register settings
function sis_social_share_settings_init(){
    register_setting( 'sis_social_share_settings', 'sis_social_share_settings' );
}
add_action( 'admin_init', 'sis_social_share_settings_init' );


/* Adding Latest jQuery for Wordpress front page */
function sis_socialshare_plugin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('sis_share_main_script',plugins_url( '/jquery.sharrre.js' , __FILE__ ),array( 'jquery' ));
}
add_action('init', 'sis_socialshare_plugin_scripts');

function sis_social_share_custom_style(){
	$options = get_option( 'sis_social_share_settings' );
	?><style>
		#mysocilasharing{
			overflow: hidden;
			display: block;
			position: fixed;
			<?php echo $options['show_button']; ?>: 10px;
			top: <?php echo $options['button_top']; ?>;
			z-index: 9999;
		}
		.button {
		  display: block;
		  margin: 5px 0;
		  padding: 5px 10px;
		  background: none;
		}
		.button.pinterest {
		  	margin-top: 30px;
		}
	</style><?php
}
add_action('wp_head', 'sis_social_share_custom_style');

function sis_social_share_activation(){
	?>
		<?php $options = get_option( 'sis_social_share_settings' ); ?>
		<div id="mysocilasharing"><div id="shareme" data-url="<?php bloginfo('url'); ?>" data-text="<?php bloginfo('name'); ?>"></div></div>
		<script type="text/javascript">
	  		jQuery(document).ready(function(){
				jQuery('#shareme').sharrre({
					share: {
						<?php if ($options['googleplus'] != true): ?>
							googlePlus: false,
						<?php else: ?>
							googlePlus: true,
						<?php endif; ?>

						<?php if ($options['facebook'] != true): ?>
							facebook: false,
						<?php else: ?>
							facebook: true,
						<?php endif; ?>

						<?php if ($options['twitter'] != true): ?>
							twitter: false,
						<?php else: ?>
							twitter: true,
						<?php endif; ?>

						<?php if ($options['digg'] != true): ?>
							digg: false,
						<?php else: ?>
							digg: true,
						<?php endif; ?>

						<?php if ($options['delicious'] != true): ?>
							delicious: false,
						<?php else: ?>
							delicious: true,
						<?php endif; ?>

						<?php if ($options['stumbleupon'] != true): ?>
							stumbleupon: false,
						<?php else: ?>
							stumbleupon: true,
						<?php endif; ?>

						<?php if ($options['linkedin'] != true): ?>
							linkedin: false,
						<?php else: ?>
							linkedin: true,
						<?php endif; ?>

						<?php if ($options['pinterest'] != true): ?>
							pinterest: false,
						<?php else: ?>
							pinterest: true,
						<?php endif; ?>
					},
					buttons: {
						googlePlus: {size: 'tall', annotation:'bubble'},
						facebook: {layout: 'box_count'},
						twitter: {count: 'vertical'},
						digg: {type: 'DiggMedium'},
						delicious: {size: 'tall'},
						stumbleupon: {layout: '5'},
						linkedin: {counter: 'top'},
						pinterest: {layout: 'vertical'}
					},
					enableHover: false,
					enableCounter: false,
					enableTracking: true
				});
	  		});
		</script>
	<?php
}
add_action('wp_footer', 'sis_social_share_activation');


//add settings page to menu
function sis_social_share_add_settings_page() {
add_menu_page( __( 'Social Share Settings', 'socialsharebuttons' ), __( 'Social Share', 'socialsharebuttons' ), 'manage_options', 'settings', 'sis_social_share_settings_page');
}
add_action( 'admin_menu', 'sis_social_share_add_settings_page' );


//start settings page
function sis_social_share_settings_page() {

	?>
	<div class="wrap">
	    <h2><?php _e('Social Share Settings', 'socialsharebuttons' ) ?></h2>

		<form method="post" action="options.php">

			<?php settings_fields( 'sis_social_share_settings' ); ?>
			<?php $options = get_option( 'sis_social_share_settings' ); ?>

			<table class="form-table">
				<!-- Option 1: Check Social Share -->
				<tr valign="top">
					<th scope="row">
						<label><?php _e( 'Check Social Share you want to show', 'socialsharebuttons' ); ?></label>
					</th>
					<td>
						<input id="sis_social_share_settings[googleplus]" name="sis_social_share_settings[googleplus]" type="checkbox" value="true" <?php checked( 'true', $options['googleplus'] ); ?> /><?php _e('Google Plus', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[facebook]" name="sis_social_share_settings[facebook]" type="checkbox" value="true" <?php checked( 'true', $options['facebook'] ); ?> /><?php _e('Facebook', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[twitter]" name="sis_social_share_settings[twitter]" type="checkbox" value="true" <?php checked( 'true', $options['twitter'] ); ?> /><?php _e('Twitter', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[digg]" name="sis_social_share_settings[digg]" type="checkbox" value="true" <?php checked( 'true', $options['digg'] ); ?> /><?php _e('Digg', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[delicious]" name="sis_social_share_settings[delicious]" type="checkbox" value="true" <?php checked( 'true', $options['delicious'] ); ?> /><?php _e('Delicious', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[stumbleupon]" name="sis_social_share_settings[stumbleupon]" type="checkbox" value="true" <?php checked( 'true', $options['stumbleupon'] ); ?> /><?php _e('Stumbleupon', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[linkedin]" name="sis_social_share_settings[linkedin]" type="checkbox" value="true" <?php checked( 'true', $options['linkedin'] ); ?> /><?php _e('Linkedin', 'socialsharebuttons'); ?><br>

						<input id="sis_social_share_settings[pinterest]" name="sis_social_share_settings[pinterest]" type="checkbox" value="true" <?php checked( 'true', $options['pinterest'] ); ?> /><?php _e('Pinterest', 'socialsharebuttons'); ?><br>
						
						<p class="description"><?php _e( 'Check Social Share you want to show', 'socialsharebuttons' ); ?></p>
					</td>
				</tr>
				<!-- Option 2: Check Social Share Position -->
				<tr valign="top">
					<th scope="row">
						<label for="sis_social_share_settings[show_button]"><?php _e( 'Show Social Share', 'socialsharebuttons' ); ?></label>
					</th>
					<td>
						<input type="radio" name="sis_social_share_settings[show_button]" value="left" <?php checked( $options['show_button'], 'left' ); ?> />Left<br />

						<input type="radio" name="sis_social_share_settings[show_button]" value="right" <?php checked( $options['show_button'], 'right' ); ?> />Right<br />

						<p class="description"><?php _e( 'Choose where you want to show buttons left or right side of your site.', 'socialsharebuttons' ); ?></p>
					</td>
				</tr>
				<!-- Option 3: Social Share Position from top-->
				<tr valign="top">
                    <th scope="row">
                        <label for="sis_social_share_settings[button_top]"><?php _e('Input option Example', 'socialsharebuttons') ?></label>
                    </th>
                    <td>
                        <input type="text" placeholder="100px" name="sis_social_share_settings[button_top]" value="<?php esc_attr_e($options['button_top']); ?>" class="">

                        <p class="description"><?php _e('Write button position from top in pixels. Example: 100px', 'socialsharebuttons') ?></p>
                    </td>
                </tr>
			</table>
			<p class="submit"><input type="submit" value="<?php _e('Save Changes', 'socialsharebuttons') ?>" class="button button-primary" id="submit" name="submit"></p>
		</form>

	</div><!-- END wrap -->

<?php
}