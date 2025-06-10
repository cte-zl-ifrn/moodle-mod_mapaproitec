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

/**
 * Block multiprogress is defined here.
 *
 * @package     block_multiprogress
 * @copyright   2025 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_multiprogress extends block_base
{

    /**
     * Initializes class member variables.
     */
    public function init()
    {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_multiprogress');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content()
    {
        global $OUTPUT, $DB, $CFG, $COURSE, $USER;
        // Título do curso
        // Subtítulo do curso
        // URL da pedra do curso
        // Progresso do curso
        $courses = $DB->get_records_sql(
            "
                SELECT c.id                                       AS course_id
                , c.idnumber                                      AS course_idnumber
                , c.fullname                                      AS course_fullname
                , c.shortname                                      AS course_shortname
                , (SELECT cd.value
                    FROM mdl_customfield_data                cd
                            INNER JOIN mdl_customfield_field cf ON
                                (cd.fieldid = cf.id AND cf.shortname = 'multiprogress_course_alias')
                    WHERE cd.instanceid = c.id)                 AS course_alias
                , (SELECT cd.value
                    FROM mdl_customfield_data                cd
                            INNER JOIN mdl_customfield_field cf ON
                                (cd.fieldid = cf.id AND cf.shortname = 'multiprogress_course_subtitle')
                    WHERE cd.instanceid = c.id)                 AS course_subtitle
                , (SELECT cd.value
                    FROM mdl_customfield_data                cd
                            INNER JOIN mdl_customfield_field cf ON
                                (cd.fieldid = cf.id AND cf.shortname = 'multiprogress_course_image_url')
                    WHERE cd.instanceid = c.id)                 AS course_image_url
                , COUNT(cm.id)                                    AS total_modules
                , COUNT(mc.id)                                    AS completed_modules
                , TRUNC((COUNT(mc.id) * 100.0 / COUNT(cm.id)), 0) AS completion_percentage
            FROM mdl_course                                   c
                    INNER JOIN mdl_course_modules            cm ON (c.id = cm.course)
                    LEFT JOIN  mdl_course_modules_completion mc ON (cm.id = mc.coursemoduleid)
            WHERE c.category = $COURSE->category
            AND (mc.userid = $USER->id OR mc.userid IS NULL)
            GROUP BY c.id, c.fullname, c.shortname, c.idnumber
            ORDER BY c.idnumber DESC
            "
        );

        $traducao = [
            'FIC.1195' => [
                'course_alias' => 'PEDRA DA LÓGICA',
                'course_subtitle' => 'Viaje ate o Oeste Potiguar para obtê-la',
                'stone_color' => '62, 193, 52'
            ],
            'FIC.1196' => [
                'course_alias' => 'PEDRA DA COMUNICAÇÃO',
                'course_subtitle' => 'Viaje ate a Central Potiguar para obtê-la',
                'stone_color' => '253, 35, 217'
            ],
            'FIC.1197' => [
                'course_alias' => 'PEDRA DA HARMONIA',
                'course_subtitle' => 'Viaje ate o Agreste Potiguar para obtê-la',
                'stone_color' => '242, 183, 34'
            ],
            'FIC.1198' => [
                'course_alias' => 'PEDRA DA UNIDADE',
                'course_subtitle' => 'Viaje ate o Leste Potiguar para obtê-la',
                'stone_color' => '47, 109, 246'
            ]
        ];

        foreach ($courses as $course) {
            // Extrai o valor 'FIC.1197' do idnumber usando regex
            $disciplina = null;
            if (preg_match('/.*\.(FIC.\\d*)#.*/', $course->course_idnumber, $matches)) {
                $disciplina = $matches[1];
            }

            if (array_key_exists($disciplina, $traducao)) {
                // Se a disciplina existir no array de tradução, use os valores correspondentes.
                $course->course_alias = $traducao[$disciplina]['course_alias'];
                $course->stone_color =  $traducao[$disciplina]['stone_color'];
                $course->course_subtitle = $traducao[$disciplina]['course_subtitle'];
                $course->course_image_url = "$CFG->wwwroot/blocks/multiprogress/assets/img/pedra.$disciplina.png";
            } else {
                // Caso contrário, defina valores padrão.
                $course->course_alias = $course->course_fullname;
                $course->course_subtitle = $course->course_shortname;
                $course->stone_color = '0, 255, 255';
            }
            $course->isactive = ($course->course_id == $COURSE->id) ? 'd-flex' : 'hidden';
        }

        $data = [
            'courses' => array_values($courses)
        ];

        $this->content = new stdClass();
        $this->content->text =  $OUTPUT->render_from_template('block_multiprogress/multiprogress', $data);
        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization()
    {
        // Load user defined title and make sure it's never empty.
        $this->title = '';
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats()
    {
        return [
            'admin' => false,
            'site-index' => false,
            'course-view' => true,
            'mod' => true,
            'my' => false,
        ];
    }

    /**
     * Retorna o conteúdo HTML padrão do bloco.
     *
     * @return array
     */
    public function get_default_htmlcontent(): array
    {
        return [
            'text' => '
            <div class="site-info-header">
                <h1>O Moodle em números</h1>
                <h5>Estude em uma instituição centenária, sem pagar, sair de casa ou necessitar de matrícula.</h5>
            </div>
            <div class="row hero">
                <div class="col-md-3">
                    <div class="site-info-header-column">
                        <p class="site-info-header-column-number text-green">115 anos</p>
                        <p class="site-info-header-column-title">De história</p>
                        <p class="site-info-header-column-text">Mais de 1 século de dedicação à educação e à formação profissional.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="site-info-header-column">
                        <p class="site-info-header-column-number text-green">49</p>
                        <p class="site-info-header-column-title">Cursos</p>
                        <p class="site-info-header-column-text">Nossos cursos são focados em formação inicial e continuada.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="site-info-header-column">
                        <p class="site-info-header-column-number text-green">11 mil</p>
                        <p class="site-info-header-column-title">Alunos</p>
                        <p class="site-info-header-column-text">Nossa base de usuários reflete a eficácia de nossos cursos.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="site-info-header-column">
                        <p class="site-info-header-column-number text-green">5 mil</p>
                        <p class="site-info-header-column-title">Certificados</p>
                        <p class="site-info-header-column-text">Obtenha um certificado de conclusão emitido por uma instituição prestigiada.</p>
                    </div>
                </div>
            </div>
            <div class="site-info-main-header-about-button">
                <a href="https://ead.ifrn.edu.br/" class="btn btn-primary">Sobre nós</a>
            </div>',
            'format' => FORMAT_HTML
        ];
    }
}
