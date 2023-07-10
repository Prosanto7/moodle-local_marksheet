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


//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit_form extends moodleform {

    protected $data;

    /**
     * Constructor.
     */
    public function __construct($actionurl, $data = null) {
        $this->data = $data;
        parent::__construct($actionurl);
    }

    //Add elements to form
    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('hidden', 'id', get_string('id', 'local_marksheet'));
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $this->data->id ?? "");

        $mform->addElement('text', 'subject_name', get_string('subject_name', 'local_marksheet'));
        $mform->setType('subject_name', PARAM_TEXT);
        $mform->setDefault('subject_name', $this->data->subject_name ?? "");

        $mform->addElement('text', 'cq_mark', get_string('cq_mark', 'local_marksheet'));
        $mform->setType('cq_mark', PARAM_INT);
        $mform->setDefault('cq_mark', $this->data->cq_mark ?? "");

        $mform->addElement('text', 'mcq_mark', get_string('mcq_mark', 'local_marksheet'));
        $mform->setType('mcq_mark', PARAM_INT);
        $mform->setDefault('mcq_mark', $this->data->mcq_mark ?? "");

        $this->add_action_buttons();
    }
}