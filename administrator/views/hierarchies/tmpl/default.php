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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_chartiib/assets/css/chartiib.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$saveOrder = $listOrder == 'a.ordering';
if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_chartiib&task=hierarchies.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'hierarchyList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

//Mettre la liste des postes dans un format facilement utilisable
$posts = $this->posts;
$infos_posts = array();
foreach ($posts as $post) {
    $infos_posts[$post->id] = $post;
}
?>
<script type="text/javascript">
    Joomla.orderTable = function() {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }

    jQuery(document).ready(function() {
        jQuery('#clear-search-button').on('click', function() {
            jQuery('#filter_search').val('');
            jQuery('#adminForm').submit();
        });
    });
</script>

<?php
//Joomla Component Creator code to allow adding non select list filters
if (!empty($this->extra_sidebar)) {
    $this->sidebar .= $this->extra_sidebar;
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_chartiib&view=hierarchies'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)): ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
            <div id="j-main-container">
            <?php endif; ?>

            <div id="filter-bar" class="btn-toolbar">
                
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                    <?php echo $this->pagination->getLimitBox(); ?>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                    <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                        <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                        <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                    </select>
                </div>
                <div class="btn-group pull-right">
                    <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                    <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                        <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
                    </select>
                </div>
            </div>        
            <div class="clearfix"> </div>
            <table class="table table-striped" id="hierarchyList">
                <thead>
                    <tr>
                        <?php if (isset($this->items[0]->ordering)): ?>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
                            </th>
                        <?php endif; ?>
                        <th width="1%" class="hidden-phone">
                            <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                        </th>

                        <th class='left'>
                            <?php echo JText::_('COM_CHARTIIB_HIERARCHIES_LEVEL'); ?>
                        </th>
                        <th class='left'>
                            <?php echo JText::_('COM_CHARTIIB_HIERARCHIES_HIERARCHY'); ?>
                        </th>


                        <?php if (isset($this->items[0]->id)): ?>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tfoot>
                    <?php
                    if (isset($this->items[0])) {
                        $colspan = count(get_object_vars($this->items[0]));
                    } else {
                        $colspan = 10;
                    }
                    ?>
                    <tr>
                        <td colspan="<?php echo $colspan ?>">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    foreach ($this->items as $i => $item) :
                        $ordering = ($listOrder == 'a.ordering');
                        ?>
                        <tr class="row<?php echo $i % 2; ?>">

                            <?php if (isset($this->items[0]->ordering)): ?>
                                <td class="order nowrap center hidden-phone">
                                    <?php
                                    $disableClassName = '';
                                    $disabledLabel = '';
                                    if (!$saveOrder) :
                                        $disabledLabel = JText::_('JORDERINGDISABLED');
                                        $disableClassName = 'inactive tip-top';
                                    endif;
                                    ?>
                                    <span class="sortable-handler hasTooltip <?php echo $disableClassName ?>" title="<?php echo $disabledLabel ?>">
                                        <i class="icon-menu"></i>
                                    </span>
                                    <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />

                                </td>
                            <?php endif; ?>
                            <td class="hidden-phone">
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>

                            <td class="">
                                <?php echo $i + 1; ?>
                            </td>

                            <td>
                                <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                                    <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'hierarchies'); ?>
                                <?php endif; ?>
                                <?php
                                $level = json_decode($item->level);
                                $list_posts = $level->list_posts;
                                $list_posts_high = $level->list_posts_high;
                                $nbre_posts = count($list_posts);
                                for ($j = 0; $j < $nbre_posts; $j++) {
                                    if (isset($infos_posts[$list_posts_high[$j]]) AND $infos_posts[$list_posts_high[$j]] != "") {
                                        echo $infos_posts[$list_posts_high[$j]]->title . " >> " . $infos_posts[$list_posts[$j]]->title . "<br/>";
                                    } else {
                                        echo $infos_posts[$list_posts[$j]]->title . "<br/>";
                                    }
                                }
//                                        var_dump($this->posts); 
//                                        var_dump($infos_posts); 
//                                        var_dump($list_posts); 
//                                        var_dump($list_posts_high); 
//                                        var_dump($level); 
                                ?>
                            </td>


                                <?php if (isset($this->items[0]->id)): ?>
                                <td class="center hidden-phone">
                                <?php echo (int) $item->id; ?>
                                </td>
                        <?php endif; ?>
                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
        </div>
</form>        


