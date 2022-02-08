<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resultados;
use DB;

class CampeonatoController extends Controller
{
    public function index(Request $request){

        $resultado =  DB::select( DB::raw("SELECT 
                                            concat('img/', t.id_time, '.png') as img,
                                            t.nome_time,
                                            IFNULL(SUM(resultado), 0) AS 'pontos',
                                            IF(COUNT(id_resultado) = null, 0, COUNT(id_resultado)-1) AS 'jogos',
                                            (SELECT 
                                                    COUNT(id_resultado)
                                                FROM
                                                    resultado
                                                WHERE
                                                    resultado = 3 AND id_time = t.id_time) AS 'vitoria',
                                            (SELECT 
                                                    COUNT(id_resultado)
                                                FROM
                                                    resultado
                                                WHERE
                                                    resultado = 1 AND id_time = t.id_time) AS 'empate',
                                            (SELECT 
                                                    COUNT(id_resultado)
                                                FROM
                                                    resultado
                                                WHERE
                                                    resultado = 0 AND id_time = t.id_time) AS 'derrota',
                                            SUM(gols_marcados) AS 'gols_pro',
                                            SUM(gols_sofridos) AS 'gols_cont',
                                            SUM(gols_marcados - gols_sofridos) AS 'saldo_gols'
                                        FROM
                                            resultado
                                                LEFT JOIN
                                            times_serie_a t ON t.id_time = resultado.id_time
                                        GROUP BY t.nome_time, t.id_time ORDER BY pontos DESC, vitoria DESC, saldo_gols DESC, gols_pro DESC, t.nome_time;
                                    "));
        
        return view('campeonato_brasileiro.index', compact('resultado', $resultado));
    }

    public function create(Request $request){
    
        if($request->time_1){
            $result = new Resultados;
            if($request->time_1_result > $request->time_2_result){
                $result->resultado = '3';
            }
            else if($request->time_1_result < $request->time_2_result){
                $result->resultado = '0';
            }
            else{
                $result->resultado = '1';
            }
                
            $result->id_time = $request->time_1;
            $result->gols_marcados = $request->time_1_result;
            $result->gols_sofridos = $request->time_2_result;

            $result->save();
        }
        
        $result2 = new Resultados;
        if($request->time_2_result > $request->time_1_result){
            $result2->resultado = '3';
        }
        else if($request->time_2_result < $request->time_1_result){
            $result2->resultado = '0';
        }
        else{
            $result2->resultado = '1';
        }
            
        $result2->id_time = $request->time_2;
        $result2->gols_marcados = $request->time_2_result;
        $result2->gols_sofridos = $request->time_1_result;

        $result2->save();

        // Retornar dados para preenchimento da tabela
        
        $tabela_a = DB::select( DB::raw("SELECT
                                        concat('img/', t.id_time, '.png') as img, 
                                        t.nome_time,
                                        IFNULL(SUM(resultado), 0) AS 'pontos',
                                        IF(COUNT(id_resultado) = null, 0, COUNT(id_resultado)-1) AS 'jogos',
                                        (SELECT 
                                                COUNT(id_resultado)
                                            FROM
                                                resultado
                                            WHERE
                                                resultado = 3 AND id_time = t.id_time) AS 'vitoria',
                                        (SELECT 
                                                COUNT(id_resultado)
                                            FROM
                                                resultado
                                            WHERE
                                                resultado = 1 AND id_time = t.id_time) AS 'empate',
                                        (SELECT 
                                                COUNT(id_resultado)
                                            FROM
                                                resultado
                                            WHERE
                                                resultado = 0 AND id_time = t.id_time) AS 'derrota',
                                        SUM(gols_marcados) AS 'gols_pro',
                                        SUM(gols_sofridos) AS 'gols_cont',
                                        SUM(gols_marcados - gols_sofridos) AS 'saldo_gols'
                                    FROM
                                        resultado
                                            LEFT JOIN
                                        times_serie_a t ON t.id_time = resultado.id_time
                                    GROUP BY t.nome_time, t.id_time ORDER BY pontos DESC, vitoria DESC, saldo_gols DESC, gols_pro DESC, t.nome_time;
                                "));

        return $tabela_a;

    }
}
