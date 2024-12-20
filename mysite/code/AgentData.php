<?php

class AgentData extends DataObject
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

	private static $has_many = array(
		'Properties' => 'PropertyData'
	);

	private static $summary_fields = array(
		'GridThumbnail' => '',
		'Name'          => 'Name',
		'Phone'         => 'Phone',
		'Description'   => 'Description',
	);

	public function GetGridThumbnail()
	{
		if ($this->Photo()->exists()) {
			return $this->Photo()->SetWidth(100);
		}

		return 'No Image';
	}

	public function GetCMSFields()
	{
		$fields = FieldList::create(
			TextField::create('Name'),
			TextField::create('URLSegment', 'URL Segment (Slug)')->setDisabled(true)->setAttribute('placeholder', 'Auto generate content'),
			TextField::create('Phone', 'WhatsApp Number')->setAttribute('placeholder', '628987654321'),
			$upload = UploadField::create('Photo'),
			HtmlEditorField::create('Description')
		);

		$upload->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
		$upload->setFolderName('agents-photos');
//		$upload->setAllowedMaxFileSize(1024 * 1024 * 2); // Tidak ada pada silverstripe versi 3.x

		return $fields;
	}

	public function OnBeforeWrite()
	{
		parent::onBeforeWrite();

		if (!$this->URLSegment || $this->URLSegment == 'new-agent') {
			$this->URLSegment = GeneratorUtils::slug($this->Name);
		} else {
			$this->URLSegment = GeneratorUtils::slug($this->URLSegment);
		}

		// Ensure uniqueness
		$count    = 2;
		$original = $this->URLSegment;
		while (PropertyData::get()->filter('URLSegment', $this->URLSegment)->exclude('ID', $this->ID)->exists()) {
			$this->URLSegment = $original . '-' . $count;
			$count++;
		}
	}

	public function GetPhoneWhatsapp()
	{
		return preg_replace('/^08/', '628', $this->Phone);
	}

	public function Link()
	{
		return $this->AgentPage()->Link('view/' . $this->ID);
	}
}
