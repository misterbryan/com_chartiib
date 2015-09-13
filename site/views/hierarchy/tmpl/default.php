<?php
/**
 * @version     1.0.0
 * @package     com_chartiib
 * @copyright   Copyright (C). Tous droits réservés.
 * @license     GNU/GPL version 2 ou version ultérieure
 * @author      Briand Idossou <idossoubr@yahoo.fr> - http://ibrini.com
 */
// no direct access
defined('_JEXEC') or die;

JFactory::getDocument()->addStyleSheet(JUri::base() . "components/com_chartiib/assets/css/chartiib.css");

if ($this->employee) :
    ?>
    <div class="employee_fields">
        <table class="table">
            <tr>
                <th><?php echo JText::_('COM_CHARTIIB_EMPLOYEES_NAME'); ?></th>
                <td><?php echo $this->employee->name; ?></td>
            </tr>
            <?php if (isset($this->employee->photo) AND $this->employee->photo != "") { ?>
                <tr>
                    <th><?php echo JText::_('COM_CHARTIIB_EMPLOYEES_PHOTO'); ?></th>
                    <td><img class="photo_iib" src="<?php echo JURI::root() . $this->employee->photo; ?>" alt="" /></td>
                </tr>
            <?php } ?>
            <?php if (isset($this->employee->age) AND $this->employee->age != "") { ?>
                <tr>
                    <th><?php echo JText::_('COM_CHARTIIB_EMPLOYEES_AGE'); ?></th>
                    <td><?php echo $this->employee->age; ?></td>
            </tr>
            <?php } ?>
            <?php if (isset($this->employee->address) AND $this->employee->address != "") { ?>
                <tr>
                    <th><?php echo JText::_('COM_CHARTIIB_EMPLOYEES_ADDRESS'); ?></th>
                    <td><?php echo $this->employee->address; ?></td>
            </tr>
            <?php } ?>
            <?php if (isset($this->employee->notes) AND $this->employee->notes != "") { ?>
                <tr>
                    <th><?php echo JText::_('COM_CHARTIIB_EMPLOYEES_NOTES'); ?></th>
                    <td><?php echo $this->employee->notes; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <?php
else:
    echo JText::_('COM_CHARTIIB_ITEM_NOT_LOADED');
endif;