<?php

class ArticlePage extends Page
{
    private static $db = array(
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar',
    );

    private static $has_one = array(
        'Photo' => 'Image',
        'Brochure' => 'File',
    );

    private static $many_many = array(
        'Categories' => 'ArticleCategory',
    );

    private static $can_be_root = false;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of Article')->setConfig('showcalendar', true), 'Content');
        $fields->addFieldToTab('Root.Main', TextAreaField::create('Teaser', 'Teaser or Summary'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('Author', 'Author of Article')->setDescription('If multiple author, seperate with commas')->setMaxLength(50), 'Content');
        $fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));
        $fields->addFieldToTab('Root.Attachments', $brochure = UploadField::create('Brochure', 'Format pdf only'));
        $fields->addFieldToTab('Root.Categories', CheckboxSetField::create(
            'Categories',
            'Categories of Article',
            $this->Parent()->Categories()->map('ID', 'Title')
        ));

        $photo->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        $photo->setFolderName('travel-photos');
        $brochure->getValidator()->setAllowedExtensions(array('pdf'));
        $brochure->setFolderName('travel-brochures');

        return $fields;
    }
}

class ArticlePage_Controller extends Page_Controller
{

}
