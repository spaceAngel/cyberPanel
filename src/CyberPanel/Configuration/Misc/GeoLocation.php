<?php

namespace CyberPanel\Configuration\Misc;

class GeoLocation {

	private string $latitude;

	private string $longitude;

	public function getLatitude() : ?string {
		return $this->latitude;
	}

	public function getLongitude() : ?string {
		return $this->longitude;
	}

	public function setLatitude(string $latitude) : void {
		$this->latitude = $latitude;
	}

	public function setLongitude(string $longitude) : void {
		$this->longitude = $longitude;
	}

	public function isSet() : bool {
		return !empty($this->latitude) && !empty($this->longitude);
	}

}
