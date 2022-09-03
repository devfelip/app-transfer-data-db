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
        //$registros = DbaTables::all();
        //$rex = json_encode($registros);

        return view('index');
    }

    public function connect_database_realtime($host,$port,$database,$username,$password)
    {
        config(['database.connections.pgsql.host' => $host]);
        config(['database.connections.pgsql.port' => $port]);
        config(['database.connections.pgsql.database' => $database]);
        config(['database.connections.pgsql.username' => $username]);
        config(['database.connections.pgsql.password' => $password]);
    }

    public function dados_conexao(Request $req)
    {
        $dados = $req->all();
        $conn = $dados['connection'];

        //Set env variables connection
        if ($conn == "pgsql") {
            config(['database.connections.pgsql.host' => $dados['host']]);
            config(['database.connections.pgsql.port' => $dados['port']]);
            config(['database.connections.pgsql.database' => $dados['database']]);
            config(['database.connections.pgsql.username' => $dados['username']]);
            config(['database.connections.pgsql.password' => $dados['password']]);
        }

        //$registros = MainModel::all();
        //$rex = json_encode($registros);

        $rex = DB::connection($conn)->table('recad.tCadastro')->select('cProprietarioNew')->get();
        $rex = json_encode($rex);

        return view('test', compact('rex'));
    }

    public function populate_select_tables($conn)
    {
        return DB::connection($conn)->select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'app'");
    }
}
