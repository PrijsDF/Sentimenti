<?php
	if (isset($_POST['texts'])) {
		# Decode the json encoded texts
		$texts = json_decode($_POST['texts']);
		
		# We have to write the texts to the csv line by line. If the file does 
		# not exist, PHP will create it for us
		$fp = fopen('data.csv', 'w');
		foreach ($texts as $text) {
			fputcsv($fp, $text);
		}
		fclose($fp);
		

    }
?>