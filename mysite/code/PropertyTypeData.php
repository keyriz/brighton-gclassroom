<?php

class PropertyTypeData extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar',
	);

	private static $belongs_many_many = array(
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
			'property/type/' . $this->ID
		);
	}
}
