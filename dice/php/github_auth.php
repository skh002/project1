<?php

session_start();

// replace these with your app-specific settings from GitHub:
define("CLIENT_ID", "89396ec919239927f996");
define("CLIENT_SECRET", "922012c0dbd8b79031651b5c8ce3fd5fedc970a5");


if (!(get("code"))) {
	// First landing -- not yet authorized
	// generate random state string
	$state = substr(md5(rand()), 0, 16);
	// store state string to a session variable
	$_SESSION['state'] = $state;
	// redirect to authorization API
	header('Location: https://github.com/login/oauth/authorize?client_id='.CLIENT_ID.'&state='.$state);
	die();
}
else if (get("code")){
	// Second landing -- now authorized
	$code = get("code");
	$state = get("state");
	// use state to verify that the authorization response belongs to own request.
	if (!(get("state"))||($state!=$_SESSION['state'])) {
			echo "Authorization failed.";
			die();
	}
	else {
		// build request to exchange authorization code for access token
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,"https://github.com/login/oauth/access_token");
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&code=". $code."&state=".$state);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		$resp = curl_exec ($curl);
		curl_close ($curl);
		$token = json_decode($resp)->access_token;
		header("Location: ../html/index.html?github_token=".$token);
		die();
	}
}

// helper function for extracting GET parameters
function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

?>