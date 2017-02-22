<?php
/**
 * Created by PhpStorm.
 * User: lekha
 * Date: 17.02.17
 * Time: 14:35
 */
require_login();
function display_add_form($form, $return = false) {
    global $OUTPUT;

    $display = $OUTPUT->heading();
    $display .= $OUTPUT->box_start();
    $display .= $OUTPUT->box_end();
    $display .= $OUTPUT->footer();

    if($return) {
        return $display;
    } else {
        echo $display;
    }

}

function local_departaments_extend_navigation(global_navigation $navigation) {
    $settings = get_config('local_navigation');
    if (!empty($settings->menuitems) && $settings->enabled) {
        $menu = new custom_menu($settings->menuitems, current_language());
        if ($menu->has_children()) {
            foreach ($menu->get_children() as $item) {
                navigation_custom_menu_item($item, 0, null);
            }
        }
    }
}

/**
 * ADD custom menu in navigation recursive childs node
 * Is like render custom menu items
 *
 * @param object $navigation global_navigation
 * @param int $parent is have a parent and it's parent itself
 * @param object $pmasternode parent node
 * @return void
 */
function departaments_custom_menu_item(custom_menu_item $menunode, $parent, $pmasternode) {
    global $PAGE, $CFG;

    static $submenucount = 0;

    if ($menunode->has_children()) {
        $submenucount++;
        $url = $CFG->wwwroot;
        if ($menunode->get_url() !== null) {
            $url = new moodle_url($menunode->get_url());
        } else {
            $url = null;
        }
        if ($parent > 0) {
            $masternode = $pmasternode->add(local_departaments_get_string($menunode->get_text()), $url, navigation_node::TYPE_CONTAINER);
            $masternode->title($menunode->get_title());
        } else {
            $masternode = $PAGE->navigation->add(local_departaments_get_string($menunode->get_text()), $url, navigation_node::TYPE_CONTAINER);
            $masternode->title($menunode->get_title());
        }
        foreach ($menunode->get_children() as $menunode) {
            departaments_custom_menu_item($menunode, $submenucount, $masternode);
        }
    } else {
        $url = $CFG->wwwroot;
        if ($menunode->get_url() !== null) {
            $url = new moodle_url($menunode->get_url());
        } else {
            $url = null;
        }
        if ($parent) {
            $childnode = $pmasternode->add(local_departaments_get_string($menunode->get_text()), $url, navigation_node::TYPE_CUSTOM);
            $childnode->title($menunode->get_title());
        } else {
            $masternode = $PAGE->navigation->add(local_departaments_get_string($menunode->get_text()), $url, navigation_node::TYPE_CONTAINER);
            $masternode->title($menunode->get_title());
        }
    }

    return true;
}

/**
 * Translate Custom Navigation Nodes
 *
 * This function is based in a short peace of Moodle code
 * in  Name processing on user_convert_text_to_menu_items.
 *
 * @param string $string text to translate.
 * @return string
 */
function local_departaments_get_string($string) {
    $title = $string;
    $text = explode(',', $string, 2);
    if (count($text) == 2) {
        // Check the validity of the identifier part of the string.
        if (clean_param($text[0], PARAM_STRINGID) !== '') {
            // Treat this as atext language string.
            $title = get_string($text[0], $text[1]);
        }
    }
    return $title;
}
?>