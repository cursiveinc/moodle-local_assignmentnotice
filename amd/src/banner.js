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
 * Banner injection for assignment pages.
 *
 * @module     local_assignmentnotice/banner
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {
    "use strict";

    /**
     * Build the banner HTML.
     *
     * @param {Object} config Configuration object
     * @returns {string} The banner HTML
     */
    var buildBannerHtml = function(config) {
        var levelText = 'AI Assessment Scale - Level ' + config.level + ': ' + config.title;
        var linkHtml = '<a href="' + config.url + '" target="_blank" rel="noopener">' + config.moreinfo + '</a>';

        return '<div class="alert alert-' + config.bannertype + '" role="alert" id="local-assignmentnotice-banner">' +
            '<strong>' + levelText + '</strong><br>' +
            '<span>' + config.studenttext + '</span><br>' +
            '<small>' + config.attribution + ' ' + linkHtml + '</small>' +
            '</div>';
    };

    /**
     * Find the best place to inject the banner.
     *
     * @returns {Element|null} The element to inject before, or null if not found
     */
    var findInjectionPoint = function() {
        var selectors = [
            // Assignment submission status table.
            '.submissionstatustable',
            // Assignment submission form.
            '#intro',
            // General assignment content.
            '[data-region="assignment-info"]',
            // Submission status.
            '.submissionstatussubmitted',
            '.submissionstatusnotsubmitted',
            // Online text editor.
            '#id_onlinetext_editor',
            '[data-fieldtype="editor"]',
            // File submissions.
            '#id_files_filemanager',
            '[data-fieldtype="filemanager"]',
            // Generic form on submission page.
            '#mform1',
            // Activity header (fallback).
            '.activity-header',
            // Region main content (last resort).
            '#region-main .card-body',
            '#region-main-box'
        ];

        for (var i = 0; i < selectors.length; i++) {
            var element = document.querySelector(selectors[i]);
            if (element) {
                return element;
            }
        }

        return null;
    };

    /**
     * Inject the banner into the page.
     *
     * @param {Object} config Configuration object
     */
    var injectBanner = function(config) {
        // Don't inject if already present.
        if (document.getElementById('local-assignmentnotice-banner')) {
            return;
        }

        // Build banner HTML.
        var bannerHtml = buildBannerHtml(config);

        // Find the best injection point.
        var injectionPoint = findInjectionPoint();

        if (injectionPoint) {
            // Create a container div.
            var container = document.createElement('div');
            container.className = 'local-assignmentnotice-container mb-3';
            container.innerHTML = bannerHtml;

            // Insert before the injection point.
            injectionPoint.parentNode.insertBefore(container, injectionPoint);
        }
    };

    return {
        /**
         * Initialise the banner display.
         *
         * @param {Object} config Configuration object containing banner data
         */
        init: function(config) {
            // Wait for DOM to be ready.
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    injectBanner(config);
                });
            } else {
                injectBanner(config);
            }
        }
    };
});
