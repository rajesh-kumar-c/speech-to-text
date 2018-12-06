<?php

for($Cnt1=2;$Cnt1<4;$Cnt1++)
{
	$file = ($Cnt1+1).".mp3";
	$text = getAudioText($file);
	echo "Audio File -> ".$file ." , Text Length -> ".strlen($text)." , Text -> ".$text."<br>";
}

function getAudioText($filename)
{
	$file 		= fopen($filename, 'r');
	$size 		= filesize($filename);
	$fildata 	= fread($file,$size);
	$headers 	= array("Content-Type: audio/mp3","Transfer-Encoding: chunked");
	$username 	= 'xxxxxx';
	$password 	= 'xxxxxx';
	$url 		= 'https://stream.watsonplatform.net/speech-to-text/api/v1/recognize';	  
	$ch 		= curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata);
	curl_setopt($ch, CURLOPT_INFILE, $file);
	curl_setopt($ch, CURLOPT_INFILESIZE, $size);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$executed 	= curl_exec($ch);
	curl_close($ch);
	$results 	= json_decode($executed,true);
	return $results['results'][0]['alternatives'][0]['transcript'];
}
?>