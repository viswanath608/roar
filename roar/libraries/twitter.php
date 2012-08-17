<?php

class Twitter {

	private $consumer_key, $consumer_secret;

	private $token, $token_secret;

	private $error;

	public function __construct($consumer_key, $consumer_secret) {
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
	}

	public function set_token($token) {
		$this->token = $token['oauth_token'];
		$this->token_secret = $token['oauth_token_secret'];
	}

	public function nonce() {
		return hash('md5', mt_rand() . microtime());
	}

	public function encode($str) {
		return str_replace('%7E', '~', rawurlencode($str));
	}

	private function flatten($arr) {
		$pairs = array();

		foreach($arr as $key => $value) $pairs[] = $key . '=' . $this->encode($value);

		return implode('&', $pairs);
	}

	private function sign($uri, $params) {
		ksort($params);

		$string = 'GET&' . $this->encode($uri) . '&' . $this->encode($this->flatten($params));

		return base64_encode(hash_hmac('SHA1', $string, $this->consumer_secret . '&' . $this->token_secret, true));
	}

	private function request($uri, $params) {
		$session = curl_init($uri);

		$pairs = array();

		foreach($params as $key => $value) {
			$pairs[] = $key . '="' . $this->encode($value) . '"';
		}

		$header = implode(', ', $pairs);

		curl_setopt_array($session, array(
			CURLOPT_HTTPHEADER => array('Authorization: OAuth ' . $header),
			CURLOPT_RETURNTRANSFER => true
		));

		$response = curl_exec($session);

		curl_close($session);

		return $response;
	}

	public function parse_response($str) {
		parse_str($str, $output);

		return $output;
	}

	public function error() {
		return $this->error;
	}

	/*
		Step 1.
	*/
	public function request_token($callback = '') {
		$uri = 'http://api.twitter.com/oauth/request_token';

		$params = array(
			'oauth_consumer_key' => $this->consumer_key,
			'oauth_nonce' => $this->nonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
		);

		if($callback) $params['oauth_callback'] = $callback;

		$params['oauth_signature'] = $this->sign($uri, $params);

		$response = $this->request($uri, $params);

		$data = $this->parse_response($response);

		if(isset($data['oauth_token']) and isset($data['oauth_token_secret'])) {
			return $data;
		}

		$this->error = $response;

		return false;
	}

	/*
		Step 2.
	*/
	public function authorize_url() {
		$uri = 'http://api.twitter.com/oauth/authenticate';

		return $uri . '?oauth_token=' . $this->token;
	}

	/*
		Step 3.
	*/
	public function access_token($token, $verifier) {
		$uri = 'http://api.twitter.com/oauth/access_token';

		$uri .= '?oauth_verifier=' . $verifier;

		$params = array(
			'oauth_token' => $token,
			'oauth_consumer_key' => $this->consumer_key,
			'oauth_nonce' => $this->nonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
		);

		$params['oauth_signature'] = $this->sign($uri, $params);

		$response = $this->request($uri, $params);

		$data = $this->parse_response($response);

		if(isset($data['oauth_token']) and isset($data['oauth_token_secret'])) {
			return $data;
		}

		$this->error = $response;

		return false;
	}

	/*
		API Calls
	*/
	public function get($resource) {
		$uri = 'http://api.twitter.com/' . $resource;

		$params = array(
			'oauth_token' => $this->token,
			'oauth_consumer_key' => $this->consumer_key,
			'oauth_nonce' => $this->nonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
		);

		$params['oauth_signature'] = $this->sign($uri, $params);

		return $this->request($uri, $params);
	}

}