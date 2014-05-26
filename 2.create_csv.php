<?php
include_once("_imdb_parsing.php");
set_time_limit(0);

$fp = fopen('result.csv', 'w');

foreach (glob('data/*.html') as $filename) {
	$file_text = file_get_contents($filename);
	$data=GetData($file_text);
	
	if ($data->Budget!=""){
		if (is_numeric($data->Budget)){
			fputcsv($fp, array($data->Title,$data->Budget),";");
		}
	}
}
fclose($fp);
echo "COMPLETE!"
?>