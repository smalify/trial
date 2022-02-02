<?php
if (isset($_GET['vcpcid'])) {
    $channel_id = $_GET['vcpcid'];
	$url = "https://api.sunnxt.com/content/v3/media/".$channel_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'okhttp/2.5.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$headers = array(
	  'Connection:keep-alive', 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'clientKey:ae0502d66312a7423d84bfe39d1f081b3a33ce31d4881650d4da25d02cd6a661','x-myplex-platform:AndroidTV'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	echo $response;
	curl_close($ch);
	
} else {
	header('HTTP/1.0 403 Forbidden');
	echo 'Unauthorized Access.. Access Forbidden!!';
}
?>
