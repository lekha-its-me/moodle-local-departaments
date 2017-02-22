<?php

/**
 * Example Moodle script version information.
 *
 * @package   local_departaments
 * @copyright 2017 lekha
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('add_form.php');

global $DB, $OUTPUT, $PAGE;

// Check for all required variables.
$depid = optional_param('depid','', PARAM_INT);


//if (!$local_greet = $DB->get_record('local_greet', array('id' => $depid))) {
//    print_error('invalidcourse', 'local_greet', $depid);
//}

//require_login($local_greet);

$PAGE->set_url('/local/departaments/view_form.php', array('id' => $depid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('edithtml', 'local_departaments'));

$simplehtml = new add_form();
$index = new moodle_url('/local/departaments/index.php');

$toform['id'] = $depid;

echo $OUTPUT->header();

//if($simplehtml->is_cancelled()) {
//
//} else if ($fromform = $simplehtml->get_data()) {
//
//var_dump($fromform);
//    if ($fromform->depid != 0) {
//        if (!$DB->update_record('local_greet', $fromform)) {
//            print_error('updateerror', 'local_greet');
//        }
//    } else {
//        if (!$DB->insert_record('local_greet', $fromform)) {
//            print_error('inserterror', 'local_greet');
//        }
//    }
//
//
//
//} else {
//    // form didn't validate or this is the first display
//    $site = get_site();
//    if ($depid) {
//        $simplehtmlpage = $DB->get_record('local_greet', array('id' => $depid));
//            $simplehtml->set_data($simplehtmlpage);
//            $simplehtml->display();
//
//    } else {
//        $simplehtml->display();
//    }
//    echo $OUTPUT->footer();
//}

if($depid)
{
    $simplehtmlpage = $DB->get_record('local_departaments', array('id' => $depid));
            $simplehtml->set_data($simplehtmlpage);
    echo html_writer::start_tag('a', array('class'=>'btn btn-danger', 'href'=> new moodle_url("/local/departaments/delete.php?id=".$depid)));
    echo 'Удалить подразделение';
    echo html_writer::end_tag('a');
            $simplehtml->display();
}
elseif ($fromform = $simplehtml->get_data()){

    if ($fromform->id != 0) {
        echo 'updating';
        if (!$DB->update_record('local_departaments', $fromform)) {
            print_error('updateerror', 'local_departaments');
        }
    } else {
        echo 'inserting';
        if (!$DB->insert_record('local_departaments', $fromform)) {
            print_error('inserterror', 'local_departaments');
        }
    }
    redirect($index);

}
else {
    $PAGE->set_heading('Добавить новое подразделение');
    $simplehtml->display();
}

//if($editPage = $DB->get_records('local_greet', array('id' => $depid))){
//    $simplehtml->set_data($editPage);
//    $simplehtml->display();
//}
//$simplehtml->display();
echo $OUTPUT->footer();

?>