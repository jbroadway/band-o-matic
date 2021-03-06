/*
 * Band-o-matic
 * Platform for building beautiful mobile/tablet websites for bands.
 *
 * http://www.band-o-matic.org/
 *
 * Copyright (c) 2010-2011 Johnny Broadway
 *
 * Version: 1.0 (2010-12-14)
 * Uses:
 *   jQuery 1.4.4
 *   jQuery Mobile 1.0a2
 *   jQuery UI 1.8.7
 *   jPlayer 2.0.0
 *   Fancybox 1.3.4
 *   PHP 5.1+
 *   SQLite 2.1+
 *
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 */

var _br = (function ($) {
	var br = {},
		images = [],
		message_num = 0,
		cur_page = 'index',
		track = 0,
		playing = false,
		timeout = false;

	br.artist_name = '';

	br.twitter_user = false;

	br.twitter_count = 5;

	br.twitter_feed = [];

	br.show_feed = [];

	br.shows_rss = false;

	br.email_page = false;

	br.news_title = 'News';

	br.shows_title = 'Shows';

	br.tracks = {};

	br.popup_delay = 10000;

	br.initial_popup_delay = 3000;

	br.loop_popups = true;

	br.loop_tracks = true;

	br.player = null;

	br.volume = 0.8;

	br.hide_iframe = false;

	br.in_app = false;

	br.iphone = navigator.userAgent.match (/(iPhone|iPod)/i) ? true : false;

	br.ipad = navigator.userAgent.match (/iPad/i) ? true : false;

	br.android = navigator.userAgent.match (/Android/i) ? true : false;

	br.web = (! br.iphone && ! br.ipad && ! br.android) ? true : false;
	
	br.mobile = ! br.web;

	br.pages = {
		'index': {direction: false}
	};

	br.messages = {};

	br.preload = function () {
		var i;
		for (i = 0; i < arguments.length; i++) {
			images[i] = document.createElement ('img');
			images[i].src = arguments[i];
		}
	};

	br.changePage = function (pg) {
		if (pg === 'index' && ! br.mobile) {
			$('#br-index-about').animate ({marginLeft: '10%'}, 500);
			$('#br-index-news').animate ({marginLeft: '65%'}, 500);
			$('#br-index-shows').animate ({marginLeft: '65%'}, 500);
			$('#br-twitter').show ().animate ({marginLeft: '125%'}, 500);
			$('#br-shows').show ().animate ({marginLeft: '225%'}, 500);
			$('#br-email').show ().animate ({marginLeft: '325%'}, 500);
		}

		if (pg === cur_page) {
			return false;
		}

		$('.active').removeClass ('active');
		$('#br-link-' + pg).addClass ('active');
		cur_page = pg;
		message_num = 0;
		if (timeout) {
			clearTimeout (timeout);
		}
		timeout = setTimeout (function () { _br.popupMessage (); }, br.popup_delay);
		if (pg !== 'index') {
			br.play (pg);
		}
		$.mobile.changePage ('#' + pg, 'slide');
		return false;
	};

	br.setOrientation = function () {
		var prefix = (br.iphone) ? 'iphone-' : false;
			prefix = (! prefix && br.ipad) ? 'ipad-' : prefix;
			prefix = (! prefix) ? 'web-' : prefix;

		if (Math.abs(window.orientation) === 90) {
			$('html').removeClass (prefix + 'portrait').addClass (prefix + 'landscape');
		} else {
			$('html').removeClass (prefix + 'landscape').addClass (prefix + 'portrait');
		}

		window.scrollTo (0, 1200);
	};

	br.init = function () {
		var extra = '', i = 0, url;
		$(document).bind ('orientationchange', br.setOrientation);
		br.setOrientation ();

		if (br.web || br.ipad) {
			$('body').append ('<link  rel="stylesheet" type="text/css" href="css/band-o-matic-web.css" />');
		}

		if (br.web || br.ipad) {
			br.twitter_count = 10;
		}

		$('title').html (br.artist_name);

		br.preload (
			'css/pix/br-pause.png'
		);

		if (window.location.href.match ('app=true')) {
			br.in_app = true;
			br.hide_iframe = false;
			extra = '&app=true';
		}

		if (! br.hide_iframe) {
			url = window.location.href.replace (/#.*$/, '');
			url = url.replace (/\?.*$/, '');
			url = url.replace (/\/$/, '');
			$('#br-play-pause').before (
				$('<iframe src="http://www.band-o-rama.com/frame?top=' + escape (url) + '&ref=' + escape (document.referrer) + extra + '" frameborder="0" id="br-home-frame" scrolling="no" />')
			);
			if (br.in_app) {
				$('#br-home-frame').css ({'width': '40px !important'});
				$('#br-pages').css ({'margin-top': '-46px !important'});
			}
		}

		if (br.about_page || true) {
			//$('#br-play-pause').append (
			//	$('<a rel="br-email" class="br-top-link" id="br-link-email" title="Contact Page"></a>')
			//);
			if (br.web || br.ipad) {
				$('body').append (
					'<div id="br-index-about"></div>'
				);
				$.get (br.about_page, function (res) {
					$('#br-index-about').append (res);
				});
			}
		}

		if (br.email_page) {
			$('#br-play-pause').append (
				$('<a rel="br-email" class="br-top-link" id="br-link-email" title="Contact Page"></a>')
			);
		}

		if (br.shows_url) {
			$('#br-play-pause').append (
				$('<a rel="br-shows" class="br-top-link" id="br-link-shows" title="Shows"></a>')
			);
			$('#index').before (
				$('<div id="br-shows"></div>')
			);
			$('#br-shows').append (
				$('<h2>' + br.shows_title + '</h2><ul id="br-shows-list"></ul>')
			);
			if (br.web || br.ipad) {
				$('body').append (
					'<div id="br-index-shows"><h2>' + br.shows_title + '</h2><ul id="br-index-shows-list"></ul><a href="#" onclick="$(\'#br-link-shows\').trigger (\'click\'); return false">More shows</a>'
				);
			}
		}

		if (br.twitter_user) {
			$('#br-play-pause').append (
				$('<a rel="br-twitter" class="br-top-link" id="br-link-news" title="News"></a>')
			);
			$('#index').before (
				$('<div id="br-twitter"></div>')
			);
			$('#br-twitter').append (
				$('<h2>' + br.news_title + '</h2><ul id="br-twitter-feed"></ul>')
			);
			if (br.twitter_user.match (/^[a-zA-Z0-9_\-]+$/)) {
				$('#br-twitter').append (
					$('<p><a href="http://twitter.com/' + br.twitter_user + '" target="_top">All updates</a></p>')
				);
			}
			if (br.web || br.ipad) {
				$('body').append (
					'<div id="br-index-news"><h2>' + br.news_title + '</h2><ul id="br-index-feed"></ul><a href="#" onclick="$(\'#br-link-news\').trigger (\'click\'); return false">More news</a>'
				);
			}
		}

		$(document).keydown (function (evt) {
			if (evt.keyCode === 32) {
				br.playPause ();
			}
		});

		if (br.mobile) {
			$('a[rel=br-twitter]').fancybox ({
				'overlayShow': false,
				'overlayOpacity': 0,
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'autoScale': false,
				'type': 'inline',
				'href': '#br-twitter',
				'titleShow': false,
				'onStart': function () {
					$('#br-shows').css ('z-index', -1).hide ();
					$('#br-twitter').css ('z-index', 4).show ();
				},
				'onClosed': function () {
					$('#br-twitter').css ('z-index', -1).hide ();
				}
			});
	
			$('a[rel=br-shows]').fancybox ({
				'overlayShow': false,
				'overlayOpacity': 0,
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'autoScale': false,
				'type': 'inline',
				'href': '#br-shows',
				'titleShow': false,
				'onStart': function () {
					$('#br-twitter').css ('z-index', -1).hide ();
					$('#br-shows').css ('z-index', 4).show ();
				},
				'onClosed': function () {
					$('#br-shows').css ('z-index', -1).hide ();
				}
			});
	
			$('a[rel=br-email]').fancybox ({
				'overlayShow': false,
				'overlayOpacity': 0,
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'type': 'iframe',
				'titleShow': false,
				'href': br.email_page,
				'onStart': function () {
					$('#br-twitter').css ('z-index', -1).hide ();
					$('#br-shows').css ('z-index', -1).hide ();
				}
			});
		} else {
			$('#index').before (
				$('<div id="br-email"></div>')
			);
			if (br.email_page) {
				$.get (br.email_page, function (res) {
					$('#br-email').html (res);
				});
			}
			$('a[rel=br-twitter]').click (function () {
				$('#br-index-about').animate ({marginLeft: '-110%'}, 500);
				$('#br-index-news').animate ({marginLeft: '-45%'}, 500);
				$('#br-index-shows').animate ({marginLeft: '-45%'}, 500);
				$('#br-twitter').show ().animate ({marginLeft: '25%'}, 500);
				$('#br-shows').show ().animate ({marginLeft: '125%'}, 500);
				$('#br-email').show ().animate ({marginLeft: '225%'}, 500);
			});
			$('a[rel=br-shows]').click (function () {
				$('#br-index-about').animate ({marginLeft: '-210%'}, 500);
				$('#br-index-news').animate ({marginLeft: '-145%'}, 500);
				$('#br-index-shows').animate ({marginLeft: '-145%'}, 500);
				$('#br-twitter').show ().animate ({marginLeft: '-125%'}, 500);
				$('#br-shows').show ().animate ({marginLeft: '25%'}, 500);
				$('#br-email').show ().animate ({marginLeft: '125%'}, 500);
			});
			$('a[rel=br-email]').click (function () {
				$('#br-index-about').animate ({marginLeft: '-310%'}, 500);
				$('#br-index-news').animate ({marginLeft: '-245%'}, 500);
				$('#br-index-shows').animate ({marginLeft: '-245%'}, 500);
				$('#br-twitter').show ().animate ({marginLeft: '-225%'}, 500);
				$('#br-shows').show ().animate ({marginLeft: '-125%'}, 500);
				$('#br-email').show ().animate ({marginLeft: '25%'}, 500);
			});
		}

		for (i in br.pages) {
			if (br.pages.hasOwnProperty(i)) {
				if (i !== 'index') {
					if (! br.pages[i].transition) {
						br.pages[i].transition = 'slide';
					}
					$('#br-pages').append (
						$('<a href="javascript:void(0);" class="br-page-link" id="br-link-' + i + '" onclick="return _br.changePage (\'' + i + '\')" title="Play Album: ' + i.replace ('-', ' ') + '"></a>')
					);
				}
			}
		}

		timeout = setTimeout (function () { _br.popupMessage (); }, br.initial_popup_delay);

		if (br.twitter_user.match (/^[a-zA-Z0-9_\-]+$/)) {
			$.getScript ('http://twitter.com/statuses/user_timeline/' + br.twitter_user + '.json?callback=_br_twitter_callback&count=' + br.twitter_count);
		} else if (br.twitter_user) {
			$.jGFeed (br.twitter_user, _br_newsrss_callback, br.twitter_count);
		}

		if (br.shows_url) {
			url = (br.shows_url.match (/\?/)) ? br.shows_url + '&callback=_br_shows_callback' : br.shows_url + '?callback=_br_shows_callback';
			$.getScript (url);
		}
	};

	br.playPause = function () {
		if (! br.player) {
			return br.play (cur_page);
		}
		if (! playing) {
			return br.resume ();
		}
		return br.pause ();
	};

	br.pause = function () {
		br.player.jPlayer ('pause');
		$('#br-play-link').css ('background-image', 'url("css/pix/br-play.png")');
		$('#br-web-play-link').css ('background-image', 'url("css/pix/br-play.png")');
		playing = false;
		return false;
	};

	br.resume = function () {
		br.player.jPlayer ('play');
		$('#br-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
		$('#br-web-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
		playing = true;
		return false;
	};

	br.play = function (album) {
		var list = [], i, s;
		if (! br.player) {
			// create player
			br.player = $('#br-player').jPlayer ({
				swfPath: 'js',
				preload: 'auto',
				volume: br.volume,
				ended: br.next
			});
		}

		if (cur_page === 'index') {
			list = [];
			for (i in br.tracks) {
				if (br.tracks.hasOwnProperty(i)) {
					for (s in br.tracks[i]) {
						if (br.tracks[i].hasOwnProperty(s)) {
							list.push (br.tracks[i][s]);
						}
					}
				}
			}
		} else {
			list = br.tracks[cur_page];
		}
	
		if (cur_page !== 'index' || ! playing) {
			track = 0;
			if (playing) {
				br.fadeToNext (list[track]);
			} else {
				br.volume = 0.8;
				br.player.jPlayer ('volume', br.volume).jPlayer ('setMedia', {mp3: list[track]}).jPlayer ('play');
				$('#br-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
				$('#br-web-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
				playing = true;
			}
		}
	
		return false;
	};

	br.fadeToNext = function (next_track) {
		if (br.volume <= 0.1) {
			br.volume = 0.8;
			br.player.jPlayer ('setMedia', {mp3: next_track}).jPlayer ('volume', br.volume).jPlayer ('play');
			$('#br-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
			$('#br-web-play-link').css ('background-image', 'url("css/pix/br-pause.png")');
			playing = true;
			return;
		}
		br.volume -= 0.1;
		br.player.jPlayer ('volume', br.volume);
		setTimeout ('_br.fadeToNext (\'' + next_track + '\');', 100);
	};

	br.next = function () {
		var list = [], i, s;
		if (cur_page === 'index') {
			list = [];
			for (i in br.tracks) {
				if (br.tracks.hasOwnProperty(i)) {
					for (s in br.tracks[i]) {
						if (br.tracks[i].hasOwnProperty(s)) {
							list.push (br.tracks[i][s]);
						}
					}
				}
			}
		} else {
			list = br.tracks[cur_page];
		}

		track++;
		if (track === list.length) {
			track = 0;
			if (! br.loop_tracks) {
				return;
			}
		}

		br.player.jPlayer ('setMedia', {mp3: list[track]}).jPlayer ('play');
	};

	br.previous = function () {
		var list = [], i, s;
		if (cur_page === 'index') {
			list = [];
			for (i in br.tracks) {
				if (br.tracks.hasOwnProperty(i)) {
					for (s in br.tracks[i]) {
						if (br.tracks[i].hasOwnProperty(s)) {
							list.push (br.tracks[i][s]);
						}
					}
				}
			}
		} else {
			list = br.tracks[cur_page];
		}

		track--;
		if (track === list.length) {
			track = list.length - 1;
			if (! br.loop_tracks) {
				return;
			}
		}

		br.player.jPlayer ('setMedia', {mp3: list[track]}).jPlayer ('play');
	};

	br.linkify = function (text) {
		var re_image = /^https?:\/\/.+\.(jpg|png|gif)$/i,
			re_links = / ((https?|ftp|file):\/\/[\-A-Z0-9+&@#\/%?=~_|!:,.;]*[\-A-Z0-9+&@#\/%=~_|])/i,
			re_hashtags = /#[a-z0-9]+/ig,
			re_atlinks = /\@([a-z0-9_-]+)/ig;

		return (text.match (re_image))
				? '<img src="' + text + '" class="br-img" />'
				: text.replace (re_links, ' <a href="$1" class="br-external-link" title="$1"><' + '/a>')
					.replace (re_hashtags, '')
					.replace (re_atlinks, '@<a href="http://twitter.com/$1">$1<' + '/a>');
	};

	br.popupMessage = function () {
		if (message_num >= br.messages[cur_page].length) {
			message_num = 0;
			if (! br.loop_popups) {
				clearTimeout (timeout);
				timeout = false;
				return;
			}
		}

		$('.br-popup').hide ();

		if (br.messages[cur_page][message_num]) {
			var text = br.linkify (br.messages[cur_page][message_num]),
				top = (br.messages[cur_page][message_num].match (/\.(jpg|png|gif)$/i))
					? 10 + Math.round (Math.random () * 25)
					: 15 + Math.round (Math.random () * 50),
				left = 10 + Math.round (Math.random () * 25),
				div = $('<div class="br-popup"></div>').html (text).css ({
					position:'absolute',
					top:top + '%',
					left:left + '%'
				});
	
			$('#' + cur_page).append (div);
		}

		message_num++;
		timeout = setTimeout (function () { _br.popupMessage (); }, br.popup_delay);
	};

	return br;
}(jQuery));

function _br_twitter_callback (data) {
	var i;
	_br.twitter_feed = data;
	for (i in data) {
		if (data.hasOwnProperty(i)) {
			_br.messages.index.push ('Twitter: ' + data[i].text);
			$('ul#br-twitter-feed').append (
				'<li>' + _br.linkify (data[i].text) + '</li>'
			);
			if ((_br.web || _br.ipad) && i < 2) {
				$('ul#br-index-feed').append (
					'<li>' + _br.linkify (data[i].text) + '</li>'
				);
			}
		}
	}
}

function _br_newsrss_callback (feed) {
	var i;
	if (! feed) {
		return false;
	}

	_br.twitter_feed = feed;
	for (i = 0; i < feed.entries.length; i++) {
		_br.messages.index.push ('News: ' + feed.entries[i].title + ' ' + feed.entries[i].link);
		$('ul#br-twitter-feed').append (
			'<li>' + _br.linkify (feed.entries[i].title + ' ' + feed.entries[i].link) + '</li>'
		);
		if ((_br.web || _br.ipad) && i < 2) {
			$('ul#br-index-feed').append (
				'<li>' + _br.linkify (feed.entries[i].title + ' ' + feed.entries[i].link) + '</li>'
			);
		}
	}
	$('#br-twitter').append (
		'<p><a href="' + feed.link + '" target="_top">All updates</a></p>'
	);
}

function _br_shows_callback (data) {
	var i, tickets;
	_br.shows_feed = data;
	if (data.length === 0) {
		$('ul#br-shows-list').append (
			'<li>No shows scheduled at the moment, check back soon!</li>'
		);
		if (_br.web || _br.ipad) {
			$('ul#br-index-shows-list').append (
				'<li>No shows scheduled at the moment, check back soon!</li>'
			);
		}
	} else {
		for (i in data) {
			if (data.hasOwnProperty(i)) {
				tickets = (data[i].ticket_link) ? ' <a href="' + data[i].ticket_link + '" target="_top">Tickets</a>' : '';
				$('ul#br-shows-list').append (
					'<li><strong>' + data[i].date + ' - ' + data[i].time + '</strong> ' + data[i].city + ' <strong>' + data[i].venue + '</strong><br />' + data[i].info + tickets + '</li>'
				);
				if ((_br.web || _br.ipad) && i < 2) {
					$('ul#br-index-shows-list').append (
						'<li><strong>' + data[i].date + ' - ' + data[i].time + '</strong> ' + data[i].city + ' <strong>' + data[i].venue + '</strong> ' + data[i].info + tickets + '</li>'
					);
				}
			}
		}
	}
}
