<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"><head></head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Campeonato</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
        Inserir Confronto
    </button>
    <p>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="campeonatomodal">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Confronto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">    
            <form action="{{route('campeonato.cadastro')}}" method="POST">
                <div class="row">                
                    <div class="col">  
                        <select class="form-select" aria-label="Default select example" id="time_1">
                            @foreach(\App\Times::orderBy('nome_time')->get() as $times)
                            <option value="{{$times->id_time}}">{{$times->nome_time}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="time_1_result">
                    </div> 
                    X               
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="time_2_result">
                    </div>
                    <div class="col">
                        <select class="form-select" aria-label="Default select example" id="time_2">
                            @foreach(\App\Times::orderBy('nome_time')->get() as $times)
                            <option value="{{$times->id_time}}">{{$times->nome_time}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" id="salvar" class="btn btn-primary">Salvar Mudanças</button>
        </div>
        </div>
    </div>
    </div>

    <table id="tabela-classificacao" class="table table-bordered" style="border: 1px; width: 55%; height: 75%;">        
        <tr>
          <thead>
            <th>Time</th>
            <th>Pontos</th>
            <th>J</th>
            <th>V</th>
            <th>E</th>
            <th>D</th>
            <th>GP</th>
            <th>GC</th> 
            <th>SG</th>             
          </thead>         
        </tr>
        <tbody>
        @php
        $indice = 0;  
        @endphp 
        @foreach($resultado as $result)  
        <?php

            switch ($indice) {
            case "0":
                echo '<tr style="background-color: #90EE90">';
            break;
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
            case "6":
                echo '<tr style="background-color: #87CEEB">';
            break;
            case "7":
            case "8":
            case "9":
            case "10":                                    
            case "11":
            case "12":
            case "13":
                echo '<tr style="background-color: #FFFACD">';
            break;
            case 14:
            case 15: 
                echo '<tr style="background-color: ">';                                                                 
            break;
            default:
            echo '<tr style="background-color: #CD5C5C">';
            break;
            }
        ?>
            <th><img src="{!! asset($result->img)!!}" width="22px" alt="">{{$result->nome_time}}</th>
            <th>{{$result->pontos == null ? '0': $result->pontos}}</th>
            <th>{{$result->jogos}}</th>
            <th>{{$result->vitoria}}</th>
            <th>{{$result->empate}}</th>
            <th>{{$result->derrota}}</th>
            <th>{{$result->gols_pro}}</th>
            <th>{{$result->gols_cont}}</th> 
            <th>{{$result->saldo_gols}}</th>                 
        </tr>
            @php
                $indice ++;
            @endphp
        @endforeach      
        </tbody>

         
    </table>
</body>
</html>


<script type="text/javascript">
    $(function() {
        $('#salvar').click(function(){
            var time_1 = $('#time_1').val();
            var time_1_result = $('#time_1_result').val();
            var time_2 = $('#time_2').val();
            var time_2_result = $('#time_2_result').val();
            var table = '';
            var color = ''
            if (time_1 == time_2)
            {
                alert('Selecione times diferentes!');
                throw new Error();
            }
            $.ajax({
                url: '{{route('campeonato.cadastro')}}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    time_1:time_1,
                    time_1_result:time_1_result,
                    time_2:time_2,
                    time_2_result:time_2_result
                },            
                dataType: 'JSON',
                success: function (result) {
                        table += '<table><tr><th>Time</th><th>Pontos</th><th>J</th><th>V</th><th>E</th><th>D</th><th>GP</th><th>GC</th><th>SG</th></tr>';
                        var pontos = 0;                

                        $.each(result, function(i, row){ 
                            if(row.pontos != null){
                                pontos = row.pontos;
                            }

                            switch(i) {
                                case 0:
                                    color = "#90EE90";
                                    break;
                                case 1:
                                case 2:
                                case 3:
                                case 4:
                                case 5:
                                case 6:
                                    color = "#87CEEB";
                                    break;
                                case 7:
                                case 8:
                                case 9:
                                case 10:                                    
                                case 11:
                                case 12:
                                case 13:
                                    color = "#FFFACD";
                                    break;
                                case 14:
                                case 15: 
                                    color = '';                                                                   
                                    break;
                                default:
                                color = "#CD5C5C";                                    
                            }                                                               
                           
                            table += '<tr style="background-color:'+color+'"><th><img src='+row.img+' width="35px" alt="">'+row.nome_time+'</th>';
                            table += '<th>'+pontos+'</th>';
                            table += '<th>'+row.jogos+'</th>';
                            table += '<th>'+row.vitoria+'</th>';
                            table += '<th>'+row.empate+'</th>';
                            table += '<th>'+row.derrota+'</th>';
                            table += '<th>'+row.gols_pro+'</th>';
                            table += '<th>'+row.gols_cont+'</th>';
                            table += '<th>'+row.saldo_gols+'</th></tr></table>';
                            
                        });   
                        $('#tabela-classificacao').html(table);                       
                    },
                    error: function(){
                        alert('Erro');
                    }               
                });
           
        });
    });
</script>
