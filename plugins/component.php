<?php

// no direct access
defined('_JEXEC') or die ();


class PlgFlModuleAdvansedParamsComponent
{
	static $input;
	
	private function init()
	{
		$input = JFactory::getApplication()->input->getArray();
		
		// if($input['option'] == 'com_categories')
		// {
			// $input['option'] = $input['extension'];
		// }
		
		self::$input = $input;
	}
	
	public function filter($params, $module)
	{
		self::init();
		
		$filter = substr(self::$input['option'], 4);
		
		if(isset($params->$filter))
		{
			$class = __CLASS__ . $filter;
			$file = substr(__FILE__, 0, -4) . '/' . $filter . '.php';
		
			JLoader::register($class, $file, false);
			
			return $class::filter($params->$filter);
		}
		else
		{
			return false;
		}
	}
}
