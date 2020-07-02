<?php

// no direct access
defined('_JEXEC') or die ();


class PlgFlModuleAdvansedParamsBasic
{
	static $app;
	static $input;
	static $menu;
	static $active;
	static $home;
	
	private static function init()
	{
		self::$app = JFactory::getApplication();
		
		self::$input = self::$app->input->getArray();
		self::$menu = self::$app->getMenu();
		self::$active = self::$app->getMenu()->getActive();
		
		if(JLanguageMultilang::isEnabled())
		{
			self::$home = self::$menu->getDefault(JFactory::getLanguage()->getTag());
		}
		else
		{
			self::$home  = self::$menu->getDefault();
		}
	}
	
	
	public static function filter($params, $module)
	{
		self::init();
		
		$result = 0;
		
		foreach($params as $filter => $params)
		{
			if($params->mode !== '')
			{
				$method = 'filter' . $filter;
				
				$result += self::$method($params, $module);
			}
		}
		
		return ($result > 0) ? true : false;
	}
	
	
	public static function filterHomepage($params, $module)
	{
		$result = self::$active->home ? empty(array_diff_assoc(self::$home->query, self::$input)) : 0;
		
		return ($result != $params->mode) ? 1 : 0;
	}
	
	
	public function filterMenu($params, $module)
	{
		$result = ($module->menuid == self::$active->id) ? empty(array_diff_assoc(self::$active->query, self::$input)) : false;
		
		return ($result == $params->mode) ? 1 : 0;
	}
}
