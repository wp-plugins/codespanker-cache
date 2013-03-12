<?php

class CS_Authorize_Cache_Connection {

	var $cache_secret = null;

	var $cache_secret_option_key = 'cs_cache_secret_option_key';

	function __construct() {
		if( 0 == $this->get_cache_secret() )
			$this->create_cache_secret();
	}

	function create_cache_secret() {
		$this->cache_secret = md5( time() . mt_rand() . site_url() );

		add_option( $this->cache_secret_option_key, $this->cache_secret );
	}

	function get_cache_secret() {
		return get_option( $this->cache_secret_option_key );
	}

}

?>