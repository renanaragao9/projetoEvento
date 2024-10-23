@extends('layouts.main')

@section('title', $event->title)

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-6" id="image-container">
                @if ($event->image)
                    @php
                        $images = json_decode($event->image);
                    @endphp
            
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="position-relative">
                                        <img src="{{ asset('img/events/' . $image) }}" class="d-block w-100" id="show-image" alt="{{ $event->title }}">
                                        <a href="{{ asset('img/events/' . $image) }}" data-lightbox="event-gallery" data-title="{{ $event->title }}" class="btn btn-zoom d-none"></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            
                    <!-- Adicione os controles abaixo do carousel com o botão de tela cheia no centro -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="prev">Anterior</a>
                        <a class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="next">Próximo</a>
                    </div>
                @endif
            </div>
                        
            
            <div class="col-md-6" id="info-container">
                <h1>{{ $event->title }}</h1>
                
                <p class="event-city"><ion-icon name="location-outline"></ion-icon>{{ $event->city }}</p>
                
                <p class="event-city"><ion-icon name="calendar-outline"></ion-icon>{{ date('d/m/Y', strtotime($event->date))}}</p>
                
                <p class="event-city"><ion-icon name="time-outline"></ion-icon>{{ $event->time }}</p>
               
                @if($event->private == 0)
                    <p class="event-city"><ion-icon name="bag-outline"></ion-icon>Privado</p>
                @else
                    <p class="event-city"><ion-icon name="earth-outline"></ion-icon>Público</p>
                @endif
                
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon>{{ count($event->users) }} Participantes</p>
                
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon>{{ $eventOwner['name'] }}</p>
                
                @if(!$hasUserJoined)
                    <form action=" {{ route('entrarEvento', $event->id) }}" method="POST">
                        @csrf
                        <a href="" class="btn btn-primary" id="event-submit" onclick="event.preventDefault(); this.closest('form').submit();">Confirmar Presença</a>
                    </form>
                @else
                    @if($status == 0)
                        <p class="aguard-joined-msg">Solicitação enviada!</p>
                    @elseif($status == 1)
                        <p class="already-joined-msg">Você está participando deste evento!</p>
                            
                        <a href="{{ $googleMapsUrl }}" target="_blank" class="btn-map">
                            <ion-icon name="map-outline"></ion-icon>
                            Ver Local
                        </a>

                        <a class="btn-map" onclick="addToGoogleCalendar('{{ date('d/m/Y', strtotime($event->date))}}', '{{ $event->time }}', '{{$event->title}}', '{{$event->description}}', '{{$enderecoCompleto}}')">
                            <ion-icon name="map-outline"></ion-icon>
                            Agendar evento
                        </a>
                    @endif
                @endif
                
                <h3>O evento conta com:</h3>
                
                <ul id="items-list">
                    @foreach ($event->items as $item)
                        <li><ion-icon name="play-outline"></ion-icon><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>

            <div class="col-md-12" id="description-container">
                <h3>Galeria do evento:</h3>
                
                <div class="row">
                    @foreach($gallerys as $gallery)
                    <div class="col-md-2 col-sm-2 col-6 gallery-column">
                        <div class="gallery-image-wrapper">
                            <img src="{{ asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path) }}" 
                                class="gallery-image" 
                                alt="Imagem do evento" 
                                data-toggle="modal" 
                                data-target="#imageModal{{$gallery->id}}" />
                        </div>
                    </div>

                    <div class="modal fade" id="imageModal{{$gallery->id}}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{$gallery->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel{{$gallery->id}}">Visualizar Imagem</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path) }}" 
                                        class="img-fluid" 
                                        alt="Imagem do evento completo" />
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path) }}" 
                                    download 
                                    class="btn btn-primary">
                                    Baixar Imagem
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/show.js') }}"></script>
@endsection