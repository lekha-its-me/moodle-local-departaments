<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Example Moodle script version information.
 *
 * You can create structure of departments, include basic CRUD
 *
 * @package   local_departaments
 * @copyright 2017 lekha
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');

global $DB;
//$select_parent = "parent_id <=> null";
$select_parent = "parent_id = 0";
//$select = "parent_id !=''";
$parent = $DB->get_records_select('local_departaments', $select_parent);
//$shops = $DB->get_records_select('local_greet', $select);
//var_dump($shops);


function getTree($id){
    global $DB, $OUTPUT, $some;
        $select_child = 'parent_id ='. $id;
        $child = $DB->get_records_select('local_departaments', $select_child);

        $some.=html_writer::start_tag('ul');
        foreach ($child as $item){
            $url = new moodle_url('/local/departaments/view_form.php', array('depid' => $item->id));
            $some.= html_writer::link($url, html_writer::tag('li', $item->title));
            //echo $OUTPUT->box($item->title);
            getTree($item->id);
    }
    $some.=html_writer::end_tag('ul');
    return $some;
}


require_login();
$context = context_system::instance();
//require_capability('local/greet:begreeted', $context);
//
//$name = optional_param('name', '', PARAM_TEXT);
//if (!$name) {
//    $name = fullname($USER);
//}
//
//add_to_log(SITEID, 'local_greet', 'begreeted',
//        'local/greet/index.php?name=' . urlencode($name));

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/departaments/index.php')/*,
        array('name' => $name)*/);
$PAGE->set_title(get_string('welcome', 'local_departaments'));
$PAGE->set_heading('Подразделения Компании');

echo $OUTPUT->header();
//echo $OUTPUT->box(get_string('greet', 'local_greet',
//        format_string($name)));


echo html_writer::start_tag('a', array('class'=>'btn btn-primary', 'href'=> new moodle_url("/local/departaments/view_form.php")));
echo 'Создать подразделение';
echo html_writer::end_tag('a');

foreach ($parent as $i)
{
    echo $OUTPUT->box(getTree(1));
}

echo $OUTPUT->footer();
