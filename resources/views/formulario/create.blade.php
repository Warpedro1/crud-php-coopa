<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link href="{{ asset('css/formulario.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="painel">
            <div class="painel-topo">
                <h2>Formulário de Cadastro</h2>
            </div>
            <div class="painel-conteudo">
                @if ($errors->any())
                    <div class="mensagem mensagem-erro">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('formulario.store') }}">
                    @csrf
                    
                    <div class="campo-grupo">
                        <label for="nome">Nome</label>
                        <input type="text" class="campo-entrada" id="nome" name="nome" value="{{ old('nome') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="email">Email</label>
                        <input type="email" class="campo-entrada" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="campo-entrada" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="cep">CEP</label>
                        <input type="text" class="campo-entrada" id="cep" name="cep" value="{{ old('cep') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="campo-entrada" id="estado_civil" name="estado_civil" required>
                            <option value="" selected disabled>Selecione...</option>
                            <option value="Solteiro(a)" {{ old('estado_civil') == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                            <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                            <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                            <option value="Viúvo(a)" {{ old('estado_civil') == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                        </select>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="time">Time que Torce</label>
                        <input type="text" class="campo-entrada" id="time" name="time" value="{{ old('time') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="profissao">Profissão</label>
                        <input type="text" class="campo-entrada" id="profissao" name="profissao" value="{{ old('profissao') }}" required>
                    </div>
                    
                    <div class="campo-grupo">
                        <label for="salario">Salário</label>
                        <input type="number" class="campo-entrada" step="0.01" id="salario" name="salario" value="{{ old('salario') }}" required>
                    </div>
                    
                    <div class="grupo-botoes">
                        <button type="submit" class="botao botao-primario">Enviar Cadastro</button>
                        <a href="{{ route('formulario.show') }}" class="botao botao-secundario">Visualizar Dados</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/formulario.js') }}"></script>
</body>
</html> 