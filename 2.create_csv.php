<?php
include_once("_imdb_parsing.php");
set_time_limit(0);

$fp = fopen('result.csv', 'w');

foreach (glob('data/*.html') as $filename) {
	$file_text = file_get_contents($filename);
	$data=GetData($file_text);
	
	if ($data->Budget!=""){
		if (is_numeric($data->Budget)){
			//print_r($data->Title." [".$data->Budget."]");
			fputcsv($fp, array($data->Title,$data->Rating,$data->Budget));
			echo "<br>";
		}
	}
}
fclose($fp);
?>