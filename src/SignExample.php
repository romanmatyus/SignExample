<?php

class SignExample
{
	public function __construct(
		private string $privKeyPath,
		private string $pubKeyPath,
	) {
	}

	public function getSign(string $data): string
	{
		preg_match_all('/-----BEGIN PUBLIC KEY-----\s(.*)\s-----END PUBLIC KEY-----/msU', file_get_contents($this->pubKeyPath), $key);
		$key = str_replace("\n", '', $key[1][0]);
		return hash_hmac("sha256", $data, $key);
	}


	function verified(string $data, string $hmac, string $ecdsa) {
		$publicKey = openssl_pkey_get_public(file_get_contents($this->pubKeyPath));
		$verify = openssl_verify($data . $hmac, base64_decode($ecdsa), $publicKey, OPENSSL_ALGO_SHA256);

		return (bool) $verify;
	}

	public function getEcdsa(string $data): string
	{
		$binary_signature = "";
		openssl_sign($data, $binary_signature, file_get_contents($this->privKeyPath), OPENSSL_ALGO_SHA256);
		return base64_encode($binary_signature);
	}
}
