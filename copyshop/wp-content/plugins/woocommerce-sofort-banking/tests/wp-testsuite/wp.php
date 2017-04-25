<?php

/**
 * PHP Unittests for WordPress
 *
 * @package WordPress-Unittests
 *
 * Copyright 2015 (very@awesome.ug)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
class WP_Tests extends PHPUnit_Extensions_Selenium2TestCase
{
	/**
	 * WordPress Username for Login
	 *
	 * @var $username
	 * @since 1.0.0
	 */
	var $username;

	/**
	 * WordPress Password for Login
	 *
	 * @var $password
	 * @since 1.0.0
	 */
	var $password;

	/**
	 * Standard Sleep time for waiting on scripts
	 *
	 * @var $std_sleep
	 * @since 1.0.0
	 */
	var $std_sleep = 1;

	/**
	 * Logging in to WordPress
	 *
	 * @since 1.0.0
	 */
	public function login()
	{
		$this->go_wp_admin();

		$this->byId( 'user_login' )->value( $this->username );
		$this->byId( 'user_pass' )->value( $this->password );

		$this->byId( 'wp-submit' )->submit();

		$classes = $this->byTag( 'html' )->attribute( 'class' );
		$classes = explode( ' ', $classes );

		$this->assertTrue( in_array( 'wp-toolbar', $classes ) );
	}

	/**
	 * Going to URL
	 *
	 * @param $url
	 * @param $force_reload
	 * @since 1.0.0
	 */
	public function go( $url, $force_reload = FALSE )
	{
		$current_url = parse_url ( $this->url() );

		// Only leave site if it's not already opened
		if( $current_url[ 'path' ] != $url || $force_reload == TRUE )
		{
			$this->url( $url );
			sleep( $this->std_sleep ); // Wating for pageload to enter Data
		}
	}

	/**
	 * Going WordPress Admin
	 * @since 1.0.0
	 */
	public function go_wp_admin()
	{
		$this->go( "/wp-admin/" );
	}

	/**
	 * Going WordPress General Settings Page
	 * @since 1.0.0
	 */
	public function go_settings_general()
	{
		$this->go( "/wp-admin/options-general.php" );

	}

	/**
	 * Going WordPress Settings Writing Page
	 * @since 1.0.0
	 */
	public function go_settings_writing()
	{
		$this->go( "/wp-admin/options-writing.php" );
	}

	/**
	 * Going WordPress Settings Reading Page
	 * @since 1.0.0
	 */
	public function go_settings_reading()
	{
		$this->go( "/wp-admin/options-reading.php" );
	}

	/**
	 * Going WordPress Settings Discussion Page
	 * @since 1.0.0
	 */
	public function go_settings_discussion()
	{
		$this->go( "/wp-admin/options-discussion.php" );
	}

	/**
	 * Going WordPress Settings Media Page
	 * @since 1.0.0
	 */
	public function go_settings_media()
	{
		$this->go( "/wp-admin/options-media.php" );
	}

	/**
	 * Going WordPress Settings Permalinks Page
	 * @since 1.0.0
	 */
	public function go_settings_permalinks()
	{
		$this->go( "/wp-admin/options-permalink.php" );
	}

	/**
	 * Setting up Selenium Session
	 *
	 * Use Bash parameters to start:
	 *
	 * bash$ phpunit testscript.php [BROWSER] [HOST] [USER] [PASSWORD]
	 *
	 * @since 1.0.0
	 */
	protected function setUp()
	{
		global $argv, $argc;

		$browser = 'firefox';
		$host = 'localhost';
		$username = 'test';
		$password = 'test';

		if( $argc > 2 )
		{
			$browser = $argv[ 2 ];
			$host = $argv[ 3 ];
			$username = $argv[ 4 ];
			$password = $argv[ 5 ];
		}

		$this->username = $username;
		$this->password = $password;

		$this->setBrowser( $browser );
		$this->setBrowserUrl( "http://" . $host );

		if( method_exists( $this, 'init' ) )
		{
			$this->init();
		}
	}
}