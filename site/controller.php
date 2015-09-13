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

jimport('joomla.application.component.controller');

class ChartiibController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/chartiib.php';

        parent::display($cachable, $urlparams);

        return $this;
    }

}
