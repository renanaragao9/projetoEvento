@extends('layouts.main')

@section('title', 'Renan´s Eventos')

@section('content')

    <div class="col-md-12" id="search-container">
        <h1>Busque um evento</h1>
        <form action="{{route('inicio')}}" method="GET">
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
        @if($search)
            <h2>Buscando por: {{ $search }}</h2>
        @else
            <h2>Próximos Eventos</h2>
            <p class="subtitle">Veja os eventos dos próxims dias</p>
        @endif

        <div class="row" id="cards-container">
            @foreach ($events as $event)
                <div class="card col-md-3">
                    
                    <img src="{{ asset('img/events/' . $event->image) }}" alt="{{ $event->title }}">
                    <ion-icon name="logo-ionic" class="position-absolute top-0 translate-middle m-3" id="{{$event->classe}}"></ion-icon>

                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-info">Status: {{ $event->status }}</p>
                        <p class="card-info">Data: {{ date('d/m/Y', strtotime($event->date))}} ({{$event->diaDaSemana}})</p>
                        <p class="card-info">Local: {{ $event->city }}</p>
                        <p class="card-info">Participantes: {{ count($event->users) }}</p>
                        <a href="{{ route('verEvento', $event->id) }}" class="btn btn-primary" id="card-button">Saber Mais</a>
                    </div>
                </div>
            @endforeach
            
            @if(count($events) == 0 && $search)
                <p>Não foi possível encontrar nenhum evento com {{ $search }}! <a href="{{ route('inicio') }}">Ver todos</a></p>
            @elseif(count($events) == 0)
                <p>Não há eventos disponíveis</p>
            @endif
        </div>
    </div>
@endsection
  