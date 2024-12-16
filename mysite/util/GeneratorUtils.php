<?php

class GeneratorUtils
{
	public static function URLSegment($string)
	{
		$filter = URLSegmentFilter::create();
		return $filter->filter($string);
	}
}
