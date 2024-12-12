<?php

class AgentAdmin extends ModelAdmin
{
	private static $menu_title     = 'Agents';
	private static $url_segment    = 'agents';
	private static $managed_models = array('Agent');
	private static $menu_icon      = 'mysite/icons/agent.png';
}