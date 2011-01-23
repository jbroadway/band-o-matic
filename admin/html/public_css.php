#index {
	background-image: url('<?php echo $general->bg_1024; ?>');
	background-size: 100% auto;
}

.iphone-portrait #index {
	background-image: url('<?php echo $general->bg_320x480; ?>');
}

.iphone-landscape #index {
	background-image: url('<?php echo $general->bg_480x320; ?>');
}

.ipad-portrait #index {
	background-image: url('<?php echo $general->bg_768; ?>');
	background-size: auto 100%;
}

.ipad-landscape #index {
	background-image: url('<?php echo $general->bg_1024; ?>');
	background-size: 100% auto;
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
		"#%s {\n\tbackground-image: url('%s');\n\tbackground-size: 100%% auto;\n}\n\n",
		$id,
		$album->bg_1024
	);
	printf (
		".iphone-portrait #%s {\n\tbackground-image: url('%s');\n}\n\n",
		$id,
		$album->bg_320x480
	);
	printf (
		".iphone-landscape #%s {\n\tbackground-image: url('%s');\n}\n\n",
		$id,
		$album->bg_480x320
	);
	printf (
		".ipad-portrait #%s {\n\tbackground-image: url('%s');\n\tbackground-size: auto 100%%;\n}\n\n",
		$id,
		$album->bg_768
	);
	printf (
		".ipad-landscape #%s {\n\tbackground-image: url('%s');\n\tbackground-size: 100%% auto;\n}\n\n",
		$id,
		$album->bg_1024
	);
}

?>