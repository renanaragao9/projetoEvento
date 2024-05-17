<?php $__env->startSection('title', 'Renan´s Eventos'); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-md-12" id="search-container">
        <h1>Busque um evento</h1>
        <form action="<?php echo e(route('inicio')); ?>" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" id="search" placeholder="Procurar...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-12" id="events-container">
        <?php if($search): ?>
            <h2>Buscando por: <?php echo e($search); ?></h2>
        <?php else: ?>
            <h2>Próximos Eventos</h2>
            <p class="subtitle">Veja os eventos dos próxims dias</p>
        <?php endif; ?>

        <div class="row" id="cards-container">
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card col-md-3">
                    
                    <img src="<?php echo e(asset('img/events/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>">
                    <ion-icon name="logo-ionic" class="position-absolute top-0 translate-middle m-3" id="<?php echo e($event->classe); ?>"></ion-icon>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($event->title); ?></h5>
                        <p class="card-info">Status: <?php echo e($event->status); ?></p>
                        <p class="card-info">Data: <?php echo e(date('d/m/Y', strtotime($event->date))); ?> (<?php echo e($event->diaDaSemana); ?>)</p>
                        <p class="card-info">Local: <?php echo e($event->city); ?></p>
                        <p class="card-info">Participantes: <?php echo e(count($event->users)); ?></p>
                        <a href="<?php echo e(route('verEvento', $event->id)); ?>" class="btn btn-primary" id="card-button">Saber Mais</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(count($events) == 0 && $search): ?>
                <p>Não foi possível encontrar nenhum evento com <?php echo e($search); ?>! <a href="<?php echo e(route('inicio')); ?>">Ver todos</a></p>
            <?php elseif(count($events) == 0): ?>
                <p>Não há eventos disponíveis</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
  
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/izadora/Documentos/Outros Projetos/projetoEvento/resources/views/welcome.blade.php ENDPATH**/ ?>