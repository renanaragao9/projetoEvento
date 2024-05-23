@extends('layouts.main')

@section('title', 'teste')

@section('content')
<div class="container">
    <h1>Solicitações Pendentes para {{ $event->title }}</h1>

    <form action="{{ route('events.approveAllRequests', $event->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Aprovar Tudo</button>
    </form>

    @if($pendingRequests->isEmpty())
        <p>Não há solicitações pendentes.</p>
    @else
        <ul>
            @foreach($pendingRequests as $request)
                <li>
                    {{ $request->name }}
                    <form action="{{ route('events.approveRequest', [$event->id, $request->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success"><ion-icon name="checkbox-outline" id="peding-button"></ion-icon></button>
                    </form>
                    <form action="{{ route('events.rejectRequest', [$event->id, $request->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger"><ion-icon name="close-circle-outline" id="peding-button"></ion-icon></button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection