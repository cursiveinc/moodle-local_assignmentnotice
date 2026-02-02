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
 * Banner positioning module for local_assignmentnotice.
 *
 * @module     local_assignmentnotice/banner
 * @copyright  2026 Joseph Thibault <joe@cursivetechnology.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Selectors used for finding injection points.
 *
 * @type {Object}
 */
const Selectors = {
    container: '#local-assignmentnotice-container',
    injectionPoints: [
        '.submissionstatustable',
        '#intro',
        '[data-region="assignment-info"]',
        '.submissionstatussubmitted',
        '.submissionstatusnotsubmitted',
        '#id_onlinetext_editor',
        '[data-fieldtype="editor"]',
        '#id_files_filemanager',
        '[data-fieldtype="filemanager"]',
        '#mform1',
        '.activity-header',
        '#region-main .card-body',
        '#region-main-box',
    ],
};

/**
 * Find the best place to inject the banner.
 *
 * @returns {Element|null} The element to inject before, or null if not found
 */
const findInjectionPoint = () => {
    for (const selector of Selectors.injectionPoints) {
        const element = document.querySelector(selector);
        if (element) {
            return element;
        }
    }
    return null;
};

/**
 * Move the banner container to the appropriate location in the DOM.
 */
const positionBanner = () => {
    const container = document.querySelector(Selectors.container);
    if (!container) {
        return;
    }

    const injectionPoint = findInjectionPoint();
    if (injectionPoint) {
        injectionPoint.parentNode.insertBefore(container, injectionPoint);
    }
};

/**
 * Initialize the banner positioning.
 *
 * This module repositions the banner that was rendered by PHP/Mustache
 * to the appropriate location on the assignment page.
 */
export const init = () => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', positionBanner);
    } else {
        positionBanner();
    }
};
