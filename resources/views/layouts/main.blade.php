<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        {{-- Fonts do Google --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

        {{-- Icones --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        {{-- CSS Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
        {{-- Styles --}}
        <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

        
        {{-- JS --}}
        <script src="{{ asset('js/scripts.js') }}"></script>


    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light" id="nav-main">
                <div class="container">
                    
                    <a href="{{ route('inicio') }}" class="navbar-brand">
                        <img src="{{ asset('img/logo_evento.png') }}" alt="Renan's Eventos" id="logo-img">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="{{route('inicio')}}" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i> Eventos
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('criarEvento') }}" class="nav-link">
                                    <i class="fas fa-plus-circle"></i> Criar Evento
                                </a>
                            </li>
                            
                            @auth
                                <li class="nav-item">
                                    <a href="{{ route('meuEvento') }}" class="nav-link">
                                        <i class="fas fa-calendar-check"></i> Meus eventos
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <a href="" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Sair
                                        </a>
                                    </form>
                                </li>
                            @endauth
                            
                            @guest
                                <li class="nav-item">
                                    <a href="{{route('login')}}" class="nav-link">
                                        <i class="fas fa-sign-in-alt"></i> Entrar
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="{{route('register')}}" class="nav-link">
                                        <i class="fas fa-user-plus"></i> Cadastrar
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>            
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))
                        <p class="msg">{{ session('msg') }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </main>
        <footer>
            <p>Renan´s Eventos &copy; 2024</p>
        </footer>
        
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

        {{-- DataTable --}}
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('js/dataTables.js') }}"></script> --}}
    </body>  
</html>
