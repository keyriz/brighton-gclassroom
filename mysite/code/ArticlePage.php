<?php

class ArticlePage extends Page
{
	private static $db = array(
		'Date'   => 'Date',
		'Teaser' => 'Text',
		'Author' => 'Varchar',
	);

	private static $has_one = array(
		'Photo'    => 'Image',
		'Brochure' => 'File',
		'Region'   => 'RegionData'
	);

	private static $many_many = array(
		'Categories' => 'ArticleCategoryData',
	);

	private static $has_many = array(
		'Comments' => 'ArticleCommentData',
	);

	private static $can_be_root = false;

	public function GetCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of Article')->setConfig('showcalendar', true), 'Content');
		$fields->addFieldToTab('Root.Main', TextAreaField::create('Teaser', 'Teaser or Summary'), 'Content');
		$fields->addFieldToTab('Root.Main', TextField::create('Author', 'Author of Article')->setDescription('If multiple author, seperate with commas')->setMaxLength(50), 'Content');
		$fields->addFieldToTab('Root.Main', DropdownField::create('RegionID', 'Region', RegionData::get()->map('ID', 'Title'))->setEmptyString('-- None --'), 'Content');
		$fields->addFieldToTab('Root.Categories', CheckboxSetField::create('Categories', 'Categories of Article', $this->Parent()->Categories()->map('ID', 'Title')));
		$fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));
		$fields->addFieldToTab('Root.Attachments', $brochure = UploadField::create('Brochure', 'Format pdf only'));

		$photo->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
		$photo->setFolderName('travel-photos');
		$brochure->getValidator()->setAllowedExtensions(array('pdf'));
		$brochure->setFolderName('travel-brochures');

		return $fields;
	}

	public function CategoriesList()
	{
		if ($this->Categories()->exists()) {
			return implode(', ', $this->Categories()->column('Title'));
		} else {
			return 'Uncategorized';
		}
	}

	public function GetBrochureExtension()
	{
		if ($this->Brochure()->exists()) {
			return $this->Brochure()->getExtension(); // SilverStripe 3 Brochure method
		}
		return null;
	}

	public function GetFormattedBrochureSize()
	{
		if ($this->Brochure()->exists()) {
			$sizeInBytes = $this->Brochure()->getAbsoluteSize();
			return $this->formatBytes($sizeInBytes);
		}
		return null;
	}

	private function FormatBytes($bytes, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow   = min($pow, count($units) - 1);

		$bytes /= (1 << (10 * $pow));
		return round($bytes, $precision) . ' ' . $units[$pow];
	}
}

class ArticlePage_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'CommentForm'
	);

	public function CommentForm()
	{
		$form = Form::create(
			$this,
			__FUNCTION__,
			FieldList::create(
				TextField::create('Name', ''),
				EmailField::create('Email', ''),
				TextAreaField::create('Comment', '')
			),
			FieldList::create(
				FormAction::create('commentformhandler', 'Post Comment')->setUseButtonTag(true)->addExtraClass('btn btn-default-color btn-lg')
			),
			RequiredFields::create('Name', 'Email', 'Comment')
		)->addExtraClass('form-style');

		foreach ($form->Fields() as $field) {
			$field->addExtraClass('form-control')->setAttribute('placeholder', $field->getName() . '*');
		}

		$data = Session::get("FormData.{$form->getName()}.data");

		return $data ? $form->loadDataFrom($data) : $form;
	}

	public function commentformhandler($data, $form)
	{
		Session::set("FormData.{$form->getName()}.data", $data);

		$existing = $this->Comments()->filter('Comment', $data['Comment']);

		if ($existing->exists() && strlen($data['Comment']) > 20) {
			$form->sessionMessage('Comment already exists.', 'warning');
			return $this->redirectBack();
		}

		$comment                = ArticleCommentData::create();
		$comment->ArticlePageID = $this->ID;
		$form->saveInto($comment);
		$comment->write();

		Session::clear("FormData.{$form->getName()}.data");
		$form->sessionMessage('Your comment has been posted.', 'good');

		return $this->redirectBack();
	}
}
