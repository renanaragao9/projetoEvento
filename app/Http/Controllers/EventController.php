<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //home da pagina
    public function index() {
        
        $events = Event::all();

        return view('welcome', ['events' => $events]);
    }

    //Retorna a pagina de criação de evento
    public function create() {
        return view('events.create');
    }

    //Retorna os dados enviados da pagina de criação
    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }


}
