<?php

class GeneratorUtils
{
	public static function slug($string)
	{
		$filter = URLSegmentFilter::create();
		return $filter->filter($string);
	}
}
