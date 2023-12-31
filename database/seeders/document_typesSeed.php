<?php

namespace Database\Seeders;

use App\Models\document_types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class document_typesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Abrir el archivo "doc_typ.csv" y guardar los datos de este en una variable
        $csv=fopen(database_path("data/doc_typ.csv"),"r");

        while(($registro=fgetcsv($csv,2000,";"))!=FALSE){
            //Filtrado caracteres especiales
            $registro[0]=str_replace("﻿","",$registro[0]);

            //Guardado del registro en la BD
           document_types::create([
                'id'=>null,
                'name'=>$registro[1],
                'abbreviation'=>$registro[0]
            ]);
        }
    }
}
