<?php

class Property extends DataObject
{
	private static $db = array(
		'Title'              => 'Varchar',
		'URLSegment'         => 'Varchar',
		'PricePerNight'      => 'Currency',
		'Bedrooms'           => 'Int',
		'Bathrooms'          => 'Int',
		'LandArea'           => 'Int',
		'BuildingArea'       => 'Int',
		'AvailableStart'     => 'Date',
		'AvailableEnd'       => 'Date',
		'Summary'            => 'Text',
		'Description'        => 'Text',
		'Address'            => 'Text',
		'Province'           => 'Varchar',
		'City'               => 'Varchar',
		'District'           => 'Varchar',
		'FeaturedOnHomepage' => 'Boolean',
	);

	private static $has_one = array(
		'Region'             => 'Region',
		'PrimaryPhoto'       => 'Image',
		'Category'           => 'PropertyCategory',
		'PropertySearchPage' => 'PropertySearchPage',
	);

	private static $many_many = array(
		'Types'      => 'PropertyType',
		'Facilities' => 'PropertyFacility',
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
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
			TextAreaField::create('Summary', 'Summary or Short Description'),
			CheckboxSetField::create('Types', 'Types of Property', PropertyType::get()->map('ID', 'Title')),
			CurrencyField::create('PricePerNight', 'Price (per night)'),
			DropdownField::create('RegionID', 'Region')->setSource(Region::get()->map('ID', 'Title'))->setEmptyString('-- Select Region --'),
			DropdownField::create('CategoryID', 'Category')->setSource(PropertyCategory::get()->map('ID', 'Title'))->setEmptyString('-- Select Category --'),
			TextField::create('Address', 'Road Address'),
			DropdownField::create('Province', 'Province', array())->setEmptyString('-- Select a province --'),
			DropdownField::create('City', 'City', array())->setEmptyString('-- Select a city --'),
			DropdownField::create('District', 'District', array())->setEmptyString('-- Select a district --'),
			CheckboxField::create('FeaturedOnHomepage', 'Featured On Homepage'),
		));

		$fields->addFieldsToTab('Root.Details', array(
			DropdownField::create('Bedrooms', 'Bedrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			DropdownField::create('Bathrooms', 'Bathrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			NumericField::create('LandArea', 'Land Area (in meters)'),
			NumericField::create('BuildingArea', 'Building Area (in meters)'),
			CheckboxSetField::create('Facilities', 'Facilities of Property', PropertyFacility::get()->map('ID', 'Title')),
		));

		$fields->addFieldToTab('Root.Photos', $upload = UploadField::create('PrimaryPhoto', 'Photo'));
		$upload->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
		$upload->setFolderName('property-photos');

		// Add-on JS
		Requirements::javascript("mysite/js/scripts.js");

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