<?php

namespace CyberPanel\Integration\News\Parsers;

use CyberPanel\Integration\News\Parsers\Parsers\IdnesOnlineNews;
use CyberPanel\Integration\News\Parsers\Parsers\UaLiveMap;

class ParserResolver {

	public static function getParser(string $source) : ?ParserInterface {
		$url = parse_url($source);
		switch ($url['host']) {
			case 'www.idnes.cz':
				return new IdnesOnlineNews();
			case 'liveuamap.com':
				return new UaLiveMap();
		}
	}
}
