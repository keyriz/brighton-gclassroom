<?php

class PropertyCategoryData extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar',
	);

	private static $has_many = array(
		'Properties' => 'PropertyData',
	);

	public function GetCMSFields()
	{
		return FieldList::create(
			TextField::create('Title')
		);
	}

	public function Link()
	{
		return $this->Property()->Link(
			'property/category/' . $this->ID
		);
	}
}
