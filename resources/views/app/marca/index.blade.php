@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                LISTAGEM DE MARCAS
            </div>
            <div>
                <a href="{{ route('marca.create') }}" class="btn btn-sm btn-primary">
                    <i class="icofont-database-add icofont-2x"></i>
                    Novo marca
                </a>
            </div>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Operações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($marcas as $marca)
                    <tr>
                        <th scope="row">{{ $marca->id }}</td>
                        <td>{{ $marca->nome }}</td>
                        <td>{{ $marca->descricao }}</td>
                      
                        <td>
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('marca.show', ['marca' => $marca->id]) }}">
                                <i class="icofont-eye-alt"></i></a>
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('marca.edit', ['marca' => $marca->id]) }}">

                                <i class="icofont-ui-edit"></i> </a>
                            <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarMarca()">
                                <i class="icofont-ui-delete"></i></a>
                        </td>
                        <script>
                            function DeletarMarca() {
                                var x;
                                var r = confirm("Deseja deletar o registro marca?");
                                if (r == true) {

                                    document.getElementById('form_{{ $marca->id }}').submit()
                                } else {
                                    x = "Você pressionou Cancelar!";
                                }
                                document.getElementById("demo").innerHTML = x;
                            }
                        </script>
                       
                            <form id="form_{{ $marca->id }}" method="post" action="{{ route('marca.destroy', ['marca' => $marca->id]) }}" hidden>
                                @method('DELETE')
                                @csrf

                            </form>
                        

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>


</main>

@endsection

</html><!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linha do Tempo das Marcas</title>
    <style>
        /* Adicione o seu estilo aqui */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .timeline {
            position: relative;
            max-width: 600px;
            padding: 20px 0;
            list-style: none;
            width: 100%;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #007BFF;
            transform: translateX(-50%);
        }

        .timeline-item {
            margin: 20px 0;
            position: relative;
            padding: 10px 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 50%;
            width: 16px;
            height: 16px;
            background: #fff;
            border: 3px solid #007BFF;
            border-radius: 50%;
            top: 0;
            transform: translate(-50%, -50%);
        }

        .timeline-content {
            padding: 15px 20px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            width: calc(50% - 40px);
            margin-left: 20px;
        }

        .timeline-content.left {
            left: -1%;
            margin-left: -20px;
        }

        .timeline-content.right {
            left: 50%;
            margin-left: 20px;
        }

        .timeline-time {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <ul class="timeline">
        @foreach ($marcas as $index => $marca)
        <li class="timeline-item">
            <div class="timeline-content {{ $index % 2 == 0 ? 'left' : 'right' }}">
                <span class="timeline-time">{{ $marca->updated_at->format('d/m/Y H:i') }}</span>
                {{ $marca->nome }}
            </div>
        </li>
        @endforeach
    </ul>
</body>
</html>
