<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Radar Cidadão - Cadastro</title>
    @vite('resources/css/app.css')
</head>
<body>

    <div class="login-card">
        <h1>Radar<span> Cidadão</span></h1>
        <p class="subtitle">Crie sua conta para acompanhar a segurança em sua região</p>

        @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <input type="string" name="name" placeholder="Nome" required class="input" style="width: 100%;
            padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #444;
        background-color: #2c2c2c;
        color: #f1f1f1;
        font-size: 1rem;
        outline: none;
        transition: all 0.2s ease-in-out;">
            <input type="email" name="email" placeholder="Email" required class="input">
            <input type="password" name="password" placeholder="Senha" required class="input">
            <input type="password" name="password_confirmation" placeholder="Confirme a senha" required class="input">
            <button type="submit" class="button">Cadastrar</button>
        </form>

        <p style="margin-top: 15px; text-align:center;">
            Já possui conta? 
            <a href="{{ url('/login') }}" style="color: orange; text-decoration: underline;">Faça login</a>
        </p>
    </div>

</body>
</html>
