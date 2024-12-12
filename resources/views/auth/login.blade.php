<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login</title>
    <style>
        body {
            background-image: url("{{ asset('img/background.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <form action="{{ route('login') }}" method="POST" class="form-login">
        @csrf
        <div class="login-card card">
            <div class="card-header">
                <i class="icofont-user-alt-4"></i>
                <span class="font-weight-light">Login</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Informe seu e-mail" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Informe sua senha" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Mantenha-me Conectado</label>
                </div>
            </div>
            <div class="card-footer">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">Esqueceu a senha?</a>
                @endif
                <button type="submit" class="btn btn-lg btn-primary">Entrar</button>
            </div>
        </div>
    </form>
</body>
</html>
