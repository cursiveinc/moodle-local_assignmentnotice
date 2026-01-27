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
 * Renderer for local_assignmentnotice.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer class for the assignment notice plugin.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_assignmentnotice_renderer extends plugin_renderer_base {

    /**
     * Render the AI Assessment Scale banner.
     *
     * @param stdClass $record The notice record from the database
     * @return string The rendered HTML
     */
    public function render_banner(stdClass $record): string {
        $level = (int) $record->aiaslevel;
        if ($level < 1 || $level > 5) {
            return '';
        }

        $bannertype = $record->bannertype ?? 'info';

        // Get the level title and student instruction.
        $title = get_string("aias_level{$level}_title", 'local_assignmentnotice');
        $studenttext = get_string("aias_level{$level}_student", 'local_assignmentnotice');
        $attribution = get_string('aias_attribution', 'local_assignmentnotice');
        $moreinfo = get_string('aias_moreinfo', 'local_assignmentnotice');
        $url = get_string('aias_url', 'local_assignmentnotice');

        // Build the banner content.
        $content = html_writer::tag('strong', "AI Assessment Scale - Level {$level}: {$title}");
        $content .= html_writer::empty_tag('br');
        $content .= html_writer::tag('span', $studenttext);
        $content .= html_writer::empty_tag('br');
        $content .= html_writer::tag('small',
            $attribution . ' ' .
            html_writer::link($url, $moreinfo, ['target' => '_blank', 'rel' => 'noopener'])
        );

        // Render as Bootstrap alert.
        $alertclass = "alert alert-{$bannertype}";
        $banner = html_writer::div($content, $alertclass, [
            'role' => 'alert',
            'id' => 'local-assignmentnotice-banner',
        ]);

        // Wrap in a container for positioning.
        return html_writer::div($banner, 'local-assignmentnotice-container mb-3');
    }
}
