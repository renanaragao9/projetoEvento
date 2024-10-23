<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


    <?php if(auth()->user()->profile == 1): ?>
        <div class="col-md-10 offset-md-1 dashboard-title-container">
            <h1>Meus Eventos</h1>
        </div>

        <div class="col-md-10 offset-md-1 dashboard-events-container">
            <?php if(count($events) > 0): ?>
                <div class="table-responsive">
                    <div class="input-group w-50 mb-3">
                        
                        <input type="text" id="searchInput" class="form-control" placeholder="Procurar...">
                        
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" id="searchButton" type="button">
                                Pesquisar
                            </button>
                        </div>
                    </div>
                    
                    <div class="event-table-container">
                        <table class="table table-striped table-bordered table-hover" id="eventsTable">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Privacidade</th>
                                    <th scope="col">Participantes</th>
                                    <th scope="col" colspan="4">Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody id="eventsTableBody">
                                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="text-center">
                                        <td scope="row"><?php echo e($event->id); ?></td>
                                        
                                        <td><a href="<?php echo e(route('verEvento', $event->id)); ?>" class="text-decoration-none"><?php echo e($event->title); ?></a></td>
                                        
                                        <td><?php echo e($event->private ? 'Público' : 'Privado'); ?></td>
                                        
                                        <td><?php echo e(count($event->users)); ?></td>
                                        
                                        <td class="text-center">
                                            <a href="<?php echo e(route('informacaoEvento', $event->id)); ?>" class="btn btn-success edit-btn" id="dash-button">
                                                <i class="fa-solid fa-circle-info"></i> <span class="d-none d-sm-inline">Informações</span>
                                            </a>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a href="<?php echo e(route('editarEvento', $event->id)); ?>" class="btn btn-warning edit-btn" id="dash-button">
                                                <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">Editar</span>
                                            </a>
                                        </td>
                        
                                        <td class="text-center">
                                            <a href="<?php echo e(route('events.pendingRequests', $event->id)); ?>" class="btn btn-dark aproved-btn" id="dash-button">
                                                <i class="fas fa-eye"></i> <span class="d-none d-sm-inline">Solicitações</span>
                                            </a>
                                        </td>
        
                                        <td class="text-center">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#addImageModal" onclick="setEventId(<?php echo e($event->id); ?>)">
                                                <i class="fa-solid fa-image"></i> <span class="d-none d-sm-inline">Adicionar Imagens</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            
                            <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
                                Nenhum evento encontrado.
                            </div>
                        </table>
                    </div>
                </div>        
            <?php else: ?>
                <p>Você ainda não tem eventos, <a href="<?php echo e(route('criarEvento')); ?>">Criar evento</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Eventos que estou participando</h1>
    </div>

    <div class="col-md-10 offset-md-1 dashboard-events-container">
        <?php if(count($eventsAsParticipant) > 0): ?>
    
            <div class="input-group w-50 mb-3">
                
                <input type="text" id="searchInput2" class="form-control" placeholder="Procurar...">
                
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="searchButton2" type="button">
                        Pesquisar
                    </button>
                </div>
            </div>
    
            <div class="table-responsive">
                <div class="event-table-container">
                    <table class="table table-striped table-bordered table-hover" id="eventsTableParticipants">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Participantes</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            <?php $__currentLoopData = $eventsAsParticipant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td scope="row"><?php echo e($loop->index + 1); ?></td>
                                    <td><a href="<?php echo e(route('verEvento', $event->id)); ?>" class="text-decoration-none"><?php echo e($event->title); ?></a></td>
                                    <td><?php echo e(count($event->users)); ?></td>
                                    <td class="text-center"> 
                                        <form action="<?php echo e(route('deixarEvento', $event->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field("DELETE"); ?>
                                            <button type="submit" class="btn btn-danger delete-btn">
                                                <i class="fas fa-trash-alt"></i> Sair do Evento
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div id="noResultsMessageParticipant" class="alert alert-warning" style="display: none;">
                    Nenhum evento encontrado.
                </div>
            </div>
        <?php else: ?>
            <p>Você ainda não está participando de nenhum evento, <a href="/">Veja todos os eventos</a></p>
        <?php endif; ?>
    </div>

    <!-- Modal Upload de imagens-->
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Adicionar Imagens para o Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="imageUploadForm" action="<?php echo e(route('galleries.store', '')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    
                    <div class="modal-body">
                        <input type="hidden" id="eventId" name="event_id">
                        <div class="form-group">
                            <label for="images">Escolha as Imagens</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                            <div id="imageCountMessage" class="text-danger" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Adicionar Imagens</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/projetoEvento/resources/views/events/dashboard.blade.php ENDPATH**/ ?>