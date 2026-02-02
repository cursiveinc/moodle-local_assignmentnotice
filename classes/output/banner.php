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

namespace local_assignmentnotice\output;

use core\output\named_templatable;
use renderable;
use renderer_base;
use stdClass;

/**
 * Renderable for the AI Assessment Scale banner.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class banner implements renderable, named_templatable {
    /** @var int The AI Assessment Scale level (1-5) */
    private int $level;

    /** @var string The Bootstrap alert type (info, warning, success, danger) */
    private string $bannertype;

    /**
     * Constructor.
     *
     * @param int $level The AI Assessment Scale level (1-5)
     * @param string $bannertype The Bootstrap alert type
     */
    public function __construct(int $level, string $bannertype) {
        $this->level = $level;
        $this->bannertype = $bannertype;
    }

    /**
     * Get the name of the template to use for this renderable.
     *
     * @param renderer_base $renderer The renderer
     * @return string The template name
     */
    public function get_template_name(renderer_base $renderer): string {
        return 'local_assignmentnotice/banner';
    }

    /**
     * Export data for the Mustache template.
     *
     * @param renderer_base $output The renderer
     * @return stdClass Data for the template
     */
    public function export_for_template(renderer_base $output): stdClass {
        $title = get_string("aias_level{$this->level}_title", 'local_assignmentnotice');
        $studenttext = get_string("aias_level{$this->level}_student", 'local_assignmentnotice');

        return (object) [
            'leveltext' => "AI Assessment Scale - Level {$this->level}: {$title}",
            'studenttext' => $studenttext,
            'bannertype' => $this->bannertype,
        ];
    }
}
