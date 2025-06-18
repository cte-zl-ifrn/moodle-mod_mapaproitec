<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

/**
 * The task that provides a complete restore of mod_mapaproitec is defined here.
 *
 * @package     mod_mapaproitec
 * @category    backup
 * @copyright   2025 DEAD/ZL/IFRN <dead.zl@ifrn.edu.br>, Kelson da Costa Medeiros <kelsoncm@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// More information about the backup process: {@link https://docs.moodle.org/dev/Backup_API}.
// More information about the restore process: {@link https://docs.moodle.org/dev/Restore_API}.

require_once($CFG->dirroot.'//mod/mapaproitec/backup/moodle2/restore_mapaproitec_stepslib.php');

/**
 * Restore task for mod_mapaproitec.
 */
class restore_mapaproitec_activity_task extends restore_activity_task {

    /**
     * Defines particular settings that this activity can have.
     */
    protected function define_my_settings() {
        return;
    }

    /**
     * Defines particular steps that this activity can have.
     *
     * @return base_step.
     */
    protected function define_my_steps() {
        $this->add_step(new restore_mapaproitec_activity_structure_step('mapaproitec_structure', 'mapaproitec.xml'));
    }

    /**
     * Defines the contents in the activity that must be processed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_contents() {
        $contents = [];

        $contents[] = new restore_decode_content(
            'mapaproitec',              // Nome da tabela.
            ['intro'],                      // Campos com conteúdo a ser decodificado.
            'mapaproitec'               // Tipo da atividade.
        );


        return $contents;
    }

    /**
     * Defines the decoding rules for links belonging to the activity to be executed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_rules() {
        $rules = [];

        $rules[] = new restore_decode_rule(
            'mapaproitecVIEWBYID',
            '/mod/mapaproitec/view.php?id=$1',
            'course_module'
        );

        $rules[] = new restore_decode_rule(
            'mapaproitecINDEX',
            '/mod/mapaproitec/index.php?id=$1',
            'course'
        );


        return $rules;
    }

    /**
     * Defines the restore log rules that will be applied by the
     * {@see restore_logs_processor} when restoring mod_mapaproitec logs. It
     * must return one array of {@see restore_log_rule} objects.
     *
     * @return array.
     */
    public static function define_restore_log_rules() {
        $rules = [];

        // Define the rules.

        return $rules;
    }
}
