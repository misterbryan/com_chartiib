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

jimport('joomla.application.hierarchy.controllerform');

/**
 * Hierarchy controller class.
 */
class ChartiibControllerHierarchy extends JControllerForm {

    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    function enregistrer() {

        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $model = $this->getModel('Hierarchy');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');
        $result = $model->enregistrer($data);

        // Redirect to the list screen.
        if ($result) {
            $this->setMessage(JText::_('COM_CHARTIIB_SAVE_SUCCESS'), "message");
        } else {
            $this->setMessage(JText::_('COM_CHARTIIB_SAVE_SUCCESS'), "error");
        }
        $url = 'index.php?option=com_chartiib&view=hierarchies';

        $this->setRedirect(JRoute::_($url, false));
    }

}
