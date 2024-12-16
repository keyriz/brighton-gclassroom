<?php

class GeneratorUtils
{
	public static function Slug($string)
	{
		$filter = URLSegmentFilter::create();
		return $filter->filter($string);
	}
}
