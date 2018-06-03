<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Facultad;
use App\Departamento;
use App\Rol;

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

        $descripciones = [];

        foreach ($descripciones as $descripcion) {
            Descripcion::create($descripcion);
        }
    }
}
