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

    foreach($marks as $mark) {
        array_push($totalMarks, $mark->cq_mark + $mark->mcq_mark);
    }

    // Data to be passed in the manage template.
    $templatecontext = (object) [
        'texttodisplay' => array_values($marks),
        'editurl' => new moodle_url('/local/marksheet/edit.php'),
    ];

    echo $OUTPUT->render_from_template('local_marksheet/manage', $templatecontext);
}