<?php
/*
Plugin Name: Kayako2Wordpress
Plugin URI: https://github.com/sierag/kayako2wordpress
Description: List flagged Kayako tickets in Wordpress for processing tickets content your Wordpress website. Communicates with the Kayako API.
Version: 1.0
Author: sierag
Author URI: www.sierag.nl
Author Email: reinier@sierag.nl
License:

  Copyright 2013 TODO (reinier@sierag.nl)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

require_once("KayakoAPILibrary_PHP-v1.1.1/kyIncludes.php");

/**
 * Initialization.
 */


// TODO: rename this class to a proper name for your plugin
class Kayako2Wordpress {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		if ( is_admin() ){
			/* Settings page html code */
			add_action( 'admin_menu', array( $this, 'kayako2wordpress_admin_menu' ) );
						
			if( ( substr( $_SERVER["PHP_SELF"], -11 ) == 'plugins.php' || $_REQUEST['page'] == "kayako2wordpress" ) && !(get_option( 'kayako_settings' ) ) ) { 
				add_action( 'admin_notices',  array( $this, 'at_force_fill_credentials' ) );		
			}
		}
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
		if ( version_compare( get_bloginfo( 'version' ) , '2.9' , '<' ) ) {
			deactivate_plugins( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );
			wp_die( sprintf( __( "Require wordpress greater than 2.9") ) );	
		}
		// check if object is returned. Than we can say that
		if(get_option('kayako_settings_installed') !== FALSE) {
			return update_option('kayako_settings_installed', false);
		}
		return add_option('kayako_settings_installed', false);
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO:	Define deactivation functionality here		
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall( $network_wide ) {
		delete_option("kayako_settings");
		delete_option('kayako_settings_installed');
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
		// TODO: replace "plugin-name-locale" with a unique value for your plugin
		$domain = 'plugin-name-locale';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		// TODO:	Change 'plugin-name' to the name of your plugin
		wp_enqueue_style( 'plugin-name-admin-styles', plugins_url( 'kayako2wordpress/css/admin.css' ) );
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
		// TODO:	Change 'plugin-name' to the name of your plugin
		wp_enqueue_script( 'kayako2wordpress', plugins_url( 'kayako2wordpress/js/admin.js' ) );
	
	} // end register_admin_scripts
	
	public function kayako2wordpress_admin_menu() {
		add_options_page( 'Kayako2Wordpress', 'Kayako2Wordpress', 'administrator','kayako2wordpress-settings', 'kayako2wordpress_admin_page');
		add_management_page( 'Kayako2Wordpress', 'Kayako2Wordpress', 'administrator','kayako2wordpress-settings', 'kayako2wordpress_display_page');
	}

	public function at_force_fill_credentials(){
			$message = ( $_REQUEST['page'] == "kayako2wordpress" ? 'any of the service fields with corresponding keys / IDs ' : 'the <b><a href="'.admin_url( 'options-general.php?page=kayako2wordpress-settings' ).'">settings</a></b> page with the credentials' );
		echo '<div class="error"><p>Fill '.$message.' to enable Kayako2Wordpress.</p></div>';	
	}
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		// TODO:	Change 'plugin-name' to the name of your plugin
		wp_enqueue_style( 'plugin-name-plugin-styles', plugins_url( 'plugin-name/css/display.css' ) );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		// TODO:	Change 'plugin-name' to the name of your plugin
		wp_enqueue_script( 'plugin-name-plugin-script', plugins_url( 'plugin-name/js/display.js' ) );
	
	} // end register_plugin_scripts
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function initSettings() {
		$data = $this->getSettings();
		$config = new kyConfig($data['kayako_url'], $data['kayako_key'], $data['kayako_secret']);
		$config->setDebugEnabled(false);
		kyConfig::set($config);
		return $data['kayako_tag'];
	}	
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function checkSettings() {
		$data = $this->getSettings();
		$config = new kyConfig($data['kayako_url'], $data['kayako_key'], $data['kayako_secret']);
		$config->setDebugEnabled(false);
		kyConfig::set($config);

		$obj = kyTicketStatus::getAll()->first();
		update_option('kayako_settings_installed', is_object($obj));
		return is_object($obj);
	} // end register_plugin_scripts
	
	
	/**
	 * Sets/Updates the Kayko settings
	 * @param type $data
	 * @return boolean
	 */
	public function saveSettings($data) {
		if(!is_array($data)) {
			return false;
		}

		if(array_key_exists('kayako_url', $data))
			$this->settings['kayako_url'] = $data['kayako_url'];

		if(array_key_exists('kayako_key', $data))
			$this->settings['kayako_key'] = $data['kayako_key'];

		if(array_key_exists('kayako_secret', $data))
			$this->settings['kayako_secret'] = $data['kayako_secret'];

		if(array_key_exists('kayako_tag', $data))
			$this->settings['kayako_tag'] = $data['kayako_tag'];

		if(array_key_exists('kayako_new_tag', $data))
			$this->settings['kayako_new_tag'] = $data['kayako_new_tag'];

		if(array_key_exists('kayako_frontend_url', $data))
			$this->settings['kayako_frontend_url'] = $data['kayako_frontend_url'];			

		if(get_option('kayako_settings') !== FALSE) {
			return update_option('kayako_settings', $this->settings);
		}
		return add_option('kayako_settings', $this->settings);
	}

	/**
	 * Fetch the current Kayako settings
	 * @return mixed An asociative array of settings
	 */
	public function getSettings() {
		return $this->settings = get_option('kayako_settings');
	}
	/**
	 * Fetch the current Kayako settings
	 * @return mixed An asociative array of settings
	 */
	public function getTagFromSettings() {
		$settings = get_option('kayako_settings');
		return $settings['kayako_tag'];
	}
	/**
	 * Fetch the current Kayako settings
	 * @return mixed An asociative array of settings
	 */
	public function getNewTagFromSettings() {
		$settings = get_option('kayako_settings');
		return $settings['kayako_new_tag'];
	}
	
	public function getFrontendURLFromSettings() {
		$settings = get_option('kayako_settings');
		return $settings['kayako_frontend_url'];
	}
	
	public function getTickets() {
		$this->initSettings();
		return kyTicket::search($this->getTagFromSettings(), array(kyTicket::SEARCH_TAGS));
	}
	public function getTicket($ticket_id) {
		$this->initSettings();
		return kyTicket::search($ticket_id, array(kyTicket::SEARCH_TICKET_ID));
	}
	public function removeTicket($ticket_id, $displayname) {
		$ticket = $this->getTicket($ticket_id);
		$user = $ticket->first()->getOwnerStaff();
		$ticket->first()->newNote($user, $displayname . " decided not to create a knowledgebase article from this ticket.")->create();
	}
  
} // end class

// TODO:	Update the instantiation call of your plugin to the name given at the class definition
$kayako2wordpress = new Kayako2Wordpress();

function kayako2wordpress_admin_page() {
	
	if ( version_compare( get_bloginfo( 'version' ) , '3.3' , '<' ) )
		wp_head();
	
	require( "views/admin.php" );
}

function kayako2wordpress_display_page() {
	
	if ( version_compare( get_bloginfo( 'version' ) , '3.3' , '<' ) )
		wp_head();
	
	require( "views/display.php" );
}