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
 * This is a one-line short description of the file
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package   mod_newmodule
 * @copyright 2010 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');

$id = required_param('id', PARAM_INT);   // course

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

add_to_log($course->id, 'newmodule', 'view all', "index.php?id=$course->id", '');

$PAGE->set_url('/mod/newmodule/index.php', array('id' => $id));
$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->shortname);

/// Get all the appropriate data
$newmodules = get_all_instances_in_course('newmodule', $course);

/// OUTPUT
echo $OUTPUT->header();

if (empty($newmodules)) {
    echo $OUTPUT->heading(get_string('nonewmodules', 'newmodule'), 2);
    echo $OUTPUT->continue_button("index.php?id=$course->id");
} else {
    echo $OUTPUT->heading(get_string('modulenameplural', 'newmodule'), 2);
/// Print the list of instances (your module will probably extend this)
    $renderer = $PAGE->get_renderer('mod_newmodule');
    $newmodulelist = new newmodule_list($newmodules, $course->format);
    echo $renderer->render($newmodulelist);
}

echo $OUTPUT->footer();