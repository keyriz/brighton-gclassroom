<?php

class PropertyData extends DataObject
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
		'Address'            => 'Text',
		'Province'           => 'Varchar',
		'City'               => 'Varchar',
		'District'           => 'Varchar',
		'FeaturedOnHomepage' => 'Boolean',
		'Description'        => 'HTMLText',
	);

	private static $has_one = array(
		'Region'             => 'RegionData',
		'PrimaryPhoto'       => 'Image',
		'Category'           => 'PropertyCategoryData',
		'PropertySearchPage' => 'PropertySearchPage',
		'Agent'              => 'AgentData',
	);

	private static $many_many = array(
		'Types'      => 'PropertyTypeData',
		'Facilities' => 'PropertyFacilityData',
	);

	private static $summary_fields = array(
		'Title'                   => 'Title',
		'Region.Title'            => 'Region',
		'PricePerNight.Nice'      => 'Price',
		'FeaturedOnHomepage.Nice' => 'Featured?',
	);

	public function SearchableFields()
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
				'field'  => DropdownField::create('RegionID')->setSource(RegionData::get()->map('ID', 'Title'))->setEmptyString('-- Any Region --'),
			),
			'FeaturedOnHomepage' => array(
				'filter' => 'ExactMatchFilter',
				'title'  => 'Featured',
			)
		);
	}

	public function GetCMSFields()
	{
		$fields = FieldList::create(TabSet::create('Root'));

		$fields->addFieldsToTab('Root.Main', array(
			TextField::create('Title', 'Title'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
			TextAreaField::create('Summary', 'Summary or Short Description'),
			CheckboxSetField::create('Types', 'Types of Property', PropertyTypeData::get()->map('ID', 'Title')),
			DropdownField::create('AgentID', 'Agent of Property', AgentData::get()->map('ID', 'Name')),
			CurrencyField::create('PricePerNight', 'Price (per night)'),
			DropdownField::create('RegionID', 'Region')->setSource(RegionData::get()->map('ID', 'Title'))->setEmptyString('-- Select Region --'),
			DropdownField::create('CategoryID', 'Category')->setSource(PropertyCategoryData::get()->map('ID', 'Title'))->setEmptyString('-- Select Category --'),
			TextField::create('Address', 'Road Address'),
			DropdownField::create('Province', 'Province')->setSource($this->getProvinceOptions())->setEmptyString('-- Select a Province --'),
			DropdownField::create('City', 'City')->setEmptyString('-- Select a City --'),
			DropdownField::create('District', 'District')->setEmptyString('-- Select a District --'),
			CheckboxField::create('FeaturedOnHomepage', 'Featured On Homepage'),
		));

		$fields->addFieldsToTab('Root.Details', array(
			DropdownField::create('Bedrooms', 'Bedrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			DropdownField::create('Bathrooms', 'Bathrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
			NumericField::create('LandArea', 'Land Area (in meters)'),
			NumericField::create('BuildingArea', 'Building Area (in meters)'),
			CheckboxSetField::create('Facilities', 'Facilities of Property', PropertyFacilityData::get()->map('ID', 'Title')),
			HtmlEditorField::create('Description'),
		));

		$fields->addFieldToTab('Root.Photos', $upload = UploadField::create('PrimaryPhoto', 'Photo'));
		$upload->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
		$upload->setFolderName('property-photos');

		// Add-on JS
		Requirements::javascript("mysite/js/scripts.js");

		return $fields;
	}

	public function GetProvinceOptions()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://api.caller/province");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			curl_close($ch);
			return null;
		}

		curl_close($ch);

		$data = json_decode($response, true);
		$data = $data['data'];

		return array_reduce($data, function ($carry, $item) {
			$carry[$item['name']] = $item['name'];
			return $carry;
		}, array());
	}

	public function OnBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-property') {
			$this->URLSegment = GeneratorUtils::Slug($this->Title);
		} else {
			$this->URLSegment = GeneratorUtils::Slug($this->URLSegment);
		}

		if ($this->Province) {
			$explode        = explode(';', $this->Province);
			$this->Province = $explode[1];
		}

		// Ensure uniqueness
		$count    = 2;
		$original = $this->URLSegment;
		while (PropertyData::get()->filter('URLSegment', $this->URLSegment)->exclude('ID', $this->ID)->exists()) {
			$this->URLSegment = $original . '-' . $count;
			$count++;
		}
	}

	public function GetFormattedPrice()
	{
		return '$' . number_format($this->PricePerNight, 2);
	}

	public function GetAddressCensored()
	{
		return preg_replace_callback('/\d+/', function ($matches) {
			// Replace numbers with up to 3 '*'
			$length = strlen($matches[0]);
			return str_repeat('*', min($length, 3));
		}, $this->Address);
	}

	public function Link()
	{
		return "property/view/$this->URLSegment";
	}
}