<?php

class ArticleHolder extends Page
{
	private static $has_many = array(
		'Categories' => 'ArticleCategoryData'
	);

	private static $allowed_children = array(
		'ArticlePage'
	);

	public function GetCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Categories', GridField::create(
			'Categories',
			'Article categories',
			$this->Categories(),
			GridFieldConfig_RecordEditor::create()
		));

		return $fields;
	}

	public function Regions()
	{
		$page = RegionsPage::get()->first();

		if ($page) {
			return $page->Regions();
		}
	}

	public function ArchiveDates()
	{
		try {
			$list  = ArrayList::create();
			$query = new SQLQuery(array());
			$query->selectField("DATE_FORMAT(`Date`,'%Y_%M_%m')", "DateString")
				->setFrom("ArticlePage_Live")
				->setOrderBy("DateString", "ASC")
				->setDistinct(true);

			$result = $query->execute();

			if ($result) {
				while ($record = $result->nextRecord()) {
					list($year, $monthName, $monthNumber) = explode('_', $record['DateString']);

					$list->push(ArrayData::create(array(
						'Year'         => $year,
						'MonthName'    => $monthName,
						'MonthNumber'  => $monthNumber,
						'Link'         => $this->Link("date/$year/$monthNumber"),
						'ArticleCount' => ArticlePage::get()->where("
							DATE_FORMAT(`Date`,'%Y%m') = '{$year}{$monthNumber}'
							AND ParentID = {$this->ID}
						")->count()
					)));
				}
			}

			return $list;
		} catch (Exception $e) {
			$logMessage = $e->getMessage() . "\n";
			$logMessage .= "File: " . $e->getFile() . "\n";
			$logMessage .= "Line: " . $e->getLine() . "\n";
			$logMessage .= "Trace: " . $e->getTraceAsString() . "\n\n";

			SS_Log::log($logMessage, SS_Log::ERR);

			return null;
		}
	}
}

class ArticleHolder_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'category',
		'region',
		'date'
	);

	protected $articleList;

	public function init()
	{
		parent::init();

		$this->articleList = ArticlePage::get()->filter(array(
			'ParentID' => $this->ID
		))->sort('Date DESC');
	}

	public function index(SS_HTTPRequest $request)
	{
		$articles = Property::get();

		$paginatedArticles = PaginatedList::create(
			$articles,
			$request
		)->setPageLength(15)
			->setPaginationGetVar('s');

		$data = array('Results' => $paginatedArticles);

		if ($request->isAjax()) {
			return $this->customise($data)
				->renderWith('ArticleSearchResults');
		}

		return $data;
	}

	public function category(SS_HTTPRequest $r)
	{
		$category = ArticleCategoryData::get()->filter('URLSegment', $r->param('ID'))->first();

		if (!$category) {
			return $this->httpError(404, 'That category was not found');
		}

		$this->articleList = $this->articleList->filter(array(
			'Categories.ID' => $category->ID
		));

		return array(
			'SelectedCategory' => $category
		);
	}

	public function region(SS_HTTPRequest $r)
	{
		$region = Region::get()->filter('URLSegment', $r->param('ID'))->first();

		if (!$region) {
			return $this->httpError(404, 'That region was not found');
		}

		$this->articleList = $this->articleList->filter(array(
			'RegionID' => $region->ID
		));

		return array(
			'SelectedRegion' => $region
		);
	}

	public function date(SS_HTTPRequest $r)
	{
		SS_Log::log('This is a test error message', SS_Log::ERR);
		$year  = $r->param('ID');
		$month = $r->param('OtherID');

		if (!$year) return $this->httpError(404);

		$startDate = $month ? "{$year}-{$month}-01" : "{$year}-01-01";

		if (strtotime($startDate) === false) {
			return $this->httpError(404, 'Invalid date');
		}

		$adder   = $month ? '+1 month' : '+1 year';
		$endDate = date('Y-m-d', strtotime(
			$adder,
			strtotime($startDate)
		));

		$this->articleList = $this->articleList->filter(array(
			'Date:GreaterThanOrEqual' => $startDate,
			'Date:LessThan'           => $endDate
		));

		return array(
			'StartDate' => DBField::create_field('SS_DateTime', $startDate),
			'EndDate'   => DBField::create_field('SS_DateTime', $endDate)
		);

	}

	public function PaginatedArticles($num = 10)
	{
		return PaginatedList::create(
			$this->articleList,
			$this->getRequest()
		)->setPageLength($num);
	}
}
