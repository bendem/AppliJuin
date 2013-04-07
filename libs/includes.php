<?php

$exclude = array('.', '..', '.htaccess');

$dir = opendir(LIBS_DIR);
while (($file = readdir()) !== false) {
	if($file != basename(__FILE__) && !in_array($file, $exclude)) {
		require_once LIBS_DIR . DS . $file;
	}
}
