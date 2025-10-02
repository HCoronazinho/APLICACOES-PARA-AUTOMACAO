<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Radar Cidadão - Login</title>
    @vite('resources/css/app.css')
</head>
<body>

    <div class="login-card">
        <h1>Radar<span> Cidadão</span></h1>
        <p class="subtitle">Acompanhe a segurança em sua região</p>

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            <a href="{{ url('/register') }}" style="color: #ff7b00; text-decoration: none; font-weight: bold;">
            Não possui conta? Cadastre-se
            </a>
        </p>

        <a href="#" class="forgot-link">Esqueceu sua senha?</a>
    </div>

</body>
</html>
