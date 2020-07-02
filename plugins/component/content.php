<?php

// no direct access
defined('_JEXEC') or die ();


class PlgFlModuleAdvansedParamsComponentContent extends PlgFlModuleAdvansedParamsComponent
{
	public function filter($params, $module)
	{
		$filter = (self::$input['view'] == 'category' && self::$input['layout']) ? self::$input['layout'] : self::$input['view'];
		
		
		if($params->basic->mode != '')
		{
			$result = is_array($params->basic->items) ? in_array($filter, $params->basic->items) : false;
			
			if($result != $params->basic->mode)
			{
				return true;
			}
		}
		
		if(isset($params->$filter) && $params->$filter->mode != '')
		{
			$item = self::$input['id'];
			
			// switch($filter)
			// {
				// case 'article':
					$item = self::$input['id'];
				// default:
					// $item = self::$input['id'];
			// }
			
			$result = is_array($params->$filter->items) ? in_array($item, $params->$filter->items) : false;
			
			if($result != $params->$filter->mode)
			{
				return true;
			}
		}
		
		return false;
	}
}

/* 
array (size=6)
  'language' => string 'ru-RU' (length=5)
  'Itemid' => string '104' (length=3)
  'option' => string 'com_content' (length=11)
  'lang' => string 'ru-RU' (length=5)
  'view' => string 'archive' (length=7)
  'catid' => 
    array (size=1)
      0 => string '' (length=0)
	
	
	array (size=7)
  'language' => string 'ru-RU' (length=5)
  'Itemid' => string '104' (length=3)
  'option' => string 'com_content' (length=11)
  'lang' => string 'ru-RU' (length=5)
  'view' => string 'category' (length=8)
  'layout' => string 'blog' (length=4)
  'id' => string '2' (length=1)
	
	
	array (size=6)
  'language' => string 'ru-RU' (length=5)
  'Itemid' => string '104' (length=3)
  'option' => string 'com_content' (length=11)
  'lang' => string 'ru-RU' (length=5)
  'view' => string 'categories' (length=10)
  'id' => string '0' (length=1)
	
	
	array (size=6)
  'language' => string 'ru-RU' (length=5)
  'Itemid' => string '104' (length=3)
  'option' => string 'com_content' (length=11)
  'lang' => string 'ru-RU' (length=5)
  'view' => string 'category' (length=8)
  'id' => string '2' (length=1)
	
*/