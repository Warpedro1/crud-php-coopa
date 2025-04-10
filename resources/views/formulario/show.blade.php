<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros</title>
    <link href="{{ asset('css/formulario.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Lista de Cadastros</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="actions">
                    <a href="{{ route('formulario.create') }}" class="btn btn-primary btn-lg">Novo Cadastro</a>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>CEP</th>
                                <th>Estado Civil</th>
                                <th>Time</th>
                                <th>Profissão</th>
                                <th>Salário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cadastros as $cadastro)
                                <tr id="row-{{ $cadastro->id }}">
                                    <td>{{ $cadastro->id }}</td>
                                    <td class="editable" data-field="nome" contenteditable="true">{{ $cadastro->nome }}</td>
                                    <td class="editable" data-field="email" contenteditable="true">{{ $cadastro->email }}</td>
                                    <td class="editable" data-field="telefone" contenteditable="true">{{ $cadastro->telefone }}</td>
                                    <td class="editable" data-field="cep" contenteditable="true">{{ $cadastro->cep }}</td>
                                    <td class="editable" data-field="estado_civil" data-type="select" data-options='{"Solteiro(a)":"Solteiro(a)","Casado(a)":"Casado(a)","Divorciado(a)":"Divorciado(a)","Viúvo(a)":"Viúvo(a)"}'>{{ $cadastro->estado_civil }}</td>
                                    <td class="editable" data-field="time" contenteditable="true">{{ $cadastro->time }}</td>
                                    <td class="editable" data-field="profissao" contenteditable="true">{{ $cadastro->profissao }}</td>
                                    <td class="editable" data-field="salario" data-type="number" data-step="0.01">R$ {{ number_format($cadastro->salario, 2, ',', '.') }}</td>
                                </tr>
                                <form id="update-form-{{ $cadastro->id }}" action="{{ route('formulario.update', $cadastro->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="nome" id="nome-{{ $cadastro->id }}" value="{{ $cadastro->nome }}">
                                    <input type="hidden" name="email" id="email-{{ $cadastro->id }}" value="{{ $cadastro->email }}">
                                    <input type="hidden" name="telefone" id="telefone-{{ $cadastro->id }}" value="{{ $cadastro->telefone }}">
                                    <input type="hidden" name="cep" id="cep-{{ $cadastro->id }}" value="{{ $cadastro->cep }}">
                                    <input type="hidden" name="estado_civil" id="estado_civil-{{ $cadastro->id }}" value="{{ $cadastro->estado_civil }}">
                                    <input type="hidden" name="time" id="time-{{ $cadastro->id }}" value="{{ $cadastro->time }}">
                                    <input type="hidden" name="profissao" id="profissao-{{ $cadastro->id }}" value="{{ $cadastro->profissao }}">
                                    <input type="hidden" name="salario" id="salario-{{ $cadastro->id }}" value="{{ $cadastro->salario }}">
                                </form>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Nenhum cadastro encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="container">
            <button class="btn btn-success" onclick="saveAllChanges()">
                Salvar Todas as Alterações
            </button>
        </div>
    </div>

    <div class="bottom-spacing"></div>

    <script src="{{ asset('js/formulario.js') }}"></script>
</body>
</html> 