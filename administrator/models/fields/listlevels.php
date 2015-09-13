<?php

/**
 * @version     1.0.0
 * @package     com_chartiib
 * @copyright   Copyright (C). Tous droits réservés.
 * @license     GNU/GPL version 2 ou version ultérieure
 * @author      Briand Idossou <idossoubr@yahoo.fr> - http://ibrini.com
 */
defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a generic list of options.
 *
 * @since  11.1
 */
class JFormFieldListlevels extends JFormField {

    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'Listlevels';

    /**
     * Method to get the field input markup for a generic list.
     * Use the multiple attribute to enable multiselect.
     *
     * @return  string  The field input markup.
     *
     * @since   11.1
     */
    protected function getInput() {
        $html = array();
        $attr = 'class=""';
        $required = ""; 
        // Get the field options.
        $array_global = (array) $this->getOptions();
        
        //Récupérer la liste des postes
        $list_posts = $array_global[0];
        $list_posts_high = $array_global[1];
        $list_posts_saved = $array_global[2];
        $list_posts_high_saved = $array_global[3];
        $posts_on_level = $array_global[4];

        $display = "";
        for ($i = 0; $i < $posts_on_level; $i++) {
            /*
             * 
             */

            $display .= '
        <div class="duplicate_div">
            <p>
                <label class="hastooltip" title="' . JText::_("COM_CHARTIIB_FORM_DESC_LEVEL_LIST_POSTS") . '">' . JText::_("COM_CHARTIIB_FORM_LBL_LEVEL_LIST_POSTS") . '</label>
                ';
            if (count($list_posts_saved) == 0 OR (count($list_posts_saved) == 1 AND $list_posts_saved[0] == "")) {
                $list_posts_saved[$i] = "";
            }
            
            $display .= JHtml::_('select.genericlist', $list_posts, $this->name . '[list_posts][]', trim($required), 'id', 'title', $list_posts_saved[$i], $this->id . "_tables_fields");
            $display .= '
            </p>
            <p>
                <label class="hastooltip" title="' . JText::_("COM_CHARTIIB_FORM_DESC_LEVEL_LIST_POSTS_HIGH") . '">' . JText::_("COM_CHARTIIB_FORM_LBL_LEVEL_LIST_POSTS_HIGH") . '</label>
                ';
            if (count($list_posts_high_saved) == 0 OR (count($list_posts_high_saved) == 1 AND $list_posts_high_saved[0] == "")) {
                $list_posts_high_saved[$i] = "";
            }
            $display .= JHtml::_('select.genericlist', $list_posts_high, $this->name . '[list_posts_high][]', trim($attr), 'id', 'title', $list_posts_high_saved[$i], $this->id . "_tables_fields");
            $display .= '
            </p>
            <p>
                <button class="btn btn-success btn-sm btn_add_new_field" style="" onclick="javascript:addOption(this);" type="button" name="+">' . JText::_("COM_CHARTIIB_BUTTON_ADD") . '</button>
                <button class="btn btn-danger btn-sm" onclick="javascript:removeOption(this);" type="button">' . JText::_("COM_CHARTIIB_BUTTON_REMOVE") . '</button>
            </p>
        </div>
       ';
        }

        $html[] = $display;
        
        return implode($html);
    }

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    public function getOptions() {
        $app = JFactory::getApplication();
        $posts_on_level = 1;

        // --------- Liste des postes disponibles -------------
        $db_one = JFactory::getDbo();
        $query = $db_one->getQuery(true);
        $query->select($db_one->quoteName(array('id', 'title')));
        $query->from($db_one->quoteName('#__chartiib_posts'));
        $query->order("title ASC");

        $db_one->setQuery($query);
        $list_posts = $db_one->loadObjectList();
        $empty = (object) array(
                    'id' => "",
                    'title' => JText::_("COM_CHARTIIB_FORM_DEFAULT_SELECT_POST")
        );

        array_unshift($list_posts, $empty);

        //Tables of correspondances
        $correspondances = array("" => "");
        foreach ($list_posts as $value) {
            $correspondances[$value->id] = $value->title;
        }

        $current_id = $app->getUserState("com_chartiib.hierarchy.view_html_php.id", null);

        /*
         * 1- Récupérer les postes du niveau précédent dans la table #__chartiib_hierarchy
         * 2- Ajouter un élément vide pour permettre au user de ne rien choisir
         */

// Create a new query object.
        $list_posts_saved = array();
        $list_posts_high_saved = array();
        if (is_null($current_id)) {
            //Si c'est un ajout
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->quoteName(array('level')));
            $query->from($db->quoteName('#__chartiib_hierarchy'));
            $query->order("created DESC");

            $db->setQuery($query);
            $results = $db->loadObject();
            
            // --------- Valeurs disponibles pour les postes hiérarchiques supérieurs -------------
            $list_posts_high = array("" => array("id" => "", "title" => ""));
            if (!is_null($results)) {
                $levels = json_decode($results->level);
                $posts_previous = $levels->list_posts;
                foreach ($posts_previous as $value) {
                    if ($value != "") {
                        $tab_id_title = array("id" => $value, "title" => $correspondances[$value]);
                        array_push($list_posts_high, $tab_id_title);
                    }
                }
            }
        } else {
            //Si c'est une modification
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->quoteName(array('level')));
            $query->from($db->quoteName('#__chartiib_hierarchy'));
            $query->where("id = $current_id");

            $db->setQuery($query);
            $results = $db->loadObject();

            if (!is_null($results)) {
                $levels = json_decode($results->level);
                $list_posts_saved = $levels->list_posts;
                $list_posts_high_saved = $levels->list_posts_high;
                $posts_on_level = count($levels->list_posts);
            }

            // --------- Valeurs disponibles pour les postes hiérarchiques supérieurs -------------
            $list_posts_high = array("" => array("id" => "", "title" => ""));
            if (!is_null($results)) {
                $list_posts_saved = $levels->list_posts;
                $list_posts_high_saved = $levels->list_posts_high;
                $posts_on_level = count($levels->list_posts);
                $levels = json_decode($results->level);
                $posts_previous = $levels->list_posts_high;
                foreach ($posts_previous as $value) {
                    if ($value != "") {
                        $tab_id_title = array("id" => $value, "title" => $correspondances[$value]);
                        array_push($list_posts_high, $tab_id_title);
                    }
                }
            }
        }
        
        $generalOptions = array();
        array_push($generalOptions, $list_posts);
        array_push($generalOptions, $list_posts_high);
        array_push($generalOptions, $list_posts_saved);
        array_push($generalOptions, $list_posts_high_saved);
        array_push($generalOptions, $posts_on_level);

        return $generalOptions;
    }

}
