<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function import_table_source_to_target()
    {
        $table_db_source = env('DB_DATABASE_TABLE');
        $table_db_target = env('DB_DATABASE_TABLE_TARGET');
        $path_csv = env('PATH_CSV');

        // Gera JSON da tabela
        $json_table = DB::connection(env('DB_CONNECTION'))->table($table_db_source)->get();
        $json_table = json_decode($json_table, true);

        // Cria arquivo CSV na pasta public e importa os dados do JSON nele
        $csv_filename = 'dados.csv';

        $file = fopen($csv_filename, 'w');

        foreach ($json_table as $i) {
            fputcsv($file, $i);
        }

        fclose($file);

        // Limpa tabela, reseta coluna identity e importa os novos dados pelo csv gerado via query do postgres
        DB::connection(env('DB_CONNECTION_TARGET').'_target')->transaction(function () use($table_db_target, $path_csv) {            
            DB::connection(env('DB_CONNECTION_TARGET').'_target')->statement("TRUNCATE ONLY $table_db_target RESTART IDENTITY");
            DB::connection(env('DB_CONNECTION_TARGET').'_target')->statement("COPY $table_db_target FROM '$path_csv' DELIMITER ',' CSV");
        });
        
        return "Tabela $table_db_target importada com sucesso!";
    }
}
