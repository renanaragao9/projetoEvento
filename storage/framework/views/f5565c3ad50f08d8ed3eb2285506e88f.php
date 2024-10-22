<?php $__env->startSection('title', 'teste'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Solicitações Pendentes para <?php echo e($event->title); ?></h1>

    <form action="<?php echo e(route('events.approveAllRequests', $event->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-primary">Aprovar Tudo</button>
    </form>

    <?php if($pendingRequests->isEmpty()): ?>
        <p>Não há solicitações pendentes.</p>
    <?php else: ?>
        <ul>
            <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php echo e($request->name); ?>

                    <form action="<?php echo e(route('events.approveRequest', [$event->id, $request->id])); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success"><ion-icon name="checkbox-outline" id="peding-button"></ion-icon></button>
                    </form>
                    
                    <form action="<?php echo e(route('events.rejectRequest', [$event->id, $request->id])); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger"><ion-icon name="close-circle-outline" id="peding-button"></ion-icon></button>
                    </form>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/projetoEvento/resources/views/events/pendingRequests.blade.php ENDPATH**/ ?>