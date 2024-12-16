<?php

class ArticleCategoryData extends DataObject
{
	private static $db = array(
		'Title'      => 'Varchar',
		'URLSegment' => 'Varchar',
	);

	private static $has_one = array(
		'ArticleHolder' => 'ArticleHolderPage',
	);

	private static $belongs_many_many = array(
		'Articles' => 'ArticlePage',
	);

	public function GetCMSFields()
	{
		return FieldList::create(
			TextField::create('Title'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
		);
	}

	public function OnBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-article-category') {
			$this->URLSegment = GeneratorUtils::URLSegment($this->Title);
		} else {
			$this->URLSegment = GeneratorUtils::URLSegment($this->URLSegment);
		}

		// Ensure uniqueness
		$count    = 2;
		$original = $this->URLSegment;
		while (PropertyData::get()->filter('URLSegment', $this->URLSegment)->exclude('ID', $this->ID)->exists()) {
			$this->URLSegment = $original . '-' . $count;
			$count++;
		}
	}

	public function Link()
	{
		return $this->ArticleHolder()->Link(
			'category/' . $this->URLSegment
		);
	}
}
