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
 * The assignsubmission_onenote assessable uploaded event.
 * @package    assignsubmission_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace assignsubmission_onenote\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The assignsubmission_onenote assessable uploaded event class.
 *
 * @package    assignsubmission_onenote
 * @since      Moodle 2.6
 */
class assessable_uploaded extends \core\event\assessable_uploaded {

    /**
     * Legacy event files.
     *
     * @var array
     */
    protected $legacyfiles = array();

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has uploaded a file to the submission with id '$this->objectid' " .
            "in the assignment activity with the course module id '$this->contextinstanceid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename = 'assign';
        $eventdata->cmid = $this->contextinstanceid;
        $eventdata->itemid = $this->objectid;
        $eventdata->courseid = $this->courseid;
        $eventdata->userid = $this->userid;
        if (count($this->legacyfiles) > 1) {
            $eventdata->files = $this->legacyfiles;
        }
        $eventdata->file = $this->legacyfiles;
        $eventdata->pathnamehashes = array_keys($this->legacyfiles);
        return $eventdata;
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'assessable_onenote_uploaded';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessableuploaded', 'assignsubmission_onenote');
    }

    /**
     * Get URL related to the action.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/assign/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Sets the legacy event data.
     *
     * @param stdClass $legacyfiles legacy event data.
     * @return void
     */
    public function set_legacy_files($legacyfiles) {
        $this->legacyfiles = $legacyfiles;
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'assign_submission';
    }

}
