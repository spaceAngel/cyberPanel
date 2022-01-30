<?php

namespace CyberPanel\Collector;

interface CollectorInterface {

	public static function getStorageVariableName() : string;

	public function collect() : array;

	public function getTicks() : int;
}
