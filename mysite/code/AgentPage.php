<?php

class AgentsPage extends Page
{
	private static $has_many = array(
		'Agents' => 'Agent'
	);
}

class AgentsPage_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'view',
	);

	public function view(SS_HTTPRequest $request)
	{
		$region = Agent::get()->byID($request->param('ID'));

		if (!$region) {
			return $this->httpError(404, "Agent not found");
		}

		return array(
			'Agent' => $region,
			'Title' => $region->Title
		);
	}
}
