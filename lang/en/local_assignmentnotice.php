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
 * Language strings for local_assignmentnotice.
 *
 * @package    local_assignmentnotice
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// General strings.
$string['pluginname'] = 'Assignment Notice (AI Assessment Scale)';
$string['privacy:metadata'] = 'The Assignment Notice plugin does not store any personal data.';

// Settings.
$string['aiaslevel'] = 'AI Assessment Scale Level';
$string['aiaslevel_help'] = 'Select the AI Assessment Scale level for this assignment. This will display a banner to students indicating what level of AI assistance is permitted.

The AI Assessment Scale is licensed under CC BY-NC-SA 4.0 by Mike Perkins, Leon Furze, Jasper Roe, and Jason MacVaugh (2025). For more information, visit: https://aiassessmentscale.com/';
$string['bannertype'] = 'Banner colour';
$string['bannertype_help'] = 'Select the colour of the banner that will be displayed to students.';
$string['assignmentnotice_header'] = 'AI Assessment Scale Notice';

// Banner types.
$string['bannertype_info'] = 'Blue';
$string['bannertype_warning'] = 'Yellow';
$string['bannertype_success'] = 'Green';
$string['bannertype_danger'] = 'Red';

// AI Assessment Scale levels - names.
$string['aias_none'] = 'None (no notice displayed)';
$string['aias_level1'] = 'Level 1: No AI';
$string['aias_level2'] = 'Level 2: AI Planning';
$string['aias_level3'] = 'Level 3: AI Collaboration';
$string['aias_level4'] = 'Level 4: Full AI';
$string['aias_level5'] = 'Level 5: AI Exploration';

// AI Assessment Scale levels - titles for banner.
$string['aias_level1_title'] = 'No AI';
$string['aias_level2_title'] = 'AI Planning';
$string['aias_level3_title'] = 'AI Collaboration';
$string['aias_level4_title'] = 'Full AI';
$string['aias_level5_title'] = 'AI Exploration';

// AI Assessment Scale levels - full descriptions for students.
$string['aias_level1_desc'] = 'The assessment is completed entirely without AI assistance in a controlled environment, ensuring that students rely solely on their existing knowledge, understanding, and skills.';
$string['aias_level1_student'] = 'You must not use AI at any point during the assessment. You must demonstrate your core skills and knowledge.';

$string['aias_level2_desc'] = 'AI may be used for pre-task activities such as brainstorming, outlining and initial research. This level focuses on the effective use of AI for planning, synthesis, and ideation, but assessments should emphasise the ability to develop and refine these ideas independently.';
$string['aias_level2_student'] = 'You may use AI for planning, idea development, and research. Your final submission should show how you have developed and refined these ideas.';

$string['aias_level3_desc'] = 'AI may be used to help complete the task, including idea generation, drafting, feedback, and refinement. Students should critically evaluate and modify the AI suggested outputs, demonstrating their understanding.';
$string['aias_level3_student'] = 'You may use AI to assist with specific tasks such as drafting text, refining and evaluating your work. You must critically evaluate and modify any AI-generated content you use.';

$string['aias_level4_desc'] = 'AI may be used to complete any elements of the task, with students directing AI to achieve the assessment goals. Assessments at this level may also require engagement with AI to achieve goals and solve problems.';
$string['aias_level4_student'] = 'You may use AI extensively throughout your work either as you wish, or as specifically directed in your assessment. Focus on directing AI to achieve your goals while demonstrating your critical thinking.';

$string['aias_level5_desc'] = 'AI is used creatively to enhance problem-solving, generate novel insights, or develop innovative solutions to solve problems. Students and educators co-design assessments to explore unique AI applications within the field of study.';
$string['aias_level5_student'] = 'You should use AI creatively to solve the task, potentially co-designing new approaches with your instructor.';

// Capabilities.
$string['assignmentnotice:configure'] = 'Configure AI Assessment Scale notice';
$string['assignmentnotice:view'] = 'View AI Assessment Scale notice';

// Attribution.
$string['aias_attribution'] = 'AI Assessment Scale by Mike Perkins, Leon Furze, Jasper Roe, and Jason MacVaugh (2025), licensed under CC BY-NC-SA 4.0.';
$string['aias_moreinfo'] = 'More information';
$string['aias_url'] = 'https://aiassessmentscale.com/';
