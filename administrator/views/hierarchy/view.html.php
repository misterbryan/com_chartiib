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

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class ChartiibViewHierarchy extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
//        var_dump($this->item);
//        exit();
        $app->setUserState("com_chartiib.hierarchy.view_html_php.id", $this->item->id);
       $app->setUserState("com_chartiib.hierarchy.view_html_php.data", $this->item);
//        var_dump($this->item);
//        exit();
        
        $this->form = $this->get('Form');
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }


        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }

        JToolBarHelper::title(JText::_('COM_CHARTIIB_TITLE_HIERARCHY'), 'generic');

              JToolBarHelper::custom('hierarchy.enregistrer', 'save.png', 'save.png', 'JTOOLBAR_SAVE', false);
    
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('hierarchy.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('hierarchy.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
