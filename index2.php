<?php
include_once("phpQuery-onefile.php");
header('Content-Type: text/html; charset=utf-8');
?>

<?
function print_pr($data) {
    echo "<pre>" . print_r($data, true) . "</pre>";
}
$data = file_get_contents("http://www.imdb.com/search/title?at=0&sort=moviemeter,asc&start=8600&title_type=feature&year=2013,2013");
$html = phpQuery::newDocumentHTML($data, "utf-8");

echo (strpos($html->find("span.pagination")->text(),"Next")!==FALSE);

foreach ($html->find("table.results tr.detailed") as $element) {
	print_pr(
	
	pq($element)->find("td.title a:first")->attr("href")
	
	);
}
?>