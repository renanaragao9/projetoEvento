@extends('layouts.main')

@section('title', 'teste')

@section('content')
    <div class="container">
        <div class="col-md-10 offset-md-1 dashboard-events-container mt-3">
            
            <h5 id="info-sub-titulo">Solicitações para entrar no evento ~ {{ $event->title }}</h5>
            
            @if(count($pendingRequests) > 0)
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
                            @foreach($pendingRequests as $request)
                                <tr>
                                    <td>{{ $loop->index + 1}}</td>
                                    
                                    <td>{{ $request->name }}</td>
                                    
                                    <td>
                                        <form action="{{ route('events.approveRequest', [$event->id, $request->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-circle-check"></i></button>
                                        </form>
                                    </td>
                                    
                                    <td>
                                        <form action="{{ route('events.rejectRequest', [$event->id, $request->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-circle-xmark"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>   
            @else
                <p>Evento ainda não possui convidados confirmados</p>
            @endif
        </div>
    </div>
@endsection