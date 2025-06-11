# Mapa Proitec #

TO-DO Describe the plugin shortly here.

TO-DO Provide more detailed description here.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/mod/mapaproitec

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

2025 DEAD/ZL/IFRN <dead.zl@ifrn.edu.br>, Kelson da Costa Medeiros <kelsoncm@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.


## Estrutura das categorias e cursos

- diarios - Diários
  - ZL - Campus
    - 527 - Curso
        - 527.2024.2 - Período da oferta
          - 20242.1.527.1E - Turma
            - **20242.1.527.1E**.`FIC.1198`#*654325* - Seminário de Integração
            - **20242.1.527.1E**.`FIC.1197`#*654321* - Ética e Cidadania
            - **20242.1.527.1E**.`FIC.1196`#*654323* - Matemática
            - **20242.1.527.1E**.`FIC.1195`#*564322* - Língua Portuguesa

