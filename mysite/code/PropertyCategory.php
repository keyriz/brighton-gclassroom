<?php

class PropertyCategory extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar',
	);

	private static $has_many = array(
		'Properties' => 'Property',
	);

	public function getCMSFields()
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
