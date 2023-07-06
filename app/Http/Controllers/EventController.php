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
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        // Salva os dados no banco
        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    // Função para acessar os dados do evento
    public function show($id) {
        
        $event = Event::findOrFail($id);

        return view('events.show', ['event' => $event]);
    }


}
