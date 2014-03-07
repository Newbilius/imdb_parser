<?php
include_once("phpQuery-onefile.php");
header('Content-Type: text/html; charset=utf-8');
?>

<?
function print_pr($data) {
    echo "<pre>" . print_r($data, true) . "</pre>";
}
/*
$url="http://www.imdb.com/title/tt0083907/?ref_=nv_sr_2";
$url="http://www.imdb.com/title/tt1266029/?ref_=fn_al_tt_2";

$data = file_get_contents($url);
file_put_contents("tmp3.txt",$data);
*/
$data = file_get_contents("tmp1.txt");

$html = phpQuery::newDocumentHTML($data, "utf-8");

foreach ($html->find("div.txt-block") as $element) {
	$tag_name=pq($element)->find("h4.inline")->text();

	
	if (strpos($tag_name,"Country")!==FALSE){
		echo "Country: ";
		foreach (pq($element)->find("a") as $a) {
			print_pr(pq($a)->text());
		}
	}
	if (strpos($tag_name,"Budget")!==FALSE){
		echo "Budget: ";
		
		$tmp1=pq($element);
		$tmp1->find("h4.inline")->remove();
		$tmp1->find("span")->remove();
		
		print_pr(str_replace(Array("$",","),"",trim($tmp1->text())));
	}
}

echo "Жанры <br>";
foreach ($html->find("div.see-more[itemprop=genre] a") as $element) {
	print_pr(trim(pq($element)->text()));
}

$header=$html->find("h1.header");
echo "Title:";
print_pr(trim(str_replace(" (original title)","",$header->find("span.title-extra")->text())));

$header->find("span.nobr")->remove();
$header->find("span.title-extra")->remove();
echo "Title2:";
print_pr(trim($header->text()));

echo "RATING";
print_pr($html->find("span[itemprop=ratingValue]")->html());
?>