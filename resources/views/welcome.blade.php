@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

    <div class="col-md-12" id="search-container">
        <h1>Busque um evento</h1>
        <form action="/" method="GET">
            <input type="text" name="search" class="form-control" id="search" placeholder="Procurar...">
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
                    <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
                    <div class="card-body">
                        <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-participants"> {{ count($event->users) }} Participantes</p>
                        <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            @endforeach
            
            @if(count($events) == 0 && $search)
                <p>Não foi possível encontrar nenhum evento com {{ $search }}! <a href="/">Ver todos</a></p>
            @elseif(count($events) == 0)
                <p>Não há eventos disponíveis</p>
            @endif
        </div>
    </div>
@endsection
  