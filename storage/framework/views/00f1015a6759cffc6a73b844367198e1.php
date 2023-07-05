

<?php $__env->startSection('title', 'Criar Evento'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="col-md-6 offset-md-3" id="event-create-container">
        <h1>Crie o seu evento</h1>
        <form action="/events" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Nome do evento">
            </div>

            <div class="form-group">
                <label for="title">Cidade:</label>
                <input type="text" name="city" class="form-control" id="city" placeholder="Local do evento">
            </div>

            <div class="form-group">
                <label for="title">O evento é privado ?:</label>
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento ?"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Imagem do Evento:</label>
                <input type="file" name="image" class="form-control-file" id="image">
            </div>
            
            <input type="submit" class="btn btn-primary" id="button-create" value="Criar Evento!">
        </form>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projetoEvento\FreeEvents\resources\views/events/create.blade.php ENDPATH**/ ?>