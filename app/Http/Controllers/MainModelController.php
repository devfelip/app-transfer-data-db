<?php

namespace App\Http\Controllers;

use App\Models\MainModel;
use App\Http\Requests\StoreMainModelRequest;
use App\Http\Requests\UpdateMainModelRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MainModelController extends Controller
{
    public function index()
    {
        //$registros = DbaTables::all();
        //$rex = json_encode($registros);

        $rex = DB::connection('pgsql')->table('recad.tCadastro')->select('cProprietarioNew')->get();
        $rex = json_encode($rex);
        return view('index',compact('rex'));
    }

    public function dados_conexao(Request $req)
    {
        $dados = $req->all();

        //Set env variables connection
        $conn = config(['database.default' => $dados['connection']]);
        config(['database.connections.oracle.host' => $dados['host']]);
        config(['database.connections.oracle.port' => $dados['port']]);
        config(['database.connections.oracle.database' => $dados['database']]);
        config(['database.connections.oracle.username' => $dados['username']]);
        config(['database.connections.oracle.password' => $dados['password']]);

        //$registros = MainModel::all();
        //$rex = json_encode($registros);
        
        $rex = DB::connection($conn)->table('recad.tCadastro')->select('cProprietarioNew')->get();
        $rex = json_encode($rex);
        return view('test',compact('rex'));
    }
}
