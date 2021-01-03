<?php

namespace CyberPanel\Covid\NewsParsers;

use CyberPanel\Logging\Log;
use CyberPanel\Utils\WebDownloader;
use CyberPanel\Exceptions\RemoteContentNotDownloadedException;

class RssNews implements Parser {

	protected $url;

	public function __construct(string $url) {
		$this->url = $url;
	}

	public function getNews() : array {
		try {
			$xml = simplexml_load_string(
				WebDownloader::download($this->url)
			);
		} catch (RemoteContentNotDownloadedException $e) {
			Log::error('Error during downlaoding RSS fron %s', [$this->url]);
			return [];
		}
		$rslt = [];
		foreach ($xml->channel->item as $item) {
			$rslt[] = [
				'html' => (string)$item->description,
				'time' => $this->pubDateToHuman((string)$item->pubDate),
				'title' => (string)$item->title,
				'link' => (string)$item->link,
				'microtime' => $this->pubDateToMicrotime((string)$item->pubDate),
			];
		}
		return $rslt;
	}

	protected function pubDateToHuman(string $pubDate) : string {
		$date = new \DateTime($pubDate);
		return $date->format('H:i');
	}

	protected function pubDateToMicrotime(string $pubDate) : int {
		$date = new \DateTime($pubDate);
		return $date->getTimestamp();
	}
}
