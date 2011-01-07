_br.artist_name = 'Band Name';

_br.twitter_user = 'bandname';

_br.twitter_count = 5;

_br.shows_url = 'shows.json';

_br.email_page = 'email.html';

_br.popup_delay = 10000;

_br.initial_popup_delay = 3000;

_br.loop_popups = true;

_br.loop_tracks = true;

_br.tracks = {
	'album1': [
		'/m/mp3/song1.mp3',
		'/m/mp3/song2.mp3'
	]
};

_br.pages = {
	'index': {transition: 'slide'},
	'album1': {transition: 'slide'}
};

_br.messages = {
	'index': [
		'Buy our new album on <a href="...itunes link...">iTunes</a>',
		'http://www.bandname.com/photos/live-shot-01.jpg'
	],
	'album1': [
		'Buy this album on <a href="...itunes link...">iTunes</a>',
		'This album was inspired by cute baby animals.'
	]
};
