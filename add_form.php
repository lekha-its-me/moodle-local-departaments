<?php
/**
 * Created by PhpStorm.
 * User: lekha
 * Date: 17.02.17
 * Time: 14:06
 */
require_once("{$CFG->libdir}/formslib.php");

class add_form extends moodleform {

    function definition() {

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('name', 'local_departaments'));

//        $mform->addElement('text', 'id', get_string('id', 'local_greet'));
//        $mform->setType('id', PARAM_RAW);
//        $mform->disabledIf('id', 'id', 'eq', 3);
//        $mform->addRule('title', null, 'required', null, 'title');

        $mform->addElement('text', 'title', get_string('title', 'local_departaments'));
        $mform->setType('title', PARAM_RAW);

        $mform->addElement('text', 'parent_id', get_string('parent_id', 'local_departaments'));
        $mform->setType('parent_id', PARAM_RAW);
        //$mform->addRule('pagetitle', null, 'required', null, 'parent_id');

        $mform->addElement('date_selector', 'created_at', get_string('created_at', 'local_departaments'));
        $mform->setType('created_at', PARAM_RAW);
        //$mform->addRule('pagetitle', null, 'required', null, 'created_at');

        $mform->addElement('checkbox', 'is_actual', get_string('is_actual', 'local_departaments'));
        $mform->setType('is_actual', PARAM_RAW);

        $mform->addElement('hidden', 'id');
        $mform->addElement('hidden', 'depid');


        $this->add_action_buttons();
    }
}