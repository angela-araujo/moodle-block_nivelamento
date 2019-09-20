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
 * Callback functions for block_nivelamento.
 *
 * @package block_nivelamento
 * @copyright CCEAD PUC-Rio - Angela de Araujo <angela.araujo.rj@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function block_nivelamento_get_courses() {
    
    global $DB;
    
    /*        $sql = "SELECT  c.id, c.category, c.fullname, c.shortname, c.idnumber, c.format, c.sortorder, c.visible
     FROM    {course} c
     WHERE   EXISTS (SELECT e.courseid
     FROM {enrol} e
     WHERE e.courseid = c.id
     AND e.enrol LIKE 'self'
     AND e.status = 0)
     AND UPPER(c.idnumber) LIKE UPPER(':prefixidnumber%')
     ORDER BY c.fullname;";*/
    $sql = "SELECT  c.id, c.category, c.fullname, c.shortname, c.idnumber, c.visible
                FROM    {course} c
                WHERE   UPPER(c.idnumber) LIKE UPPER('niv%')
                ORDER BY c.fullname";
    $courses = $DB->get_records_sql($sql);
    
    return $courses;

}

