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
 * Restore implementation for local_assignmentnotice.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Restore plugin class for local_assignmentnotice.
 *
 * Provides restore functionality for AI Assessment Scale settings
 * attached to assignment activities.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_local_assignmentnotice_plugin extends restore_local_plugin {
    /**
     * Define the plugin structure for restore.
     *
     * @return array The restore path elements
     */
    protected function define_module_plugin_structure() {
        $paths = [];

        $paths[] = new restore_path_element(
            'local_assignmentnotice_setting',
            $this->get_pathfor('/assignmentnotice_settings/setting')
        );

        return $paths;
    }

    /**
     * Process a single setting restore.
     *
     * @param array $data The data from backup
     */
    public function process_local_assignmentnotice_setting($data) {
        global $DB;

        $data = (object) $data;

        // Get the new assignment ID from the restore task.
        $data->assignmentid = $this->task->get_activityid();

        // Update timestamps.
        $data->timecreated = time();
        $data->timemodified = time();

        // Remove old ID.
        unset($data->id);

        // Check if a record already exists for this assignment (in case of duplicate restore).
        $existing = $DB->get_record('local_assignmentnotice', ['assignmentid' => $data->assignmentid]);
        if ($existing) {
            $data->id = $existing->id;
            $DB->update_record('local_assignmentnotice', $data);
        } else {
            $DB->insert_record('local_assignmentnotice', $data);
        }
    }
}
