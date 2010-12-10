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
 * newmodule renderer
 *
 * @package   mod_newmodule
 * @copyright 2010 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_newmodule_renderer extends plugin_renderer_base {

    /**
     * Display newmodule list
     * @param array $newmodules
     * $param string $courseformat
     * @return string
     */
     protected function render_newmodule_list(newmodule_list $newmodulelist) {

        $newmoduletable = new html_table();

        switch ($newmodulelist->courseformat) {
            case 'weeks':
                $newmoduletable->head = array(get_string('week'), get_string('name'));
                $newmoduletable->align = array('center', 'left');
                break;

            case 'topics':
                $newmoduletable->head = array(get_string('topic'), get_string('name'));
                $newmoduletable->align = array('center', 'left', 'left', 'left');
                break;

            default:
                $newmoduletable->head = array(get_string('name'));
                $newmoduletable->align = array('left', 'left', 'left');
                break;
        }

        foreach ($newmodulelist->newmodules as $newmodule) {
            $atagattributs = array('href' => new moodle_url('/mod/newmodule/view.php',
                        array('id' => $newmodule->coursemodule)));

            //Show dimmed if the mod is hidden
            if (!$newmodule->visible) {
                $atagattributs['class'] = 'dimmed';
            }

            $link = html_writer::tag('a', format_string($newmodule->name), $atagattributs);

            if ($newmodulelist->courseformat == 'weeks' or $newmodulelist->courseformat == 'topics') {
                $newmoduletable->data[] = array($newmodule->section, $link);
            } else {
                $newmoduletable->data[] = array($link);
            }
        }

        return html_writer::table($newmoduletable);
    }
    
}

class newmodule_list implements renderable {
 
    public function __construct($newmodules, $courseformat) {       
        $this->newmodules = $newmodules;
        $this->courseformat = $courseformat;
    }
}