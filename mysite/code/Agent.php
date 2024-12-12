<?php

class Agent extends DataObject
{
	private static $db = array(
		'Name'        => 'Varchar',
		'URLSegment'  => 'Varchar',
		'Phone'       => 'Varchar',
		'Description' => 'HTMLText',
	);

	private static $has_one = array(
		'Photo'     => 'Image',
		'AgentPage' => 'AgentPage'
	);

	private static $summary_fields = array(
		'GridThumbnail' => '',
		'Name'          => 'Name',
		'Description'   => 'Description',
	);

	public function getGridThumbnail()
	{
		if ($this->Photo()->exists()) {
			return $this->Photo()->SetWidth(100);
		}

		return 'No Image';
	}

	public function getCMSFields()
	{
		$fields = FieldList::create(
			TextField::create('Name'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
			TextField::create('Phone')->setAttribute('placeholder', '08987654321'),
			HtmlEditorField::create('Description'),
			$upload = UploadField::create('Photo')
		);

		$upload->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
		$upload->setFolderName('agents-photos');

		return $fields;
	}

	public function Link()
	{
		return $this->AgentPage()->Link('view/' . $this->ID);
	}
}
