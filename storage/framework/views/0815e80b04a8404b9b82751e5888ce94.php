<?php $__env->startSection('title', $event->title); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-6" id="image-container">
                <?php if($event->image): ?>
                    <?php
                        $images = json_decode($event->image);
                    ?>
            
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                    <div class="position-relative">
                                        <img src="<?php echo e(asset('img/events/' . $image)); ?>" class="d-block w-100" id="show-image" alt="<?php echo e($event->title); ?>">
                                        <a href="<?php echo e(asset('img/events/' . $image)); ?>" data-lightbox="event-gallery" data-title="<?php echo e($event->title); ?>" class="btn btn-zoom d-none"></a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
            
                    <!-- Adicione os controles abaixo do carousel com o botão de tela cheia no centro -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="prev">Anterior</a>
                        <a class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="next">Próximo</a>
                    </div>
                <?php endif; ?>
            </div>
                        
            
            <div class="col-md-6" id="info-container">
                <h1><?php echo e($event->title); ?></h1>
                
                <p class="event-city"><ion-icon name="location-outline"></ion-icon><?php echo e($event->city); ?></p>
                
                <p class="event-city"><ion-icon name="calendar-outline"></ion-icon><?php echo e(date('d/m/Y', strtotime($event->date))); ?></p>
                
                <p class="event-city"><ion-icon name="time-outline"></ion-icon><?php echo e($event->time); ?></p>
               
                <?php if($event->private == 0): ?>
                    <p class="event-city"><ion-icon name="bag-outline"></ion-icon>Privado</p>
                <?php else: ?>
                    <p class="event-city"><ion-icon name="earth-outline"></ion-icon>Público</p>
                <?php endif; ?>
                
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon><?php echo e(count($event->users)); ?> Participantes</p>
                
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon><?php echo e($eventOwner['name']); ?></p>
                
                <?php if(!$hasUserJoined): ?>
                    <form action=" <?php echo e(route('entrarEvento', $event->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary" id="event-submit" onclick="event.preventDefault(); this.closest('form').submit();">Confirmar Presença</a>
                    </form>
                <?php else: ?>
                    <?php if($status == 0): ?>
                        <p class="aguard-joined-msg">Solicitação enviada!</p>
                    <?php elseif($status == 1): ?>
                        <p class="already-joined-msg">Você está participando deste evento!</p>
                            
                        <a href="<?php echo e($googleMapsUrl); ?>" target="_blank" class="btn-map">
                            <ion-icon name="map-outline"></ion-icon>
                            Ver Local
                        </a>

                        <a class="btn-map" onclick="addToGoogleCalendar('<?php echo e(date('d/m/Y', strtotime($event->date))); ?>', '<?php echo e($event->time); ?>', '<?php echo e($event->title); ?>', '<?php echo e($event->description); ?>', '<?php echo e($enderecoCompleto); ?>')">
                            <ion-icon name="map-outline"></ion-icon>
                            Agendar evento
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                
                <h3>O evento conta com:</h3>
                
                <ul id="items-list">
                    <?php $__currentLoopData = $event->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><ion-icon name="play-outline"></ion-icon><span><?php echo e($item); ?></span></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description"><?php echo e($event->description); ?></p>
            </div>

            <div class="col-md-12" id="description-container">
                <h3>Galeria do evento:</h3>
                
                <div class="row">
                    <?php $__currentLoopData = $gallerys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-2 col-sm-2 col-6 gallery-column">
                        <div class="gallery-image-wrapper">
                            <img src="<?php echo e(asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path)); ?>" 
                                class="gallery-image" 
                                alt="Imagem do evento" 
                                data-toggle="modal" 
                                data-target="#imageModal<?php echo e($gallery->id); ?>" />
                        </div>
                    </div>

                    <div class="modal fade" id="imageModal<?php echo e($gallery->id); ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel<?php echo e($gallery->id); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel<?php echo e($gallery->id); ?>">Visualizar Imagem</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="<?php echo e(asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path)); ?>" 
                                        class="img-fluid" 
                                        alt="Imagem do evento completo" />
                                </div>
                                <div class="modal-footer">
                                    <a href="<?php echo e(asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path)); ?>" 
                                    download 
                                    class="btn btn-primary">
                                    Baixar Imagem
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/show.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/projetoEvento/resources/views/events/show.blade.php ENDPATH**/ ?>