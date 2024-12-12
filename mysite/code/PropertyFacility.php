<?php

class PropertyFacility extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar',
	);

	private static $belongs_many_many = array(
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
			'property/type/' . $this->ID
		);
	}
}
