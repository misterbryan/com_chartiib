<?php

/**
 * @version     1.0.0
 * @package     com_chartiib
 * @copyright   Copyright (C). Tous droits réservés.
 * @license     GNU/GPL version 2 ou version ultérieure
 * @author      Briand Idossou <idossoubr@yahoo.fr> - http://ibrini.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Hierarchies list controller class.
 */
class ChartiibControllerHierarchies extends ChartiibController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Hierarchies', $prefix = 'ChartiibModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}