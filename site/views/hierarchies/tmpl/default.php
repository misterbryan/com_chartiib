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
//JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.framework');
$doc = JFactory::getDocument();

$app = JFactory::getApplication();

$doc->addCustomTag('<script src="' . JURI::root(true) . '/components/com_chartiib/assets/orgchart/jquery.orgchart.min.js" type="text/javascript"></script>');
$doc->addCustomTag('<script src="' . JURI::root(true) . '/components/com_chartiib/assets/orgchart/initiate.js" type="text/javascript"></script>');

$doc->addStyleSheet('components/com_chartiib/assets/orgchart/jquery.orgchart.css');


$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');

$doc->addStyleSheet(JUri::base() . "components/com_chartiib/assets/css/chartiib.css");


$items = $this->items;
//Mettre la liste des employés dans un format facilement utilisable
$employees = $this->employees;
$infos_employees = array();
foreach ($employees as $employee) {
    $infos_employees[$employee->id] = $employee;
}
//Mettre la liste des postes dans un format facilement utilisable
$posts = $this->posts;
$infos_posts = array();
foreach ($posts as $post) {
    $infos_posts[$post->id] = $post;
}
//Mettre la liste des relations dans un format facilement utilisable
$relations = $this->relations;
$posts_employees = array();
foreach ($relations as $relation) {
    $posts_employees[$relation->id_post] = $relation->id_employee;
}

?>

<div id="level_0" style="display: none"></div>
<?php
$i = 0;
foreach ($items as $item) {
    $level = json_decode($item->level);
    $list_posts = $level->list_posts;
    $list_posts_high = $level->list_posts_high;
    $list_posts_high_unique = array_unique($list_posts_high);

    if ($i == 0) {
        //Récupérer la position du poste correspondant
        $position = $list_posts[0];
        ?>
        <script>
            jQuery("div#level_0").append('<ul id="organisation_iib"><a href="<?php echo JRoute::_('index.php?option=com_chartiib&view=hierarchy&id=' . $posts_employees[$position]); ?>" title="Voir la fiche"><li id="element_<?php echo $position; ?>"><?php echo $infos_employees[$posts_employees[$position]]->name; ?></a><br/><span class="title"><?php echo $infos_posts[$position]->title; ?></span></li></ul>');
        </script>

        <?php
    } else {
        foreach ($list_posts_high_unique as $post_high_unique) {
            $start_append = 'jQuery("li#element_' . $post_high_unique . '").append(\'<ul>';
            $j = 0;
            $add_append = "";
            foreach ($list_posts as $post) {
                if ($list_posts_high[$j] == $post_high_unique) {
                    $add_append .= '<li id="element_' . $post . '"><a href="' . JRoute::_('index.php?option=com_chartiib&view=hierarchy&id=' . $posts_employees[$post]) . '" title="' . JText::_("COM_CHARTIIB_CHART_DETAILS") . '">' . $infos_employees[$posts_employees[$post]]->name . '</a><br/><span class="title">' . $infos_posts[$post]->title . '</span></li>';
                }
                $j++;
            }
            $end_append = '</ul>\');';
            $append = $start_append . $add_append . $end_append;
            ?>
            <script>
            <?php echo $append; ?>
            </script>
            <?php
        }
    }
    $i++;
}
?>

<div id="content">
    <h3><?php echo JText::_("COM_CHARTIIB_CHART"); ?></h3>
    <div id="main" class="row"></div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.delete-button').click(deleteItem);
    });

    function deleteItem() {
        var item_id = jQuery(this).attr('data-item-id');
        if (confirm("<?php echo JText::_('COM_CHARTIIB_DELETE_MESSAGE'); ?>")) {
            window.location.href = '<?php echo JRoute::_('index.php?option=com_chartiib&task=hierarchyform.remove&id=', false, 2) ?>' + item_id;
        }
    }
</script>


