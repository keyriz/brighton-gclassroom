<?php

class Region extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Description' => 'Text',
    );

    private static $has_one = array(
        'Photo' => 'Image',
        'RegionsPage' => 'RegionsPage'
    );

    private static $summary_fields = array(
        'GridThumbnail' => '',
        'Title' => 'Title',
        'Description' => 'Description',
    );

    public function getGridThumbnail()
    {
        if ($this->Photo()->exists()) {
            return $this->Photo()->setWidth(100);
        }

        return 'No Image';
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            TextAreaField::create('Description'),
            $upload = UploadField::create('Photo')
        );

        $upload->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
        $upload->setFolderName('regions-photos');

        return $fields;
    }
}
