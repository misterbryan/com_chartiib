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
 * View class for a list of Chartiib.
 */
class ChartiibViewEmployees extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        ChartiibHelper::addSubmenu('employees');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/chartiib.php';

        JToolBarHelper::title(JText::_('COM_CHARTIIB_TITLE_EMPLOYEES'), 'generic');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/employee';
        if (file_exists($formPath)) {

                JToolBarHelper::addNew('employee.add', 'JTOOLBAR_NEW');
            

            if (isset($this->items[0])) {
                JToolBarHelper::editList('employee.edit', 'JTOOLBAR_EDIT');
            }
        }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('employees.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('employees.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'employees.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('employees.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('employees.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
                JToolBarHelper::deleteList('', 'employees.delete', 'JTOOLBAR_EMPTY_TRASH');
				
                JToolBarHelper::trash('employees.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
        }


        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_chartiib&view=employees');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

                
    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
                'a.name' => JText::_('COM_CHARTIIB_EMPLOYEES_NAME'),
'a.age' => JText::_('COM_CHARTIIB_EMPLOYEES_AGE'),

		);
	}

}
