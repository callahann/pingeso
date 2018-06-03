<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Facultad;
use App\Departamento;
use App\Rol;
use App\Descripcion;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'nombre' => 'Admin'
            ],
            [
                'nombre' => 'Profesor'
            ],
            [
                'nombre' => 'Director'
            ]
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }

        $dataF = [
            'nombre' => 'Facultad de Ingeniería'
        ];

        $facultad = Facultad::create($dataF);
    
        $dataD = [
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA ELECTRICA'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA GEOGRAFICA'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA INFORMATICA'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA INDUSTRIAL'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA MECANICA'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA METALURGICA'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA EN MINAS'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA EN OBRAS CIVILES'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'INGENIERIA QUIMICA'
            ]
        ];

        foreach ($dataD as $dept) {
            Departamento::create($dept);
        }

        $descripciones = [
            [
                'descripcion'=>'Docencia directa frente alumnos (N° créditos T E)',
                'tipo'=>1
            ],
            [
                'descripcion'=>'Docencia Laboratorio directo  (N° créditos L*N° Sesiones semanales)',
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación de clases', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación de Pruebas', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación de Controles', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación Guías de Ejercicios ', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación Guías de Experiencia', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Preparación de Apuntes', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Corrección de Pruebas', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Corrección de Controles', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Corrección de Informes y Trabajos ', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Planificación de otras actividades docentes (trabajos de inv.u otros)',
                'tipo'=>1
            ],
            [
                'descripcion'=>'Corrección de otras actividades docentes (trabajos de inv. u  otros', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Realización de Visitas a Terreno', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Atención de alumnos por internet', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Atención personalizada de alumnos', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Atención de alumnos, programa de tutorías', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Elaboración de Proyectos de desarrollo docente', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Gestión y ejecución de Proyectos de desarrollo docente', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Elaboración de productos de Proyectos de desarrollo docente', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Diseño de Planes de Estudio', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Diseño, preparación y actualización de Programas de Estudio', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Organización de Encuentros, Jornadas o Congresos de Docencia',
                'tipo'=>1
            ],
            [
                'descripcion'=>'Corrección y evaluación trabajos de titulación', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Supervisión de prácticas', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Evaluación informes de prácticas', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Docencia en programas especiales', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Otras actividades', 
                'tipo'=>1
            ],
            [
                'descripcion'=>'Elaboracion de Proyectos de Investigación y Desarrollo', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Proyectos de Investigación o desarrollo de interés departamental', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Gestión Administrativa y Desarrollo de Proyectos', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Organización de Encuentros Científicos', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Elaboración de productos de los Proyectos de Investigación', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Perfeccionamiento en Investigación', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Guías de memorias de título (2 Hr./semana/tema)', 
                'tipo'=>2
            ],
            ['descripcion'=>'Publicación de Trabajos de Desarrollo (Congresos y Jornadas)', 
                'tipo'=>2
            ],
            [
                'descripcion'=>'Otras actividades', 
                'tipo'=>2
            ],
            [
                'descripcion' => 'Formulación de actividades y Proyectos de A.T.',
                'tipo' => 3
            ],
            [
                'descripcion' => 'Gestión y Ejecución de Proyectos de A.T.',
                'tipo' => 3
            ],
            [
                'descripcion' => 'Asesorías Profesionales en proyectos Departamentales',
                'tipo' => 3
            ],
            [
                'descripcion' => 'Otras actividades',
                'tipo' => 3
            ],
            [
                'descripcion' => 'Perfeccionamiento docente',
                'tipo' => 4
            ],
            [
                'descripcion' => 'Postgrado',
                'tipo' => 4
            ],
            [
                'descripcion' => 'Curso de capacitación',
                'tipo' => 4
            ],
            [
                'descripcion' => 'Otras actividades',
                'tipo' => 4
            ],
            [
                'descripcion' => 'Cargos directivos en Facultad - Universidad',
                'tipo' => 5
            ],
            [
                'descripcion' => 'Participación en Comisiones institucionales',
                'tipo' => 5
            ],
            [
                'descripcion' => 'Función en Administración o coordinacion en Facultad - Universidad',
                'tipo' => 5
            ],
            [
                'descripcion' => 'Comité de carrera',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Plan Estratégico',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Acreditación',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Control de Gestión',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Laboratorios',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Jerarquización',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Comisión Evaluación y Calificación Desempeño Académico',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Consejo Departamental',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Otras actividades',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Gestion y Administraciòn de carrera',
                'tipo'=> 6
            ],
            [
                'descripcion' => 'Elaboración de proyectos de extensión',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Gestión y desarrollo de Proyectos de Extensión',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Participación en actividades de extensión',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Elaboración de Proyectos de capacitación o educación contínua',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Gestión y desarrollo de Proyectos de capacitación',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Elaboración, gestión y desarrollo de conferencias, charlas y otros',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Participación en conferencias, charlas y otros',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Representaciones en instituciones externas',
                'tipo' => 7
            ],
            [
                'descripcion' => 'Otras actividades',
                'tipo' => 7
            ],

        ];

        foreach ($descripciones as $descripcion) {
            Descripcion::create($descripcion);
        }
    }
}
