<?php

namespace CyberPanel\Voice\TextTransformers;

interface TransformerInterface{

	public static function transform(string $text) : string;

}
