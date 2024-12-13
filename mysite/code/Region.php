<?php

class Region extends DataObject
{
	private static $db = array(
		'Title'       => 'Varchar',
		'Description' => 'HTMLText',
		'URLSegment'  => 'Varchar',
	);

	private static $has_one = array(
		'Photo'       => 'Image',
		'RegionsPage' => 'RegionsPage'
	);

	private static $has_many = array(
		'Articles' => 'ArticlePage'
	);

	private static $summary_fields = array(
		'GridThumbnail' => '',
		'Title'         => 'Title',
		'Description'   => 'Description',
	);

	public function getGridThumbnail()
	{
		if ($this->Photo()->exists()) {
			return $this->Photo()->SetWidth(100);
		}

		return 'No Image';
	}

	public function getCMSFields()
	{
		$fields = FieldList::create(
			TextField::create('Title'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
			HtmlEditorField::create('Description'),
			$upload = UploadField::create('Photo')
		);

		$upload->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
		$upload->setFolderName('regions-photos');

		return $fields;
	}

	public function onBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-region') {
			$this->URLSegment = $this->generateURLSegment($this->Title);
		} else {
			$this->URLSegment = $this->generateURLSegment($this->URLSegment);
		}

		// Ensure uniqueness
		$count    = 2;
		$original = $this->URLSegment;
		while (Property::get()->filter('URLSegment', $this->URLSegment)->exclude('ID', $this->ID)->exists()) {
			$this->URLSegment = $original . '-' . $count;
			$count++;
		}
	}

	public function generateURLSegment($title)
	{
		$filter = URLSegmentFilter::create();
		return $filter->filter($title);
	}

	public function LinkingMode()
	{
		return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
	}

	public function ArticlesLink()
	{
		$page = ArticleHolder::get()->first();

		if ($page) {
			return $page->Link('region/' . $this->URLSegment);
		}

		return null;
	}

	public function Link()
	{
		return $this->RegionsPage()->Link('show/' . $this->URLSegment);
	}
}
