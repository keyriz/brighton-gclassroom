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
		'Description'        => 'Text'
	);

	private static $has_one = array(
		'Region'       => 'Region',
		'PrimaryPhoto' => 'Image',
		'Category'     => 'PropertyCategory',
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
}

class Property_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'type'
	);

	public function type(SS_HTTPRequest $r)
	{
		$type = PropertyType::get()->byID(
			$r->param('ID')
		);

		if (!$type) {
			return $this->httpError(404, 'That type was not found');
		}

		$this->articleList = $this->articleList->filter(array(
			'Types.ID' => $type->ID
		));

		return array(
			'SelectedType' => $type
		);
	}
}