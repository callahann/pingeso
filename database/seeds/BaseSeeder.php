<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Departamento;
use App\Descripcion;
use App\Factor;
use App\Facultad;
use App\Formula;
use App\Jerarquia;
use App\Jornada;
use App\Periodo;
use App\Rango;
use App\User;
use App\Comision;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCS = [
            'tipo' => 0
        ];

        Comision::create($dataCS);

        $dataCF = [
            'tipo' => 1,
        ];

        $comision_facultad = Comision::create($dataCF);

        $dataF = [
            'nombre' => 'Facultad de Ingeniería',
            'id_comision' => $comision_facultad->id
        ];

        $facultad = Facultad::create($dataF);
    
        $dataD = [
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Eléctrica'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Geográfica'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Informática'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Industrial'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Mecánica'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Metalúrgica'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería en Minas'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería en Obras Civiles'
            ],
            [
                'id_facultad' => $facultad->id,
                'nombre' => 'Ingeniería Química'
            ]
        ];

        foreach ($dataD as $dept) {
            $comision = Comision::create([
                'tipo' => 2
            ]);
            $depto = new Departamento($dept);
            $depto->id_comision = $comision->id;
            $depto->save();
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
            [
                'descripcion'=>'Publicación de Trabajos de Desarrollo (Congresos y Jornadas)', 
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

        ];

        foreach ($descripciones as $descripcion) {
            Descripcion::create($descripcion);
        }

        $jerarquias = [
            [
                'nombre' => 'Ayudante',
            ],
            [
                'nombre' => 'Instructor',
            ],
            [
                'nombre' => 'Profesor asistente',
            ],
            [
                'nombre' => 'Profesor asociado',
            ],
            [
                'nombre' => 'Profesor titular',
            ]
        ];

        foreach ($jerarquias as $jerarquia) {
            Jerarquia::create($jerarquia);
        }

        $jornadas = [
            [
                'nombre' => 'Completa',
                'horas' => 36,
            ],
            [
                'nombre' => '3/4',
                'horas' => 27,
            ],
            [
                'nombre' => '1/2',
                'horas' => 18,
            ],
            [
                'nombre' => '1/4',
                'horas' => 9,
            ],
        ];

        foreach ($jornadas as $jornada) {
            Jornada::create($jornada);
        }

        $usuarios = [
            [
                'apellido_paterno' => 'Álvarez',
                'apellido_materno' => 'Molina',
                'nombres' => 'Mario Francisco',
                'email' => 'mario.alvarez.m@usach.cl',
                'rol' => 0,
                'id_departamento' => 3,
                'id_jerarquia' => 5,
                'id_jornada' => 1
            ],
            [
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'Mora',
                'nombres' => 'Matías José',
                'email' => 'matias.vargasm@usach.cl',
                'rol' => 2,
                'id_departamento' => 3,
                'id_jerarquia' => 5,
                'id_jornada' => 1
            ],
            [
                'apellido_paterno' => 'Callahan',
                'apellido_materno' => 'Apellido',
                'nombres' => 'Nicolás',
                'email' => 'nicolas.callahan@usach.cl',
                'rol' => 2,
                'id_departamento' => 3,
                'id_jerarquia' => 5,
                'id_jornada' => 1
            ],
            [
                'apellido_paterno' => 'Fuentes',
                'apellido_materno' => 'Apellido',
                'nombres' => 'Héctor',
                'email' => 'hector.fuentes@usach.cl',
                'rol' => 2,
                'id_departamento' => 3,
                'id_jerarquia' => 5,
                'id_jornada' => 1
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }

        $rangos = [
            [
                'base' => 0.01,
                'tope' => 1.49,
                'leyenda' => 'Insuficiente',
                'color' => 'red'
            ],
            [
                'base' => 1.50,
                'tope' => 1.99,
                'leyenda' => 'Condicional',
                'color' => '#FD7505'
            ],
            [
                'base' => 2.00,
                'tope' => 2.79,
                'leyenda' => 'Aceptable',
                'color' => '#F6A904'
            ],
            [
                'base' => 2.80,
                'tope' => 3.69,
                'leyenda' => 'Bueno',
                'color' => '#74C11D'
            ],
            [
                'base' => 3.70,
                'tope' => 7.00,
                'leyenda' => 'Sobresaliente',
                'color' => 'blue'
            ]
        ];

        foreach ($rangos as $rango) {
            Rango::create($rango);
        }

        $factores = [
            [
                'diferencia' => 7,
                'factor' => 1.0
            ]
        ];

        foreach ($factores as $factor) {
            Factor::create($factor);
        }

        $formulas = [
            [
                'equivalente' => "Math.round((se * 36 + sa) / 44 * 10) / 10",
                'nota_final' => "Math.round(((nota_item_docencia * realizado_eq_item_docencia + nota_item_investigacion * realizado_eq_item_investigacion + nota_item_asistencia * realizado_eq_item_asistencia + nota_item_perfeccionamiento * realizado_eq_item_perfeccionamiento + nota_item_administracion * realizado_eq_item_administracion + nota_item_extension * realizado_eq_item_extension + nota_item_educacion_continua * realizado_eq_item_educacion_continua) / realizado_eq) * 100) / 100"
            ]
        ];

        foreach ($formulas as $formula) {
            Formula::create($formula);
        }

        $periodos = [
            [
                'nombre' => '2018',
                'desde' => '2018-08-01 00:00:00',
                'hasta' => '2018-08-30 23:59:59',
                'id_departamento' => 3
            ]
        ];

        foreach ($periodos as $periodo) {
            Periodo::create($periodo);
        }
    }
}
