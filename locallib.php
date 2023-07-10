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
 * Version information
 *
 * @package    local_marksheet
 * @copyright  2023, Prosanto Deb <prosanto.deb@brainstation-23.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 function local_marksheet_display_marks() {
    global $DB, $OUTPUT;
    $marks = $DB->get_records('local_marksheet');

    $sumCQ = 0;
    $sumMCQ = 0;
    $sumTotal = 0;

    foreach($marks as $mark) {
        $mark->total = $mark->cq_mark + $mark->mcq_mark;
        $sumCQ += $mark->cq_mark;
        $sumMCQ += $mark->mcq_mark;
        $sumTotal += $mark->total;
    }

    // Data to be passed in the manage template.
    $templatecontext = (object) [
        'texttodisplay' => array_values($marks),
        'avgCQ' => ($sumCQ / count($marks)),
        'avgMCQ' => ($sumMCQ / count($marks)),
        'avgTotal' => ($sumTotal / count($marks)),
        'editurl' => new moodle_url('/local/marksheet/edit.php'),
        'deleteurl' => new moodle_url('/local/marksheet/delete.php'),
    ];

    echo $OUTPUT->render_from_template('local_marksheet/manage', $templatecontext);
}

function local_marksheet_init_form(int $id = null): edit_form {
    global $DB;

    $actionurl = new moodle_url('/local/marksheet/edit.php');

    if ($id) {
        $mark = $DB->get_record('local_marksheet', array('id' => $id));
        $mform = new edit_form($actionurl, $mark);
    } else {
        $mform = new edit_form($actionurl);
    }
    return $mform;
}

function local_marksheet_edit_record(edit_form $mform, int $id = null) {

    global $DB;
    
    if ($mform->is_cancelled()) {
        //Back to manage.php
        redirect(new moodle_url('/local/marksheet/manage.php'), get_string('cancel_form', 'local_marksheet'));
    } else if (!$mform->is_validated()) {
        //$mform->addElementError('cq_mark', 'Name is required');
    }
    else if ($fromform = $mform->get_data()) {
        // Handing the form data.
        $recordstoinsert = new stdClass();
        $recordstoinsert->subject_name = $fromform->subject_name;
        $recordstoinsert->cq_mark = $fromform->cq_mark;
        $recordstoinsert->mcq_mark = $fromform->mcq_mark;

        if ($fromform->id) {
            // Update the record.
            $recordstoinsert->id = $fromform->id;
            $DB->update_record('local_marksheet', $recordstoinsert);
            // Go back to manage page.
            redirect(new moodle_url('/local/marksheet/manage.php'), get_string('updatethanks', 'local_marksheet'));

        } else {
            // Insert the record.
            $DB->insert_record('local_marksheet', $recordstoinsert);
            // Go back to manage page.
            redirect(new moodle_url('/local/marksheet/manage.php'), get_string('insertthanks', 'local_marksheet'));
        }
    } 
}

function local_marksheet_delete_record($id) {
    global $DB;
    try {
        // Delete the record.
        $DB->delete_records('local_marksheet', array('id' => $id));

        // Go back to manage page.
        redirect(new moodle_url('/local/marksheet/manage.php'), get_string('deletemessage', 'local_marksheet'));
    } catch (Exception $exception) {
        throw new moodle_exception($exception);
    }
}