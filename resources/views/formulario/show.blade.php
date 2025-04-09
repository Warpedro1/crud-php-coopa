<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros</title>
    <link href="{{ asset('css/formulario.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="painel">
            <div class="painel-topo">
                <h2>Lista de Cadastros</h2>
            </div>
            <div class="painel-conteudo">
                @if(session('success'))
                    <div class="mensagem mensagem-sucesso">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="acoes">
                    <a href="{{ route('formulario.create') }}" class="botao botao-primario botao-lg">Novo Cadastro</a>
                </div>
                
                <div class="tabela-container">
                    <table class="tabela">
                        <thead>
                            <tr class="tabela-linha">
                                <th class="tabela-cabecalho">#</th>
                                <th class="tabela-cabecalho">Nome</th>
                                <th class="tabela-cabecalho">Email</th>
                                <th class="tabela-cabecalho">Telefone</th>
                                <th class="tabela-cabecalho">CEP</th>
                                <th class="tabela-cabecalho">Estado Civil</th>
                                <th class="tabela-cabecalho">Time</th>
                                <th class="tabela-cabecalho">Profissão</th>
                                <th class="tabela-cabecalho">Salário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cadastros as $cadastro)
                                <tr id="row-{{ $cadastro->id }}" class="tabela-linha">
                                    <td class="tabela-celula">{{ $cadastro->id }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="nome" contenteditable="true">{{ $cadastro->nome }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="email" contenteditable="true">{{ $cadastro->email }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="telefone" contenteditable="true">{{ $cadastro->telefone }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="cep" contenteditable="true">{{ $cadastro->cep }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="estado_civil" data-type="select" data-options='{"Solteiro(a)":"Solteiro(a)","Casado(a)":"Casado(a)","Divorciado(a)":"Divorciado(a)","Viúvo(a)":"Viúvo(a)"}'>{{ $cadastro->estado_civil }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="time" contenteditable="true">{{ $cadastro->time }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="profissao" contenteditable="true">{{ $cadastro->profissao }}</td>
                                    <td class="tabela-celula campo-editavel" data-field="salario" data-type="number" data-step="0.01">R$ {{ number_format($cadastro->salario, 2, ',', '.') }}</td>
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
                                <tr class="tabela-linha">
                                    <td colspan="9" class="tabela-celula text-center">Nenhum cadastro encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="barra-fixa">
        <div class="wrapper">
            <button class="botao botao-sucesso" onclick="saveAllChanges()">
                Salvar Todas as Alterações
            </button>
        </div>
    </div>

    <div class="espaco-inferior"></div>

    <script src="{{ asset('js/formulario.js') }}"></script>
</body>
</html> 