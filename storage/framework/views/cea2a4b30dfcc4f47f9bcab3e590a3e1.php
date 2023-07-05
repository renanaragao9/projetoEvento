

<?php $__env->startSection('title', $event->title); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-6" id="image-container">
                <img src="/img/events/<?php echo e($event->image); ?>" class="img-fluid" alt="<?php echo e($event->title); ?>">
            </div>
            
            <div class="col-md-6" id="info-container">
                <h1><?php echo e($event->title); ?></h1>
                <p class="event-city"><ion-icon name="location-outline"></ion-icon><?php echo e($event->city); ?></p>
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon>X Participantes</p>
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon>Dono do Evento</p>
                <a href="#" class="btn btn-primary" id="event-submit">Confirmar Presença</a>
            </div>

            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description"><?php echo e($event->description); ?></p>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projetoEvento\FreeEvents\resources\views/events/show.blade.php ENDPATH**/ ?>