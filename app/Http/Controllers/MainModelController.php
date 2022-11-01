<?php

namespace App\Http\Controllers;

use App\Models\MainModel;
use App\Http\Requests\StoreMainModelRequest;
use App\Http\Requests\UpdateMainModelRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class MainModelController extends Controller
{
    public function index()
    {       
        return view('index');
    }

    public function dados_conexao(Request $req) //Mudar nome function
    {
        $dados = $req->all();

        $json_table = DB::connection(env('DB_CONNECTION'))->table(env('DB_DATABASE_TABLE'))->get();
        $json_table = json_decode($json_table, true);

        $csv_filename = 'dados.csv';

        $file = fopen($csv_filename, 'w');

        foreach ($json_table as $i) {
            fputcsv($file, $i);
        }

        fclose($file);

        DB::connection(env('DB_CONNECTION_TARGET').'_target')->statement("TRUNCATE ONLY app.t_cius_cnae RESTART IDENTITY");
        DB::connection(env('DB_CONNECTION_TARGET').'_target')->statement("COPY app.t_cius_cnae FROM '".public_path('dados.csv')."' DELIMITER ',' CSV");

        return "Tabela importada com sucesso!";
    }

    public function populate_select_tables($conn, $host, $port, $db, $username, $password, $schema)
    {
        config(['database.default' => $conn]);
        config(['database.connections.pgsql.host' => $host]);
        config(['database.connections.pgsql.port' => $port]);
        config(['database.connections.pgsql.database' => $db]);
        config(['database.connections.pgsql.username' => $username]);
        config(['database.connections.pgsql.password' => $password]);

        return DB::connection()->select("SELECT table_name FROM information_schema.tables WHERE table_schema = '$schema'");
    }

    public function populate_select_schemas($conn, $host, $port, $db, $username, $password)
    {
        config(['database.default' => $conn]);
        config(['database.connections.pgsql.host' => $host]);
        config(['database.connections.pgsql.port' => $port]);
        config(['database.connections.pgsql.database' => $db]);
        config(['database.connections.pgsql.username' => $username]);
        config(['database.connections.pgsql.password' => $password]);

        return DB::connection()->select("SELECT DISTINCT table_schema FROM information_schema.tables ORDER BY table_schema");
    }
}
