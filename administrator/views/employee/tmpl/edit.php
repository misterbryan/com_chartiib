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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_chartiib/assets/css/chartiib.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {

    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'employee.cancel') {
            Joomla.submitform(task, document.getElementById('employee-form'));
        }
        else {

            

            if (task != 'employee.cancel' && document.formvalidator.isValid(document.id('employee-form'))) {

                Joomla.submitform(task, document.getElementById('employee-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_chartiib&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="employee-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CHARTIIB_TITLE_EMPLOYEE', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
                    <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
                    <input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
                    <input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
                    <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

                    <?php if (empty($this->item->created_by)) { ?>
                        <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

                    <?php } else {
                        ?>
                        <input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

                    <?php } ?>
                    	<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
	<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
	</div>
	<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
	<div class="controls"><?php echo $this->form->getInput('address'); ?></div>
	</div>
	<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('age'); ?></div>
	<div class="controls"><?php echo $this->form->getInput('age'); ?></div>
	</div>
	<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('notes'); ?></div>
	<div class="controls"><?php echo $this->form->getInput('notes'); ?></div>
	</div>
	<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('photo'); ?></div>
	<div class="controls"><?php echo $this->form->getInput('photo'); ?></div>
	</div>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
      
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>