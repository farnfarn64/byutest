<?php

namespace App\ThirdParty;

//class to get and send data to BYU's api
//currently instantiates a hard coded user_id

class Byu {

	private $url;
	private $user_id;

	public function __construct() {
		$this->url = "https://api.lib.byu.edu/leaflet/";
		$this->user_id = 88753;
	}

	//calls the api to get an item to rate
	/*
	*					calls the api to get an item to rate
	* return 			array if successful  returns an item array or string if error returns the cURL error
	*/
	public function get_item() {
		$url_extension = "item";

		$result = $this->send_curl($url_extension);

		if ($result['http_code'] == 200) {
			return $result['response'];
		}

		return $result['error'];
	}

	/*
	*					formats the returned item to send to the view
	* params 			array $item item returned from the GET request
	* return 			array $item same item formatted with other information
	*/
	public function format_item(&$item) {
		if ($item['type'] == "FILM") {
			$item['type_description'] = "Would you watch this?";
		} else {
			$item['type_description'] = "Would you read this?";
		}

		if (isset($item['author'])) {
			$item['authors'] = [
				['author' => $item['author']]
			];
		} else {
			$item['authors'] = [];
		}

		$item['type_lowercase'] = ucfirst(strtolower($item['type']));		

		return $item;
	}

	/*
	*					calls the api to rate the item based on the user_id and the item
	* params 			int $item_id the book/movie's item id
	* params 			bool $rating the rating for the item TRUE for yes FALSE for no
	* return 			bool if rating was created and 201 was returned from cURL then TRUE otherwise FALSE
	*/
	public function send_review($item_id, $rating = FALSE) {
		$url_extension = "users/" . $this->user_id . "/ratings";

		$request_type = "POST";

		$post_data = [
			'itemId' => $item_id,
			'rating' => $rating
		];

		$result = $this->send_curl($url_extension, $request_type, json_encode($post_data));

		if ($result['http_code'] == 201) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*
	*					helper function to send the cURL request to the BYU server
	* params 			string $url_extension a string of the extension to append to the base api url
	* params 			string $request_type POST, or GET the default is GET
	* params 			json_string $post_data Data that has been json_encoded to send through the api
	* return 			array response => json_decoded response, http_code => the http_code of the cURL, error => any errors that happened in the cURL
	*/
	private function send_curl($url_extension, $request_type = "GET", $post_data = NULL) {
		$ch = curl_init();

		$url = $this->url . $url_extension;

		$options = [
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => $request_type,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => ["Content-Type:application/json"],
			CURLOPT_POSTFIELDS => $post_data
		];

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$error = curl_error($ch);

		curl_close($ch);

		return [
			'response' => json_decode($response, TRUE),
			'http_code' => $http_code,
			'error' => $error
		];
	}
}

?>