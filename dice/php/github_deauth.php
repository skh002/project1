<?php

	define("CLIENT_ID", "89396ec919239927f996");

		// build request to exchange authorization code for access token
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,"https://github.com/applications/grants/".CLIENT_ID);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		$resp = curl_exec ($curl);
		curl_close ($curl);
		header("Location: ../html/index.html");
		die();


?>