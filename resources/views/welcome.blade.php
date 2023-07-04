@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

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
            @foreach ($events as $event)
                <div class="card col-md-3">
                    <img src="/img/card.jpg" alt="{{ $event->title }}">
                    <div class="card-body">
                        <p class="card-date">10/09/2023</p>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-participants">X Participantes</p>
                        <a href="#" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            @endforeach
        </div>
     </div>
@endsection
  