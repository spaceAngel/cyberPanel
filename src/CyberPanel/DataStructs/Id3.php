<?php


namespace CyberPanel\DataStructs;

class Id3 {

	private $author;
	private $title;
	private $length;

	public function __construct(array $data = []) {
		foreach ($data as $dataItem) {
			if (strpos($dataItem, 'xesam:artist') === 0) {
				$this->author = substr($dataItem, 14);
			}

			if (strpos($dataItem, 'xesam:title') === 0) {
				$this->title = substr($dataItem, 13);
			}

			if (strpos($dataItem, 'mpris:length') === 0) {
				$this->length = (int)substr($dataItem, 14);
			}
		}
	}

	public function getLength() {
		return $this->length;
	}

	public function getName() : ?string {
		if (empty($this->title)) {
			return NULL;
		} else {
			return sprintf('%s - %s', $this->author, $this->title);
		}
	}
}
