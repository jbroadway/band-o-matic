var _admin = (function ($) {
	var admin = {},
		url = window.location.href.split ('/admin/').shift ();

	admin.registered_for_bandorama = function () {
		$.getScript ('http://www.band-o-rama.com/artist/registered?callback=registered_for_bandorama&url=' + escape (url));
	};

	admin.bandorama_info = function () {
		url = 'http://johnnybroadway.blnk.cc';
		$.getScript ('http://www.band-o-rama.com/artist/info?callback=bandorama_info&url=' + escape (url));
	};

	return admin;
}(jQuery));

function registered_for_bandorama (res) {
	if (! res.registered) {
		$('#registered-for-bandorama').show ();
	}
}

function bandorama_info (res) {
	if (res.registered) {
		$('#bandorama-info').html (
			'<p><strong>Listener Stats:</strong><br />' +
			'<img src="' + res.stats + '" border="0" style="background: #333; padding: 10px 10px 0px 10px" /><br />' + 
			'<small>Stats are updated every 6 hours.</small></p>' +
			'<img src="' + res.icon + '" border="0" style="float: left; margin-right: 10px" />' +
			'<p><strong>' + res.name + '</strong></p>' +
			'<p>Current Single: <a href="' + res.mp3 + '">' + res.song + '</a></p>' +
			'<p><a href="http://www.band-o-rama.com/account">Update your Band-o-rama listing</a></p>' +
			'<br clear="both" /><br />'
		);
	} else {
		$('#bandorama-info').hide ();
		$('#registered-for-bandorama').show ();
	}
}
