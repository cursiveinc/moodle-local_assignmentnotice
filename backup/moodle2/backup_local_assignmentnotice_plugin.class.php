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
 * Backup implementation for local_assignmentnotice.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Backup plugin class for local_assignmentnotice.
 *
 * Provides backup functionality for AI Assessment Scale settings
 * attached to assignment activities.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_local_assignmentnotice_plugin extends backup_local_plugin {
    /**
     * Define the plugin structure for backup.
     *
     * @return backup_plugin_element The plugin element
     */
    protected function define_module_plugin_structure() {
        // Define the plugin element.
        $plugin = $this->get_plugin_element();

        // Create wrapper element.
        $wrapper = new backup_nested_element('assignmentnotice_settings');

        // Define the source table and fields.
        $settings = new backup_nested_element(
            'setting',
            ['id'],
            ['aiaslevel', 'bannertype', 'timecreated', 'timemodified']
        );

        // Build the tree.
        $plugin->add_child($wrapper);
        $wrapper->add_child($settings);

        // Set source - only backup if this is an assign module.
        $settings->set_source_table(
            'local_assignmentnotice',
            ['assignmentid' => backup::VAR_PARENTID]
        );

        return $plugin;
    }
}
