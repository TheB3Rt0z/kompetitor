<?php

class Main {

	public static function getVersion($base = false) { // base should be set on first release

		$dir = popen('/usr/bin/du -sk .', 'r');
		$size = $status = fgets($dir, 4096);
		$size = substr($size, 0, strpos($size, "\t"));
		$size = ($size - ($base ? $base : $status)) / 100;
		pclose($dir);

		return number_format($size, 2);
	}


	public static function updateReadme($data) {

		file_put_contents('README.md', $data);
	}
}


function trnslt($string) {

	return $string;
}