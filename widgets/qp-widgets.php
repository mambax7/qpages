<?php
// $Id$
// --------------------------------------------------------------
// Quick Pages
// Create simple pages easily and quickly
// Author: Eduardo Cortes <i.bitcero@gmail.com>
// Email: i.bitcero@gmail.com
// License: GPL 2.0
// --------------------------------------------------------------

/**
 * Widget that shows the basic page options
 */
function qp_widget_basic($page){
    global $rmTpl, $xoopsConfig, $rmEvents;

    $widget['title'] = '<i class="icon-check"></i> '.__('Page Basic Options','qpages');

	// Get available templates for squeeze templates
	$paths = array(
		QP_PATH.'/templates/custom',
		XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/modules/qpages/custom'
	);

	$paths = $rmEvents->run_event('qpages.get.templates.paths', $paths);

	$pages_templates = QPFunctions::getTemplates( $paths );

    ob_start();
    include $rmTpl->get_template("widgets/qp-widget-basic.php", 'module', 'qpages');
    $widget['content'] = ob_get_clean();

    return $widget;

}

/**
 * Visualization and permissions
 */
function qp_widget_visualization($page){
    global $rmTpl;

    $widget['title'] = '<i class="icon-eye-open"></i> '.__('Visualization','qpages');

    $groups = new RMFormGroups(__('Allowed groups','qpages'), 'groups', 1, 1, 3, !$page->isNew() ? $page->getVar('groups') : array(0));

    $cats = array();
    QPFunctions::categoriesTree($cats);

    ob_start();
    include $rmTpl->get_template("widgets/qp-widget-view.php", 'module', 'qpages');
    $widget['content'] = ob_get_clean();

    return $widget;

}

/**
 * Provides a widget to specify the default image for page
 */
function qp_widget_image( $page ){
    global $xoopsSecurity, $xoopsModuleConfig, $xoopsUser, $rm_config;

    $widget = array();
    $widget['title'] = __('Featured Image','qpages');
    $util = new RMUtilities();

    if ( isset($post) && is_a( $post, 'QPPage' ) ){

        if ($post->isNew())
            $params = '';
        else
            $params = $page->getVar('image','e');

    } else {
        $params = '';
    }

    $widget['content'] = '<form name="frmDefimage" id="frm-defimage" method="post">';
    $widget['content'] .= $util->image_manager('image', 'image', $params);
    $widget['content'] .= '</form>';
    return $widget;

}