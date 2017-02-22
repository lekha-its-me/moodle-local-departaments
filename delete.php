<?php
/**
 * Example Moodle script version information.
 *
 * @package   local_departaments
 * @copyright 2017 lekha
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$id = optional_param('id', 0, PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_INT);
$heading = 'Удаление подразделения';
$site = get_site();
$PAGE->set_url('/local/departaments/view_form.php?depid='.  $id);
$PAGE->set_heading($heading);
echo $OUTPUT->header();

if (!$dep = $DB->get_record('local_departaments', array('id' => $id))) {
    print_error('invalidcourse', 'local_departaments', $id);
}

//require_login($dep);

if(! $simplehtmlpage = $DB->get_record('local_departaments', array('id' => $id))) {
    print_error('nopage', 'local_departaments', '', $id);
}


if (!$confirm) {
    $optionsno = new moodle_url('/local/departaments/index.php', array('id' => $id));
    $optionsyes = new moodle_url('/local/departaments/delete.php', array('id' => $id, 'confirm' => 1, 'sesskey' => sesskey()));
    $message = 'Удалить подразделение: '. $simplehtmlpage->title. '?';
    echo $OUTPUT->confirm($message, $optionsyes, $optionsno);
} else {
    if (confirm_sesskey()) {
        if (!$DB->delete_records('local_departaments', array('id' => $id))) {
            print_error('deleteerror', 'local_departaments');
        }
    } else {
        print_error('sessionerror', 'local_departaments');
    }
    $url = new moodle_url('/local/departaments/index.php', array('id' => $depid));
    redirect($url);
}

echo $OUTPUT->footer();