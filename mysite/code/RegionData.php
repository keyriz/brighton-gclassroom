<?php

class RegionData extends DataObject
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

	public function GetGridThumbnail()
	{
		if ($this->Photo()->exists()) {
			return $this->Photo()->SetWidth(100);
		}

		return 'No Image';
	}

	public function GetCMSFields()
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

	public function OnBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-region') {
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

	public function LinkingMode()
	{
		return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
	}

	public function ArticlesLink()
	{
		$page = ArticleHolderPage::get()->first();

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
