<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/aut.css')); ?>">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body text-center">
                        <img src="<?php echo e(asset('img/logo-evento.png')); ?>" alt="Logo" id="imagem-aut">

                        <h3 id="titulo-login"> Entrar </h3>

                        <form method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <input name="email" type="text" class="form-control" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <input name="password" type="password" class="form-control" placeholder="Senha"
                                    id="password">
                            </div>

                            <div class="form-group form-check d-flex">
                                <input type="checkbox" class="form-check-input" id="showPassword">
                                <label class="form-check-label " for="showPassword">Mostrar Senha</label>
                            </div>

                            <div class="form-group">
                                <a href="<?php echo e(route('password.request')); ?>">Esqueceu a senha ?</a>
                            </div>

                            <div class="form-group">
                              <a href="<?php echo e(route('register')); ?>">Não possui cadastro ?</a>
                            </div>

                            <div class="form-group">
                                <a href="<?php echo e(route('inicio')); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
                              </div>

                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                    </div>

                    <div class="card-footer text-muted text-center">
                        &copy; 2024 Renan´s Eventos
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
        document.addEventListener('DOMContentLoaded', function() {
            const showPasswordCheckbox = document.getElementById('showPassword');
            const passwordInput = document.getElementById('password');

            showPasswordCheckbox.addEventListener('change', function() {
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
<?php /**PATH /home/izadora/Documentos/Outros Projetos/projetoEvento/resources/views/auth/login.blade.php ENDPATH**/ ?>