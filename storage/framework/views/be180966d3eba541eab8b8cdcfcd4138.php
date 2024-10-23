<?php $__env->startSection('title', 'Editando: ' . $event->title); ?>

<?php $__env->startSection('content'); ?>

<div class="col-md-6 offset-md-3" id="event-create-container">
    
    <h1 id="create-title">Editando: <?php echo e($event->title); ?></h1>
    
    <form action=" <?php echo e(route('atualizarEvento', $event->id)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Nome do evento" value="<?php echo e($event->title); ?>">
        </div>

        <div class="form-group">
            <label for="title">Data do evento:</label>
            <input type="date" name="date" class="form-control" id="date" value="<?php echo e($event->date->format('Y-m-d')); ?>">
        </div>

        <div class="form-group">
            <label for="title">Cidade:</label>
            <input type="text" name="city" class="form-control" id="city" placeholder="Local do evento" value="<?php echo e($event->city); ?>">
        </div>

        <div class="form-group">
            <label for="title">O evento é privado ?:</label>
            <select name="private" id="private" class="form-control">
                <option value="0">Não</option>
                <option value="1" <?php echo e($event->private == 1 ? "selected='selected'" : ""); ?>>Sim</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento ?"><?php echo e($event->description); ?></textarea>
        </div>
        
        <input type="submit" class="btn btn-primary" id="button-create" value="Editar Evento!">
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/projetoEvento/resources/views/events/edit.blade.php ENDPATH**/ ?>