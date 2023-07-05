<?php $__env->startSection('title', 'HDC Events'); ?>

<?php $__env->startSection('content'); ?>

     <div class="col-md-12" id="search-container">
        <h1>Busque um evento</h1>
        <form action="">
            <input type="text" name="search" class="form-control" id="search" placeholder="Procurar...">
        </form>
     </div> 

     <div class="col-md-12" id="events-container">
        <h2>Próximos Eventos</h2>
        <p class="subtitle">Veja os eventos dos próxims dias</p>
        <div class="row" id="cards-container">
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card col-md-3">
                    <img src="/img/events/<?php echo e($event->image); ?>" alt="<?php echo e($event->title); ?>">
                    <div class="card-body">
                        <p class="card-date">10/09/2023</p>
                        <h5 class="card-title"><?php echo e($event->title); ?></h5>
                        <p class="card-participants">X Participantes</p>
                        <a href="#" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
     </div>
<?php $__env->stopSection(); ?>
  
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projetoEvento\FreeEvents\resources\views/welcome.blade.php ENDPATH**/ ?>