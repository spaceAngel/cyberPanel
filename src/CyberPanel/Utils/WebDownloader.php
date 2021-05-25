<?php

namespace CyberPanel\Utils;

use CyberPanel\Exceptions\RemoteContentNotDownloadedException;

class WebDownloader {

	protected const TIMEOUT = 4;

	public static function download(string $url, string $postParams = NULL) : string {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_ENCODING, '');
		curl_setopt($curl, CURLOPT_TIMEOUT, self::TIMEOUT);

		if ($postParams != NULL) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postParams);
		}

		$rslt = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if (empty($rslt) || $httpCode != 200) {
			throw new RemoteContentNotDownloadedException();
		}
		return $rslt;
	}

}

