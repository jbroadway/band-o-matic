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
		db_execute ('create table about_page (
			title char(72) not null,
			body text not null,
			css text not null
		)');
		db_execute ('create table shows_rss (
			feed char(128) not null,
			last_checked TIMESTAMP not null
		)');
		db_execute ('create table show_imports (
			show_id int not null,
			orig_id char(128) not null
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

		if (isset ($vals['body'])) {
			$vals['title'] = $vals['artist_name'];
			$this->about_page ($vals);
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
	 * Get or set the about page contents.
	 */
	function about_page ($vals = false) {
		if (! $vals) {
			return db_single ('select * from about_page');
		}

		if (db_single ('select * from about_page')) {
			$res = db_execute (
				'update about_page set title = %s, body = %s, css = %s',
				$vals['title'],
				$vals['body'],
				$vals['css']
			);
		} else {
			$res = db_execute (
				'insert into about_page values(%s, %s, %s)',
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
	 * Get or set the shows RSS feed.
	 */
	function shows_rss ($feed = false) {
		if (! $feed) {
			return db_single ('select * from shows_rss');
		}
		if (db_single ('select * from shows_rss')) {
			$res = db_execute (
				'update shows_rss set feed = %s, last_checked = 0',
				$feed
			);
		} else {
			$res = db_execute (
				'insert into shows_rss values (%s, 0)',
				$feed
			);
		}

		if (! $res) {
			$this->error = db_error ();
			return false;
		}
		return true;
	}

	/**
	 * Get shows for public site, reading and saving RSS if necessary.
	 * Handles ArtistData and GigPress feeds, and ICS files.
	 */
	function public_shows () {
		$shows_rss = $this->shows_rss ();
		// do we have an RSS feed and has it been an hour?
		if ($shows_rss && $shows_rss->last_checked < time() - 3600) {
			error_reporting (0);
			require_once ('lib/Simplepie.php');
			$sp = new SimplePie ();
			$sp->set_cache_location ('./files');
			$sp->set_cache_duration (1800);
			$sp->set_feed_url ($shows_rss->feed);
			$sp->init ();
			if ($sp->error ()) {
				// artistdata feeds
				if (isset ($sp->data['child']['']['shows'][0]['child']['']['show'])) {
					foreach ($sp->data['child']['']['shows'][0]['child']['']['show'] as $item) {
						$id = $item['child']['']['recordKey'][0]['data'];
						$date = $item['child']['']['date'][0]['data'];
						$time = array_shift (explode ('.', $item['child']['']['timeSet'][0]['data']));
						$city = $item['child']['']['city'][0]['data'];
						$venue = $item['child']['']['venueName'][0]['data'];
						if (! empty ($item['child']['']['name'][0]['data'])) {
							$info = $item['child']['']['name'][0]['data'];
						} else {
							$info = $item['child']['']['description'][0]['data'];
						}
						$ticket_link = $item['child']['']['ticketURI'][0]['data'];
						// check for duplicate and update
						// else insert
						$dupe_id = db_shift ('select show_id from show_imports where orig_id = %s', $id);
						if ($dupe_id) {
							$res = db_execute (
								'update shows set date = %s, time = %s, city = %s, venue = %s, info = %s, ticket_link = %s where id = %d',
								$date,
								$time,
								$city,
								$venue,
								$info,
								$ticket_link,
								$dupe_id
							);
						} else {
							$res = db_execute (
								'insert into shows values (null, %s, %s, %s, %s, %s, %s)',
								$date,
								$time,
								$city,
								$venue,
								$info,
								$ticket_link
							);
							db_execute (
								'insert into show_imports values (%d, %s)',
								db_lastid (),
								$id
							);
						}
					}
				// assume it's an ics file
				} else {
					require_once ('lib/SG_iCalendar/SG_iCal.php');
					$ical = new SG_iCal ($shows_rss->feed);
					// get the timezone of the file
					$info = $ical->getCalendarInfo ();
					$zone = 'GMT'; // default timezone
					foreach ($info->getIterator () as $k => $v) {
						if (strtolower ($k) == 'x-wr-timezone') {
							$zone = $v;
							break;
						}
					}
					date_default_timezone_set ($zone);

					foreach ($ical->getEvents () as $event) {
						$id = $event->getUID ();
						$date = date ('Y-m-d', $event->getStart ());
						$time = date ('H:i:s', $event->getStart ());
						$city = $event->getLocation ();
						$venue = $event->getSummary ();
						$info = $event->getDescription ();
						$ticket_link = $event->getProperty ('url');

						// check for duplicate and update
						// else insert
						$dupe_id = db_shift ('select show_id from show_imports where orig_id = %s', $id);
						if ($dupe_id) {
							$res = db_execute (
								'update shows set date = %s, time = %s, city = %s, venue = %s, info = %s, ticket_link = %s where id = %d',
								$date,
								$time,
								$city,
								$venue,
								$info,
								$ticket_link,
								$dupe_id
							);
						} else {
							$res = db_execute (
								'insert into shows values (null, %s, %s, %s, %s, %s, %s)',
								$date,
								$time,
								$city,
								$venue,
								$info,
								$ticket_link
							);
							db_execute (
								'insert into show_imports values (%d, %s)',
								db_lastid (),
								$id
							);
						}
					}
					
					date_default_timezone_set ('GMT');
				}
			} else {
				foreach ($sp->get_items () as $item) {
					$desc = $item->get_description ();

					$id = $item->get_id ();

					preg_match ('/<strong>Date:<\/strong>\s?([^<]+)<\/li>/', $desc, $m);
					$date = date ('Y-m-d', strtotime (trim ($m[1])));

					preg_match ('/<strong\>Time:<\/strong>\s+?([0-9]+):([0-9]+)(am|pm)/', $desc, $m); //([0-9]+):([0-9]+)(am|pm)<\/li>/', $desc, $m);
					if (isset ($m[1])) {
						if ($m[3] == 'am') {
							$time = str_pad ($m[1], 2, '0', STR_PAD_LEFT) . ':' . $m[2] . ':00';
						} else {
							$time = ($m[1] + 12) . ':' . $m[2] . ':00';
						}
					} else {
						$time = '20:00:00';
					}

					preg_match ('/<strong>City:<\/strong>\s+?([^<]+)<\/li>/', $desc, $m);
					$city = trim ($m[1]);

					preg_match ('/<strong>Venue:<\/strong>\s+?<a.*>(.*)<\/a><\/li>/', $desc, $m);
					$venue = trim ($m[1]);

					preg_match ('/<strong>Notes:<\/strong>\s+?([^<]+)<\/li>/', $desc, $m);
					if (isset ($m[1])) {
						$info = trim ($m[1]);
					} else {
						$info = '';
					}

					preg_match ('/<a href="([^"]+)".*class="gigpress-tickets-link">/', $desc, $m);
					if (isset ($m[1])) {
						$ticket_link = trim ($m[1]);
					} else {
						$ticket_link = '';
					}

					// check for duplicate and update
					// else insert
					$dupe_id = db_shift ('select show_id from show_imports where orig_id = %s', $id);
					if ($dupe_id) {
						$res = db_execute (
							'update shows set date = %s, time = %s, city = %s, venue = %s, info = %s, ticket_link = %s where id = %d',
							$date,
							$time,
							$city,
							$venue,
							$info,
							$ticket_link,
							$dupe_id
						);
					} else {
						$res = db_execute (
							'insert into shows values (null, %s, %s, %s, %s, %s, %s)',
							$date,
							$time,
							$city,
							$venue,
							$info,
							$ticket_link
						);
						db_execute (
							'insert into show_imports values (%d, %s)',
							db_lastid (),
							$id
						);
					}
				}
			}
			// don't check again for an hour
			db_execute ('update shows_rss set last_checked = %s', time());
		}
		return $this->list_shows ();
	}

	/**
	 * List all future shows.
	 */
	function list_shows () {
		return db_fetch_array (
			'select * from shows where date >= %s order by date asc, time asc',
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