<?php
include ('simple_html_dom.php');

$searched_string = strtolower(str_replace(" ", "-", htmlspecialchars($_GET["s"])));

if(!empty($searched_string)){
	//$url = 'https://www.magnetdl.com/r/rick-and-morty-1080p-web-dl-x264-rapta/';
	$url = 'https://www.magnetdl.com/' . $searched_string[0] . '/' . $searched_string;
	$html = file_get_html($url);

	$name = [];
	$magnet = [];

	// Find magnet links
	foreach ($html->find('td.m a') as $element) {
		array_push($magnet, $element->href);
	}
	// Find names
	foreach ($html->find('td.n a') as $element) {
		array_push($name, $element->title);
	}
  
	// RSS structure
	header("Content-type: text/xml");
	echo "<?xml version='1.0' encoding='UTF-8'?>
		<rss version='2.0'>
		<channel>
		<title>Your RSS title</title>
		
		<description>Torrents links to download</description>
		<link>https://rss.yourpage.eu</link>";
		
	for ($i = 0;$i <= count($name);$i++) {
		echo "
			<item>
				<title>" . $name[$i] . "</title>
				<link>" . $magnet[$i] . "</link>
			</item>";
	}
	echo "</channel></rss>";
}else{
	echo "No RSS for YOU";
}
