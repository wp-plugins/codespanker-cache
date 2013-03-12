<?php

class CS_Remote_Cache {

	var $remote_cache_endpoint = 'http://cache.codespanker.com/';

	function cs_cache_set( $key, $data, $expire, $secret, $host_name ) {

		$response = wp_remote_post( $this->remote_cache_endpoint, array( 
							'body' => array( 
										'handler' => 'cache_set',
										'key' => $key,
										'data' => $data,
										'group' => $group,
										'expire' => $expire,
										'secret' => $secret,
										'host_name' => $host_name ) ) );
		if( is_wp_error( $response ) )
			return false;
		else
			return $response[ 'body' ];

		if( is_wp_error( $request ) )
			return false;
		elseif( ( int ) $request[ 'body' ] == 1 )
			return true;
		else
			return false;
	}

	function cs_cache_get( $key, $secret ) {
		$request = wp_remote_post( $this->remote_cache_endpoint, array(
							'body' => array(
										'handler' => 'cache_get',
										'key' => $key,
										'secret' => $secret ) ) );
		if( is_wp_error( $request ) )
			return false;
		elseif( ( int ) $request[ 'body' ] == 0 )
			return $request[ 'body' ];
		else
			return false;
	}
}

?>