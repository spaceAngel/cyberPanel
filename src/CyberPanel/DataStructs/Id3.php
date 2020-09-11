<?php


namespace CyberPanel\DataStructs;

class Id3 {

	private $author;
	private $title;
	private $length;
	private $album;

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

			if (strpos($dataItem, 'xesam:album') === 0) {
				$this->album = substr($dataItem, 13);
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

	public function getArtist() {
		return $this->author;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getAlbum() {
		return $this->album;
	}
}
