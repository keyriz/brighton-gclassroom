<?php

class Property extends DataObject
{
	private static $db = array(
		'Title'              => 'Varchar',
		'PricePerNight'      => 'Currency',
		'Bedrooms'           => 'Int',
		'Bathrooms'          => 'Int',
		'FeaturedOnHomepage' => 'Boolean',
		'AvailableStart'     => 'Date',
		'AvailableEnd'       => 'Date',
		'Description'        => 'Text',
		'URLSegment'         => 'Varchar',
	);

	private static $has_one = array(
		'Region'             => 'Region',
		'PrimaryPhoto'       => 'Image',
		'Category'           => 'PropertyCategory',
		'PropertySearchPage' => 'PropertySearchPage',
	);

	private static $many_many = array(
		'Types' => 'PropertyType',
	);

	private static $summary_fields = array(
		'Title'                   => 'Title',
		'Region.Title'            => 'Region',
		'PricePerNight.Nice'      => 'Price',
		'FeaturedOnHomepage.Nice' => 'Featured?',
	);

	public function searchableFields()
	{
		return array(
			'Title'              => array(
				'filter' => 'PartialMatchFilter',
				'title'  => 'Title',
				'field'  => 'TextField'
			),
			'RegionID'           => array(
				'filter' => 'ExactMatchFilter',
				'title'  => 'Region',
				'field'  => DropdownField::create('RegionID')->setSource(Region::get()->map('ID', 'Title'))->setEmptyString('-- Any Region --'),
			),
			'FeaturedOnHomepage' => array(
				'filter' => 'ExactMatchFilter',
				'title'  => 'Featured',
			)
		);
	}

	public function getCMSFields()
	{
		$fields = FieldList::create(TabSet::create('Root'));
		$fields->addFieldsToTab('Root.Main', array(
			TextField::create('Title', 'Title'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setAttribute('placeholder', 'Auto generate content. Keep empty or type manually'),
			CurrencyField::create('PricePerNight', 'Price (per night)'),
			DropdownField::create('Bedrooms', 'Bedrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			DropdownField::create('Bathrooms', 'Bathrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			DropdownField::create('RegionID', 'Region')->setSource(Region::get()->map('ID', 'Title'))->setEmptyString('-- Select Region --'),
			DropdownField::create('CategoryID', 'Category')->setSource(PropertyCategory::get()->map('ID', 'Title'))->setEmptyString('-- Select Category --'),
			CheckboxSetField::create('Types', 'Types of Property', PropertyType::get()->map('ID', 'Title')),
			CheckboxField::create('FeaturedOnHomepage', 'Featured On Homepage'),
		));
		$fields->addFieldToTab('Root.Photos', $upload = UploadField::create('PrimaryPhoto', 'Photo'));

		$upload->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
		$upload->setFolderName('property-photos');

		return $fields;
	}

	public function onBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-property') {
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

	public function Link()
	{
		return "property/view/$this->URLSegment";
	}
}