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

 require_once($CFG->libdir . "/externallib.php");
 require_once($CFG->dirroot . "/local/marksheet/locallib.php");

 class local_marksheet_external extends external_api {
     
    public static function delete_mark_by_id_parameters(): external_function_parameters {
        return new external_function_parameters(
            array(
                'markid' => new external_value(PARAM_INT, 'mark id'),
            )
        );
    }

    public static function delete_mark_by_id(int $markid): array {
        global $DB;

        $warnings = array();

        local_marksheet_delete_record($markid);

        return array(
            'markid' => $markid,
            'warnings' => $warnings
        );

    }

    public static function delete_mark_by_id_returns() {
        return new external_single_structure(
            array(
                'markid' => new external_value(PARAM_INT, 'mark id'),
                'message' => new external_value(PARAM_TEXT, 'success message'),
                'warnings' => new external_warnings()
            )
        );
    }
 }