<?php

namespace CyberPanel\Covid\NewsParsers;

class RssNews implements Parser {

	protected $url;

	public function __construct(string $url) {
		$this->url = $url;
	}

	public function getNews() : array {
		$xml = simplexml_load_file($this->url);
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
