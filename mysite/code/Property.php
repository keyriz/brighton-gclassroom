<?php

class Property extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean',
    );

    private static $has_one = array(
        'Region' => 'Region',
        'PrimaryPhoto' => 'Image',
    );

    private static $summary_fields = array(
        'Title' => 'Title',
        'Region.Title' => 'Region',
        'PricePerNight.Nice' => 'Price',
        'FeaturedOnHomepage.Nice' => 'Featured?',
    );

    public function searchableFields()
    {
        return array(
            'Title' => array(
                'filter' => 'PartialMatchFilter',
                'title' => 'Title',
                'field' => 'TextField'
            ),
            'RegionID' => array(
                'filter' => 'ExactMatchFilter',
                'title' => 'Region',
                'field' => DropdownField::create('RegionID')->setSource(Region::get()->map('ID', 'Title'))->setEmptyString('-- Any Region --'),
            ),
            'FeaturedOnHomepage' => array(
                'filter' => 'ExactMatchFilter',
                'title' => 'Featured',
            )
        );
    }

//    private static $searchable_fields = array(
//        'Title',
//        'Region.Title',
//        'FeaturedOnHomepage',
//    );

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Title'),
            CurrencyField::create('PricePerNight', 'Price (per night)'),
            DropdownField::create('Bedrooms', 'Bedrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('Bathrooms', 'Bathrooms')->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('RegionID', 'Region')->setSource(Region::get()->map('ID', 'Title'))->setEmptyString('-- Select Region --'),
            CheckboxField::create('FeaturedOnHomepage', 'Featured On Homepage'),
        ));
        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create('PrimaryPhoto', 'Photo'));

        $upload->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        $upload->setFolderName('property-photos');

        return $fields;
    }
}