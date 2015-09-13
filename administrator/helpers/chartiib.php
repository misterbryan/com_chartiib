<?php

/**
 * @version     1.0.0
 * @package     com_chartiib
 * @copyright   Copyright (C). Tous droits réservés.
 * @license     GNU/GPL version 2 ou version ultérieure
 * @author      Briand Idossou <idossoubr@yahoo.fr> - http://ibrini.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Chartiib helper.
 */
class ChartiibHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
			JText::_('COM_CHARTIIB_TITLE_EMPLOYEES'),
			'index.php?option=com_chartiib&view=employees',
			$vName == 'employees'
		);
JHtmlSidebar::addEntry(
			JText::_('COM_CHARTIIB_TITLE_POSTES'),
			'index.php?option=com_chartiib&view=postes',
			$vName == 'postes'
		);
JHtmlSidebar::addEntry(
			JText::_('COM_CHARTIIB_TITLE_RELATIONS'),
			'index.php?option=com_chartiib&view=relations',
			$vName == 'relations'
		);
JHtmlSidebar::addEntry(
			JText::_('COM_CHARTIIB_TITLE_HIERARCHIES'),
			'index.php?option=com_chartiib&view=hierarchies',
			$vName == 'hierarchies'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_chartiib';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
