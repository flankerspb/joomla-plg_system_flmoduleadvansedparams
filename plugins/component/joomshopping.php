<?php

// no direct access
defined('_JEXEC') or die ();


class PlgFlModuleAdvansedParamsComponentJoomshopping extends PlgFlModuleAdvansedParamsComponent
{
	public function filter($params, $module)
	{
		if($input['controller'] == 'category' && $input['view'] == 'category')
		{
			$filter = 'shop';
		}
		else
		{
			$filter = $input['controller'];
		}
		
		if($params->basic->mode != '')
		{
			$result = is_array($params->basic->items) ? in_array($filter, $params->basic->items) : false;
			
			if($result != $params->basic->mode)
			{
				return true;
			}
		}
	}
}