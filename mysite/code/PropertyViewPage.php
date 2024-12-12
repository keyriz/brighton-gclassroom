<?php

class PropertyViewPage extends Page
{

	private static $db = array(
		'PropertyID' => 'Int'
	);

	private static $has_one = array(
		'Property' => 'Property'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		// Create a DropdownField to select the Property
		$properties = Property::get()->map('ID', 'Title');
		$fields->addFieldToTab('Root.Main', DropdownField::create('PropertyID', 'Property', $properties));

		return $fields;
	}

	public function Link($action = null)
	{
		$property = $this->Property();
		if ($property) {
			return Controller::join_links(parent::Link(), $property->URLSegment);
		} else {
			return false;
		}
	}

}