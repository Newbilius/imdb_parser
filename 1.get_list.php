<?php
include_once("phpQuery-onefile.php");
set_time_limit(0);

if (!file_exists("data"))
	mkdir("data");

$item_num=1;
$year1=1970;
$year2=1990;
$rating="5.0";

do{
	$data = file_get_contents("http://www.imdb.com/search/title?at=0&count=100&genres=horror&release_date=".$year1.",".$year2."&sort=user_rating,desc&start=".$item_num."&title_type=feature&user_rating=".$rating.",10");
	$html = phpQuery::newDocumentHTML($data, "utf-8");

	foreach ($html->find("table.results tr.detailed") as $element) {
		$href=pq($element)->find("td.title a:first")->attr("href");
		$file_name=str_replace(Array("/","title"),"",$href).".html";

	if (!file_exists("data/".$file_name)){
		file_put_contents("data/".$file_name,
			file_get_contents("http://www.imdb.com".$href)
			);	
		}
	}

	$item_num+=100;
} while(strpos($html->find("span.pagination")->text(),"Next")!==FALSE);
?>