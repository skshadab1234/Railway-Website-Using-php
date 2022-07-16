<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://irctc1.p.rapidapi.com/api/v1/checkSeatAvailability?classType=2A&fromStationCode=PNVL&quota=GN&toStationCode=GKP&trainNo=15066&date=2022-06-25",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: irctc1.p.rapidapi.com",
		"X-RapidAPI-Key: 1108bf426emsh0242dc4a47b9377p1c4b1cjsnfaa6e2a6ca98"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}