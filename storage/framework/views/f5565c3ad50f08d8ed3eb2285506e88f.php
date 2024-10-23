<?php $__env->startSection('title', 'teste'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-md-10 offset-md-1 dashboard-events-container mt-3">
            
            <h5 id="info-sub-titulo">Solicitações para entrar no evento ~ <?php echo e($event->title); ?></h5>
            
            <?php if(count($pendingRequests) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col" colspan="2">Ações</th>
                            </tr>
                        </thead>
                    
                        <tbody id="eventsTableBody">
                            <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    
                                    <td><?php echo e($request->name); ?></td>
                                    
                                    <td>
                                        <form action="<?php echo e(route('events.approveRequest', [$event->id, $request->id])); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-circle-check"></i></button>
                                        </form>
                                    </td>
                                    
                                    <td>
                                        <form action="<?php echo e(route('events.rejectRequest', [$event->id, $request->id])); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-circle-xmark"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>   
            <?php else: ?>
                <p>Evento ainda não possui convidados confirmados</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/projetoEvento/resources/views/events/pendingRequests.blade.php ENDPATH**/ ?>