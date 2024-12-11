<?php

class Region extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Description' => 'HTMLText',
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
            return $this->Photo()->SetWidth(100);
        }

        return 'No Image';
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            HtmlEditorField::create('Description'),
            $upload = UploadField::create('Photo')
        );

        $upload->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
        $upload->setFolderName('regions-photos');

        return $fields;
    }

    public function LinkingMode()
    {
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }

    public function Link()
    {
        return $this->RegionsPage()->Link('show/' . $this->ID);
    }
}
