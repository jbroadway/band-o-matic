.portrait #index {
	background-image: url('<?php echo $general->bg_320x480; ?>');
}

.landscape #index {
	background-image: url('<?php echo $general->bg_480x320; ?>');
}

.min-width-768px #index {
	background-image: url('<?php echo $general->bg_768; ?>');
	background-size: 100% 100%;
}

.min-width-1024px #index {
	background-image: url('<?php echo $general->bg_1024; ?>');
	background-size: 100% 100%;
}

<?php

foreach ($albums as $album) {
	$id = preg_replace ('/[^a-z0-9-]+/', '-', strtolower ($album->name));
	printf (
		"#br-link-%s {\n\tbackground-image: url('%s');\n}\n\n",
		$id,
		$album->icon
	);
	printf (
		".portrait #%s {\n\tbackground-image: url('%s');\n}\n\n",
		$id,
		$album->bg_320x480
	);
	printf (
		".landscape #%s {\n\tbackground-image: url('%s');\n}\n\n",
		$id,
		$album->bg_480x320
	);
	printf (
		".min-width-768px #%s {\n\tbackground-image: url('%s');\n\tbackground-size: 100%% 100%%;\n}\n\n",
		$id,
		$album->bg_768
	);
	printf (
		".min-width-1024px #%s {\n\tbackground-image: url('%s');\n\tbackground-size: 100%% 100%%;\n}\n\n",
		$id,
		$album->bg_1024
	);
}

?>