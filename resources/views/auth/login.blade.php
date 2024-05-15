
<x-guest-layout>
  <x-authentication-card>
      <x-slot name="logo">
          <x-authentication-card-logo />
      </x-slot>

      <x-validation-errors class="mb-4" />

      @if (session('status'))
          <div class="mb-4 font-medium text-sm text-green-600">
              {{ session('status') }}
          </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
          @csrf

          <div>
              <x-label for="email" value="{{ __('Email') }}" />
              <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
          </div>

          <div class="mt-4">
              <x-label for="password" value="{{ __('Password') }}" />
              <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
          </div>

          <div class="block mt-4">
              <label for="remember_me" class="flex items-center">
                  <x-checkbox id="remember_me" name="remember" />
                  <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
              </label>
          </div>

          <div class="flex items-center justify-end mt-4">
              @if (Route::has('password.request'))
                  <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                      {{ __('Forgot your password?') }}
                  </a>
              @endif

              <x-button class="ml-4">
                  {{ __('Log in') }}
              </x-button>
          </div>
      </form>
  </x-authentication-card>
</x-guest-layout>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-card {
      margin-top: 100px;
    }
    .card-footer {
      background-color: #f8f9fa;
      border-top: none;
    }

  </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body text-center">
                        
                        <img src="logo.png" alt="Logo" class="mb-4">
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                        <div class="form-group">
                            <input name="email" type="text" class="form-control" placeholder="Usuário">
                        </div>
                        
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Senha" id="password">
                        </div>
                        
                        <div class="form-group form-check d-flex">
                            <input type="checkbox" class="form-check-input" id="showPassword">
                            <label class="form-check-label " for="showPassword">Mostrar Senha</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                    </div>
                    
                    <div class="card-footer text-muted text-center">
                        &copy; 2024 Nome da Empresa
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Font Awesome JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const showPasswordCheckbox = document.getElementById('showPassword');
      const passwordInput = document.getElementById('password');

      showPasswordCheckbox.addEventListener('change', function () {
        if (this.checked) {
          passwordInput.setAttribute('type', 'text');
        } else {
          passwordInput.setAttribute('type', 'password');
        }
      });
    });
  </script>
</body>
</html>
