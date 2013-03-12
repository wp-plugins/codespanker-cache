<?php
/*
 * Plugin Name: Codespanker Cache
 * Plugin URI: http://codespanker.com
 * Description: External full page caching for WordPress. Activate and done. The cache starts working immediately speeding up your site.
 * Author: Spencer Cameron
 * Author URI: http://codespanker.com/
 * Version: 1.0
 * License: GPL2
 */

require_once 'remote-cache.php';
require_once 'authorize-cache-connection.php';


class CS_Cache {

	var $page_key = null;

	var $cached_page_copy = null;

	var $initial_timestamp = null;

	var $plugin_page_name = 'cs-cache-settings';

	var $default_cache_expiration = 300;

	function __construct() {
		
		/*
		 * Set an initial timestamp once the plugin loads.
		 * This will give us a rough estimate of when page loading began.
		 * We'll reference this later once content is generated and ready
		 * to be sent to the browser.
		 */
		$this->initial_timestamp = microtime( true );

		/*
		 * Let's get things started, shall we?
		 */
		$this->init();
	}

	/*
	 * Setup and initialize the plugin components.
	 */
	function init() {
		
		/*
		 * Add our admin menu.
		 */
		add_action( 'admin_menu' , array( $this, 'create_settings_menu' ) );	

		$this->create_page_key();

		/*
		 * There are several scenarios in which caching may not
		 * be desired. If any of the no-cache criteria are met,
		 * just return and let WordPress do it's thing.
		 */
		if( $this->do_not_cache() )
			return;

		if( $this->is_cached() )
			$this->serve_from_cache();

		ob_start( array( $this, 'handle_output_buffer' ) );
	}

	function get_cache_expiration() {
		$cache_expiration = get_option( $this->plugin_page_name . '-cache-expiration' );

		if( absint( $cache_expiration ) > 0 )
			return $cache_expiration;
		else
			return $this->default_cache_expiration;
	}

	function create_settings_menu() {
		add_options_page( 'Cache Settings', 'Cache', 'manage_options', $this->plugin_page_name, array( $this, 'create_settings_page' ) );
	}

	function create_settings_page() {
		if(  ! empty( $_POST ) )
			$this->process_form_input();

		$this->generate_settings_form();
	}

	function process_form_input() {
		
		// Make sure there's no monkey-business going on.
		check_admin_referer( $this->plugin_page_name );

		$cache_expiration = isset( $_POST[ 'cache_expiration' ] ) ? absint( $_POST[ 'cache_expiration' ] ) : $this->default_cache_expiration;
	
		return update_option( $this->plugin_page_name . '-cache-expiration', $cache_expiration );
	}

	function generate_settings_form() { ?>
		<div>
			<h2 style="margin-top: 50px;">Cache Expiration</h2>
			<p>The amount of time a page should be cached before expiring.</p>
			<form method="post" action="<?php menu_page_url( 'cs-cache-settings' ); ?>" >
				<input type="text" style="width: 50px;" name="cache_expiration" value="<?php echo esc_attr( $this->get_cache_expiration() ); ?>" />
				<input type="submit" value="Update Settings" />
				<?php wp_nonce_field( $this->plugin_page_name ); ?>
			</form>
		</div><?php
	}

	/*
	 * We need to create a key specific to the page
	 * the user is currently on. That way, we know
	 * how to look up the cached copy when a subsequent
	 * attempt is made to load the page.
	 */
	function create_page_key() {
		$keys = array();

		$keys[ 'host' ] = $_SERVER[ 'HTTP_HOST' ];

		$keys[ 'request_uri' ] = $_SERVER[ 'REQUEST_URI' ];

		$this->page_key = md5( serialize( $keys ) );
	}

	function do_not_cache() {
		if( $this->user_logged_in() )
			return true;
		else
			return false;
	}

	function is_cached() {
		$cs_remote_cache = new CS_Remote_Cache;
		$cache_connection = new CS_Authorize_Cache_Connection;

		$this->cached_page_copy = $cs_remote_cache->cs_cache_get( $this->page_key, $cache_connection->get_cache_secret() );

		if( ! empty( $this->cached_page_copy ) )
			return true;
		else
			return false;
	}

	function user_logged_in() {
		return preg_match( '/wordpress_logged_in/', implode( ' ', array_keys( $_COOKIE ) ) );
	}

	function serve_from_cache() {
		$duration = microtime( true ) - $this->initial_timestamp;
		if( ! empty( $this->cached_page_copy ) )
			die( str_replace( '</head>', "<!-- Served by Codespanker Cache in $duration seconds. -->\n</head>", $this->cached_page_copy ) );
	}

	function handle_output_buffer( $output_buffer ) {
			
		$this->cache_page_content( $output_buffer );
		
		$duration = microtime( true ) - $this->initial_timestamp;
        
        return str_replace( '</head>', "<!-- Page generated without caching in $duration seconds. -->\n</head>", $output_buffer );
	}

	function cache_page_content( $page_content ) {
		if( empty( $this->cached_page_copy ) ) {

			$cs_remote_cache = new CS_Remote_Cache;
			
			$cache_connection = new CS_Authorize_Cache_Connection;
			
			$host_name = site_url();

			$check = $cs_remote_cache->cs_cache_set( $this->page_key, $page_content, $this->default_cache_expiration, $cache_connection->get_cache_secret(), $host_name );
			
			return $check;
		}
	}

}

new CS_Cache;

?>