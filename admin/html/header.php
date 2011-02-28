<html>
<head>
	<title>Band-o-matic - Artist Admin</title>
	<link rel="stylesheet" type="text/css" href="js/uploadify/uploadify.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.8.7.custom.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.pager.js"></script>
	<script type="text/javascript" src="js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
	<script type="text/javascript">
		$(document).ready (function () {
			$('table.list').pager ('tbody', {
				navId: 'nav'
			});
			$('#date').datepicker ({
				dateFormat: 'yy-mm-dd'
			});
			$('.mp3').uploadify ({
				'uploader': '<?php echo $settings['prefix']; ?>js/uploadify/uploadify.swf',
				'script': '<?php echo $settings['prefix']; ?>js/uploadify/uploadify.php',
				'cancelImg': '<?php echo $settings['prefix']; ?>js/uploadify/cancel.png',
				'folder': '<?php echo $settings['prefix']; ?>files',
				'auto': true,
				'fileExt': 'mp3',
				'multi': false,
				'hideButton': true,
				'wmode': 'transparent',
				'onOpen': function () {
					$('.submit').attr ('disabled', 'disabled');
				},
				'onComplete': function (ev, id, file, res, data) {
					$('.submit').attr ('disabled', null);
					songs = $('#songs')[0].value.split ("\n");
					if (songs.length == 1 && songs[0] == '') {
						songs = [];
					}
					if (jQuery.inArray (file.filePath, songs) == -1) {
						songs.push (file.filePath);
					}
					$('#songs')[0].value = songs.join ("\n");
				},
				'onError': function (ev, id, file, err) {
					alert (err.type + ' Error: ' + err.info);
				}
			});
			$('.jpg').uploadify ({
				'uploader': '<?php echo $settings['prefix']; ?>js/uploadify/uploadify.swf',
				'script': '<?php echo $settings['prefix']; ?>js/uploadify/uploadify.php',
				'cancelImg': '<?php echo $settings['prefix']; ?>js/uploadify/cancel.png',
				'folder': '<?php echo $settings['prefix']; ?>files',
				'auto': true,
				'fileExt': 'jpg',
				'multi': false,
				'hideButton': true,
				'wmode': 'transparent',
				'onOpen': function () {
					$('input[type=submit]').attr ('disabled', 'disabled');
				},
				'onComplete': function (ev, id, file, res, data) {
					$('input[type=submit]').attr ('disabled', null);
					$('#' + ev.target.id.replace ('file_', '')).attr ('value', file.filePath);
				}
			});
		});
		function theme_select (theme, image_type) {
			$('#bg_320x480').attr ('value', '<?php echo $settings['prefix']; ?>themes/' + theme + '/320x480.' + image_type);
			$('#bg_480x320').attr ('value', '<?php echo $settings['prefix']; ?>themes/' + theme + '/480x320.' + image_type);
			$('#bg_768').attr ('value', '<?php echo $settings['prefix']; ?>themes/' + theme + '/768x1024.' + image_type);
			$('#bg_1024').attr ('value', '<?php echo $settings['prefix']; ?>themes/' + theme + '/1024x768.' + image_type);
			$('#icon').attr ('value', '<?php echo $settings['prefix']; ?>themes/' + theme + '/icon.jpg');
			$('#themes').hide ('slow');
			return false;
		}
	</script>
</head>
<body>
<div id="wrapper">

<h1 id="title"><img src="pix/logo.png" alt="Band-o-matic" /><span class="title">Artist Admin</span></h1>

<div id="nav">
<?php if (! $unauthorized) { ?>
<a href="logout.php">Log Out</a>
<a href="email.php"<?php if (preg_match ('/^email/', $page)) { echo ' class="active"'; } ?>>Email Page</a>
<a href="music.php"<?php if (preg_match ('/^music/', $page)) { echo ' class="active"'; } ?>>Music</a>
<a href="shows.php"<?php if (preg_match ('/^shows/', $page)) { echo ' class="active"'; } ?>>Shows</a>
<a href="index.php"<?php if (preg_match ('/^index/', $page)) { echo ' class="active"'; } ?>>General</a>
<? } ?>
</div>

<div id="content">
