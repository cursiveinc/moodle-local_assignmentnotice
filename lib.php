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
 * Library functions for local_assignmentnotice.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Add fields to the assignment settings form.
 *
 * @param moodleform $formwrapper The moodle form wrapper
 * @param MoodleQuickForm $mform The actual form
 */
function local_assignmentnotice_coursemodule_standard_elements($formwrapper, $mform) {
    global $DB;

    // Only add to assignment module.
    $modulename = $formwrapper->get_current()->modulename ?? '';
    if ($modulename !== 'assign') {
        return;
    }

    // Check capability.
    $context = $formwrapper->get_context();
    if (!has_capability('local/assignmentnotice:configure', $context)) {
        return;
    }

    // Add header.
    $mform->addElement(
        'header',
        'assignmentnotice_header',
        get_string('assignmentnotice_header', 'local_assignmentnotice')
    );

    // AI Assessment Scale level dropdown.
    $aiasoptions = [
        0 => get_string('aias_none', 'local_assignmentnotice'),
        1 => get_string('aias_level1', 'local_assignmentnotice'),
        2 => get_string('aias_level2', 'local_assignmentnotice'),
        3 => get_string('aias_level3', 'local_assignmentnotice'),
        4 => get_string('aias_level4', 'local_assignmentnotice'),
        5 => get_string('aias_level5', 'local_assignmentnotice'),
    ];
    $mform->addElement(
        'select',
        'assignmentnotice_aiaslevel',
        get_string('aiaslevel', 'local_assignmentnotice'),
        $aiasoptions
    );
    $mform->setDefault('assignmentnotice_aiaslevel', 0);
    $mform->addHelpButton('assignmentnotice_aiaslevel', 'aiaslevel', 'local_assignmentnotice');

    // Banner type dropdown.
    $banneroptions = [
        'info' => get_string('bannertype_info', 'local_assignmentnotice'),
        'warning' => get_string('bannertype_warning', 'local_assignmentnotice'),
        'success' => get_string('bannertype_success', 'local_assignmentnotice'),
        'danger' => get_string('bannertype_danger', 'local_assignmentnotice'),
    ];
    $mform->addElement(
        'select',
        'assignmentnotice_bannertype',
        get_string('bannertype', 'local_assignmentnotice'),
        $banneroptions
    );
    $mform->setDefault('assignmentnotice_bannertype', 'info');
    $mform->addHelpButton('assignmentnotice_bannertype', 'bannertype', 'local_assignmentnotice');

    // Hide banner type if no AIAS level selected.
    $mform->hideIf('assignmentnotice_bannertype', 'assignmentnotice_aiaslevel', 'eq', 0);

    // Load existing data if editing.
    $cmid = $formwrapper->get_current()->coursemodule ?? 0;
    if ($cmid) {
        $cm = get_coursemodule_from_id('assign', $cmid);
        if ($cm) {
            $record = $DB->get_record('local_assignmentnotice', ['assignmentid' => $cm->instance]);
            if ($record) {
                $mform->setDefault('assignmentnotice_aiaslevel', $record->aiaslevel);
                $mform->setDefault('assignmentnotice_bannertype', $record->bannertype);
            }
        }
    }
}

/**
 * Process data from the assignment settings form.
 *
 * @param stdClass $data The form data
 * @param stdClass $course The course object
 * @return stdClass The form data
 */
function local_assignmentnotice_coursemodule_edit_post_actions($data, $course) {
    global $DB;

    // Only process for assignment module.
    if (!isset($data->modulename) || $data->modulename !== 'assign') {
        return $data;
    }

    // Get the assignment instance ID.
    $cmid = $data->coursemodule;
    $cm = get_coursemodule_from_id('assign', $cmid);
    if (!$cm) {
        return $data;
    }

    $assignmentid = $cm->instance;
    $aiaslevel = $data->assignmentnotice_aiaslevel ?? 0;
    $bannertype = $data->assignmentnotice_bannertype ?? 'info';

    // Get existing record.
    $existing = $DB->get_record('local_assignmentnotice', ['assignmentid' => $assignmentid]);

    if ($aiaslevel == 0) {
        // If no level selected, delete any existing record.
        if ($existing) {
            $DB->delete_records('local_assignmentnotice', ['id' => $existing->id]);
        }
    } else {
        $now = time();
        if ($existing) {
            // Update existing record.
            $existing->aiaslevel = $aiaslevel;
            $existing->bannertype = $bannertype;
            $existing->timemodified = $now;
            $DB->update_record('local_assignmentnotice', $existing);
        } else {
            // Insert new record.
            $record = new stdClass();
            $record->assignmentid = $assignmentid;
            $record->aiaslevel = $aiaslevel;
            $record->bannertype = $bannertype;
            $record->timecreated = $now;
            $record->timemodified = $now;
            $DB->insert_record('local_assignmentnotice', $record);
        }
    }

    return $data;
}

/**
 * Inject the banner on assignment pages.
 *
 * This is called on every page and we check if we're on an assignment page.
 *
 * @return string HTML to inject before footer
 */
function local_assignmentnotice_before_footer() {
    global $PAGE, $DB, $OUTPUT;

    // Check if we're on an assignment page.
    if ($PAGE->context->contextlevel !== CONTEXT_MODULE) {
        return '';
    }

    $cm = $PAGE->cm;
    if (!$cm || $cm->modname !== 'assign') {
        return '';
    }

    // Only show to users who can view but NOT configure (i.e., students only).
    // Teachers who can configure the notice don't need to see it.
    if (!has_capability('local/assignmentnotice:view', $PAGE->context)) {
        return '';
    }
    if (has_capability('local/assignmentnotice:configure', $PAGE->context)) {
        return '';
    }

    // Get the notice settings for this assignment.
    $record = $DB->get_record('local_assignmentnotice', ['assignmentid' => $cm->instance]);
    if (!$record || $record->aiaslevel == 0) {
        return '';
    }

    // Create the renderable and render it using the Output API.
    $banner = new \local_assignmentnotice\output\banner(
        (int) $record->aiaslevel,
        $record->bannertype
    );

    // Render using the Output API - the named_templatable interface
    // tells Moodle which template to use automatically.
    return $OUTPUT->render($banner);
}

/**
 * Get the notice data for an assignment.
 *
 * @param int $assignmentid The assignment instance ID
 * @return stdClass|false The notice record or false if not found
 */
function local_assignmentnotice_get_notice($assignmentid) {
    global $DB;
    return $DB->get_record('local_assignmentnotice', ['assignmentid' => $assignmentid]);
}
