<?php

class BlogExtension extends DataExtension
{
	/**
	 * @return DataList
	 */
	public function GetFeaturedBlogPosts()
	{
		$controller = Controller::curr();
		$parameters = $controller->getRequest()->allParams();

		$list = BlogPost::get()
			->filter('ParentID', $this->owner->ID)
			->filter('IsFeatured', true);

		if (isset($parameters['Category'])) {
			$list = $list->filter(
				'Categories.URLSegment',
				$parameters['Category']
			);
		}

		return $list;
	}

	/**
	 * @param DataList $posts
	 *
	 * @return DataList
	 */
	public function UpdateGetBlogPosts(DataList &$posts)
	{
		$controller = Controller::curr();
		$request    = $controller->getRequest();
		$filter     = $request->getVar('featured');

		if ($filter) {
			$posts = $posts->filter(array('IsFeatured' => true));
		}
	}

	/**
	 * Returns true if in featured view
	 *
	 * @return boolean
	 */
	public function UetBlogFeatured()
	{
		$c = Controller::curr()->getRequest();

		if ($c->getVar('featured')) {
			return true;
		}

		return null;
	}
}