<?php
include_once("phpQuery-onefile.php");

class MovieData{
	var $Title;
	var $Countrys;
	var $Budget;
	var $Gross;
	var $Genres;
	var $Rating;
}

function GetData($data){
	$movieData=new MovieData();
	$html = phpQuery::newDocumentHTML($data, "utf-8");
	
	foreach ($html->find("div.txt-block") as $element) {
		$tag_name=pq($element)->find("h4.inline")->text();
		
		if (strpos($tag_name,"Country")!==FALSE){
			foreach (pq($element)->find("a") as $a) {
				$movieData->Countrys[]=pq($a)->text();
			}
		}
		if (strpos($tag_name,"Budget")!==FALSE){			
			$tmp1=pq($element);
			$tmp1->find("h4.inline")->remove();
			$tmp1->find("span")->remove();
			
			$movieData->Budget=str_replace(Array("$",","),"",trim($tmp1->text()));
		}
		if (strpos($tag_name,"Gross")!==FALSE){			
			$tmp1=pq($element);
			$tmp1->find("h4.inline")->remove();
			$tmp1->find("span")->remove();
			
			$movieData->Gross=str_replace(Array("$",","),"",trim($tmp1->text()));
		}
	}

	
	foreach ($html->find("div.see-more[itemprop=genre] a") as $element) {
		$movieData->Genres[]=trim(pq($element)->text());
	}

	$header=$html->find("h1.header");
	$original_title=trim(str_replace(" (original title)","",$header->find("span.title-extra")->text()));

	$header->find("span.nobr")->remove();
	$header->find("span.title-extra")->remove();
	$movieData->Title=trim($header->text());
	
	if ($original_title!=""){
		$movieData->Title=$original_title;
	}
	
	$movieData->Title=str_replace(Array('"',"\n","         (I)"),"",$movieData->Title);

	$movieData->Rating=$html->find("span[itemprop=ratingValue]")->html();
	return $movieData;
}
?>