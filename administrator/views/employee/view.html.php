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
class ChartiibViewEmployee extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
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

        JToolBarHelper::title(JText::_('COM_CHARTIIB_TITLE_EMPLOYEE'), 'generic');

        // If not checked out, can save the item.
            JToolBarHelper::apply('employee.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('employee.save', 'JTOOLBAR_SAVE');
        
            JToolBarHelper::custom('employee.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        
        // If an existing item, can save to a copy.
            JToolBarHelper::custom('employee.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
        
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('employee.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('employee.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
