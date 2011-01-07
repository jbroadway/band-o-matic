<?php

require_once ('lib/Database.php');

class Bandorama {
	/**
	 * The global settings.
	 */
	var $settings = array ();

	/**
	 * Are they logged in?
	 */
	var $valid = false;

	/**
	 * If there's an error, this is the message.
	 */
	var $error = false;

	/**
	 * Pass the settings to the constructor.
	 */
	function __construct ($settings) {
		$this->settings = $settings;
	}

	/**
	 * Initialize database tables.
	 */
	function initialize () {
		db_execute ('create table general_settings (
			artist_name char(128) not null,
			twitter_id char(32) not null,
			twitter_posts int not null,
			popups text not null,
			bg_320x480 char(128) not null,
			bg_480x320 char(128) not null,
			bg_768 char(128) not null,
			bg_1024 char(128) not null
		)');
		db_execute ('create table shows (
			id integer primary key,
			date char(10) not null,
			time char(8) not null,
			city char(72) not null,
			venue char(72) not null,
			info char(128) not null,
			ticket_link char(255) not null
		)');
		db_execute ('create table albums (
			id integer primary key,
			name char(128) not null,
			weight int not null,
			icon char(128) not null,
			bg_320x480 char(128) not null,
			bg_480x320 char(128) not null,
			bg_768 char(128) not null,
			bg_1024 char(128) not null,
			songs text not null,
			popups text not null
		)');
		db_execute ('create table email_page (
			title char(72) not null,
			body text not null,
			css text not null
		)');
	}

	/**
	 * Check admin login status.
	 */
	function authenticate () {
		session_start ();

		if (! empty ($_COOKIE['band-o-rama-admin']) && $_COOKIE['band-o-rama-admin'] == $_SESSION['band-o-rama-admin']) {
			$this->valid = true;
			return true;
		}

		if (! empty ($_POST['username']) && ! empty ($_POST['password'])) {
			if ($_POST['username'] == $this->settings['admin_username'] && $_POST['password'] == $this->settings['admin_password']) {
				$key = md5 (mt_rand () . $_POST['username'] . $_POST['password']);
				setcookie ('band-o-rama-admin', $key);
				$_SESSION['band-o-rama-admin'] = $key;
				$this->valid = true;
				return true;
			}
		}

		return false;
	}

	/**
	 * Get or set the general settings.
	 */
	function general_settings ($vals = false) {
		if (! $vals) {
			return db_single ('select * from general_settings');
		}

		if (db_single ('select * from general_settings')) {
			$res = db_execute (
				'update general_settings set artist_name = %s, twitter_id = %s, twitter_posts = %d, popups = %s, bg_320x480 = %s, bg_480x320 = %s, bg_768 = %s, bg_1024 = %s',
				$vals['artist_name'],
				$vals['twitter_id'],
				$vals['twitter_posts'],
				$vals['popups'],
				$vals['bg_320x480'],
				$vals['bg_480x320'],
				$vals['bg_768'],
				$vals['bg_1024']
			);
		} else {
			$res = db_execute (
				'insert into general_settings values(%s, %s, %d, %s, %s, %s, %s, %s)',
				$vals['artist_name'],
				$vals['twitter_id'],
				$vals['twitter_posts'],
				$vals['popups'],
				$vals['bg_320x480'],
				$vals['bg_480x320'],
				$vals['bg_768'],
				$vals['bg_1024']
			);
		}

		if (! $res) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Get or set the email page contents.
	 */
	function email_page ($vals = false) {
		if (! $vals) {
			return db_single ('select * from email_page');
		}

		if (db_single ('select * from email_page')) {
			$res = db_execute (
				'update email_page set title = %s, body = %s, css = %s',
				$vals['title'],
				$vals['body'],
				$vals['css']
			);
		} else {
			$res = db_execute (
				'insert into email_page values(%s, %s, %s)',
				$vals['title'],
				$vals['body'],
				$vals['css']
			);
		}

		if (! $res) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * List all future shows.
	 */
	function list_shows () {
		return db_fetch_array (
			'select * from shows where date >= %s order by date desc, time desc',
			gmdate('Y-m-d')
		);
	}

	/**
	 * List all past shows.
	 */
	function list_past_shows () {
		return db_fetch_array (
			'select * from shows where date < %s order by date desc, time desc',
			gmdate('Y-m-d')
		);
	}

	/**
	 * List all shows.
	 */
	function list_all_shows () {
		return db_fetch_array (
			'select * from shows order by date desc, time desc'
		);
	}

	/**
	 * Retrieve a single show.
	 */
	function view_show ($id) {
		return db_single (
			'select * from shows where id = %d',
			$id
		);
	}

	/**
	 * Add a show.
	 */
	function add_show ($vals) {
		if (! db_execute (
			'insert into shows values (null, %s, %s, %s, %s, %s, %s)',
			$vals['date'],
			$vals['time'],
			$vals['city'],
			$vals['venue'],
			$vals['info'],
			$vals['ticket_link']
		)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Edit a show.
	 */
	function edit_show ($vals) {
		if (! db_execute (
			'update shows set date = %s, time = %s, city = %s, venue = %s, info = %s, ticket_link = %s where id = %d',
			$vals['date'],
			$vals['time'],
			$vals['city'],
			$vals['venue'],
			$vals['info'],
			$vals['ticket_link'],
			$vals['id']
		)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Delete a show.
	 */
	function delete_show ($id) {
		if (! db_execute ('delete from shows where id = %d', $id)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * List all albums.
	 */
	function list_albums () {
		return db_fetch_array (
			'select * from albums order by weight desc'
		);
	}

	/**
	 * Retrieve a single album.
	 */
	function view_album ($id) {
		return db_single (
			'select * from albums where id = %d',
			$id
		);
	}

	/**
	 * Add an album.
	 */
	function add_album ($vals) {
		if (! db_execute (
			'insert into albums values (null, %s, %d, %s, %s, %s, %s, %s, %s, %s)',
			$vals['name'],
			$vals['weight'],
			$vals['icon'],
			$vals['bg_320x480'],
			$vals['bg_480x320'],
			$vals['bg_768'],
			$vals['bg_1024'],
			$vals['songs'],
			$vals['popups']
		)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Edit an album.
	 */
	function edit_album ($vals) {
		if (! db_execute (
			'update albums set name = %s, weight = %s, icon = %s, bg_320x480 = %s, bg_480x320 = %s, bg_768 = %s, bg_1024 = %s, songs = %s, popups = %s where id = %d',
			$vals['name'],
			$vals['weight'],
			$vals['icon'],
			$vals['bg_320x480'],
			$vals['bg_480x320'],
			$vals['bg_768'],
			$vals['bg_1024'],
			$vals['songs'],
			$vals['popups'],
			$vals['id']
		)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Delete an album.
	 */
	function delete_album ($id) {
		if (! db_execute ('delete from albums where id = %d', $id)) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}
}

?>