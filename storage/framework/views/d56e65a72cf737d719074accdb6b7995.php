<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $__env->yieldContent('title'); ?></title>

        <!-- Fonts do Google-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <!-- CSS Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(asset('css/estilo.css')); ?>">
        
        <!-- JS -->
        <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>


    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light" id="nav-main">
                <div class="container">
                    <a href="<?php echo e(route('inicio')); ?>" class="navbar-brand">
                        <img src="<?php echo e(asset('img/logo_evento.png')); ?>" alt="Renan's Eventos" id="logo-img">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="<?php echo e(route('inicio')); ?>" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i> Eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('criarEvento')); ?>" class="nav-link">
                                    <i class="fas fa-plus-circle"></i> Criar Evento
                                </a>
                            </li>
                            
                            <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('meuEvento')); ?>" class="nav-link">
                                    <i class="fas fa-calendar-check"></i> Meus eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <a href="" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Sair
                                    </a>
                                </form>
                            </li>
                            <?php endif; ?>
                            
                            <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('login')); ?>" class="nav-link">
                                    <i class="fas fa-sign-in-alt"></i> Entrar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('register')); ?>" class="nav-link">
                                    <i class="fas fa-user-plus"></i> Cadastrar
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>            
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">
                    <?php if(session('msg')): ?>
                        <p class="msg"><?php echo e(session('msg')); ?></p>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </main>
        <footer>
            <p>Renan´s Eventos &copy; 2024</p>
        </footer>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    </body>  
</html>
<?php /**PATH /var/www/html/projetoEvento/resources/views/layouts/main.blade.php ENDPATH**/ ?>