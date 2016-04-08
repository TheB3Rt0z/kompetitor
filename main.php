<?php

class Main {

	public static function getVersion($base = 296) { // base should be reset on first release

		$dir = popen('/usr/bin/du -sk .', 'r');
		$size = fgets($dir, 4096);
		$size = substr($size, 0, strpos($size, "\t"));
		$size = ($size - $base) / 100;
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