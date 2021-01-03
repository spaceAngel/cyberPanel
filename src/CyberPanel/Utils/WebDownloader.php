<?php

namespace CyberPanel\Utils;

use CyberPanel\Exceptions\RemoteContentNotDownloadedException;

class WebDownloader {


	public static function download(string $url) : string {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_ENCODING, '');

		$rslt = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if (empty($rslt) || $httpCode != 200) {
			throw new RemoteContentNotDownloadedException();
		}
		return $rslt;
	}

}

