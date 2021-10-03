<?php

namespace CyberPanel\Voice\TextTransformers;

class CzechTransformer implements TransformerInterface {

	public static function transform(string $text) : string {
		$text = self::modifyIpAddress($text);
		$text = self::modifyNumbers($text);
		return $text;
	}

	protected static function modifyIpAddress(string $text) : string {
		return preg_replace('/(\d{1,3}+)\./', '$1 ', $text);
	}

	protected static function modifyNumbers(string $text) : string {
		$text = preg_replace('/(\d+)1/', ' ${1}0jedna ', $text);
		$text = preg_replace('/1(\s)/', 'jedna ', $text);
		return $text;
	}
}
