<?php

/**
 * @version     1.0.0
 * @package     com_chartiib
 * @copyright   Copyright (C). Tous droits réservés.
 * @license     GNU/GPL version 2 ou version ultérieure
 * @author      Briand Idossou <idossoubr@yahoo.fr> - http://ibrini.com
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldSubmit extends JFormField {

    protected $type = 'submit';
    protected $value;
    protected $for;

    public function getInput() {
        
        $this->value = $this->getAttribute('value');
        
        return '<button id="' . $this->id . '"' 
                . ' name="submit_' . $this->for . '"'
                . ' value="'. $this->value . '"' 
                . ' title="' . JText::_('JSEARCH_FILTER_SUBMIT') . '"'
                . ' class="btn" style="margin-top: -10px;">' 
                . JText::_('JSEARCH_FILTER_SUBMIT') 
                . ' </button>';
    }

}
