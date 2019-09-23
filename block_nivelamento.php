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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * block_nivelamento main file
 *
 * @package block_nivelamento
 * @copyright CCEAD PUC-Rio - Angela de Araujo <angela.araujo.rj@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined ( 'MOODLE_INTERNAL' ) || die ();
global $CFG;
require_once($CFG->dirroot.'/blocks/nivelamento/lib.php');

/**
 * Class nivelamento minimal required block class.
 */
class block_nivelamento extends block_base {
    
    /**
     * Initialize our block with a language string.
     */
    function init() {
        $this->title = get_string ( 'pluginname', 'block_nivelamento' );
    }
    
    /**
     * Add some text content to our block.
     */
    function get_content() {
        
        global $USER, $OUTPUT, $CFG;
        
        // Do we have any content?
        if ($this->content !== null) {
            return $this->content;
        }
        
        if (empty ( $this->instance )) {
            $this->content = '';
            return $this->content;
        }
        
        // OK let's add some content.
        $this->content = new stdClass ();        
        $this->content->text = '';
        $this->content->footer = '';
        
        $regex = '/(a[0-9]{7}|f[0-9]{5})$/';
        $alunopuc = preg_match($regex, $USER->username);
        $admin = has_capability('moodle/course:update', context_system::instance()); // Check whether a user has a particular capability in a given context
        
        if (!( ($alunopuc) or ($admin) ) ){
            return $this->content;
        }
        
        $config = get_config('block_nivelamento');

        // Get the block content.        
        $courses = block_nivelamento_get_courses($config->prefix);
        $icon = $OUTPUT->pix_icon('i/course', get_string('course'));        
        
        foreach ($courses as $course) {
            
            $urlcourse = $CFG->wwwroot. '/course/view.php?id='. $course->id;
            $this->content->text .= html_writer::link($urlcourse, $icon.format_string($course->fullname), array('title' => $course->shortname )).'<br>';
            
        }
        
        return $this->content;
        
    }
    
    
    /**
     * Allow multiple instances of the block.
     */
    function instance_allow_multiple() {
        return true;
    }
    
    /**
     * Allow block configuration.
     */
    function has_config() {
        return true;
    }
    
    /**
     * This is a list of places where the block may or
     * may not be added.
     */
    public function applicable_formats() {
        return array (
                'all' => false,
                'site' => true,
                'site-index' => true,
                'course-view' => false,
                'my' => true
        );
    }
}
    
    