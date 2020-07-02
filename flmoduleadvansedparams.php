<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.FlModuleAdvansedParams
 *
 * @copyright   Copyright (C) 2017 Vitaliy Moskalyuk. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die ();


class plgSystemFlModuleAdvansedParams extends JPlugin
{
	// protected $autoloadLanguage = false;
	
	// public function __construct(&$subject, $config)
	// {
		// parent::__construct($subject, $config);
	// }
	
	
	public function onContentPrepareForm($form, $data)
	{
		$app = JFactory::getApplication();
		
		if (!$app->isClient('administrator'))
		{
			return;
		}
		
		if(!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		
		// $app->enqueueMessage($formName);
		
		$input = $app->input->getArray();
		
		if(isset($input['layout']) && $input['layout'] == 'edit' && $form->getName() == 'com_modules.module')
		{
			JPlugin::loadLanguage('plg_system_flmoduleadvansedparams');
			
			$dir = __DIR__ . '/forms/';
			
			foreach(scandir($dir) as $file)
			{
				$pathinfo =  pathinfo($file);
				
				if(is_file($dir . $file) && $pathinfo['extension'] == 'xml')
				{
					if($pathinfo['filename'] == '_module')
					{
						$form->loadFile($dir . $file);
					}
					else
					{
						$xml = simplexml_load_file($dir . $file);
						$form->setFields($xml, 'params.fl_advansed.' . explode('.', $pathinfo['filename'])[0], true, 'fl_advansed');
					}
				}
			}
		}
	}
	
	
	public function onExtensionBeforeSave($context, &$table, $isNew)
	{
		if($context == 'com_modules.module')
		{
			$params = json_decode($table->params);
			
			if($params->fl_advansed)
			{
				foreach($params->fl_advansed as $key => $group)
				{
					if($group->mode === '')
					{
						unset($params->fl_advansed->$key);
					}
				}
				
				if(empty((array)$params->fl_advansed))
				{
					unset($params->fl_advansed);
				}
				
				$table->params = json_encode($params);
			}
		}
	}
	
	
	public function onAfterCleanModuleList(&$modules)
	{
		foreach($modules as $i => $module)
		{
			$module_params = json_decode($module->params);
			
			if(isset($module_params->fl_advansed))
			{
				foreach($module_params->fl_advansed as $group => $params)
				{
					if(isset($params->mode) && $params->mode !== '')
					{
						$class = 'PlgFlModuleAdvansedParams' . $group;
						$file = __DIR__ . '/plugins/' . $group . '.php';
						
						JLoader::register($class, $file, false);
						
						if($class::filter($params, $module))
						{
							unset($modules[$i]);
							break;
						}
					}
				}
			}
		}
		
		$modules = array_values($modules);
	}
	
}
