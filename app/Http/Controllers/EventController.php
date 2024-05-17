<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    //home da pagina
    public function index() {
        
        $search = request('search');

        if($search) {
            
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

        } else {
            $events = Event::all();
        }

        // Loop para pegar o dia da semana
        foreach ($events as $event) { 
            $event->diaDaSemana = $this->obterDiaDaSemana($event->date);
            $event->status = $this->obterStatusDoEvento($event->date);
        }


        return view('welcome', ['events' => $events, 'search' => $search]);
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

        // Pega o id do usuario logado
        $user = auth()->user();
        $event->user_id = $user->id;

        // Salva os dados no banco
        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    // Função para acessar os dados do evento
    public function show($id) {
        
        $event = Event::findOrFail($id);

        $user = auth()->user();

        $hasUserJoined = false;

        if($user) {
            
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
    }

    // Função para manipular os dados na dashboard
    public function dashboard() {
        
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsAsParticipant' => $eventsAsParticipant]);
    }

    //Função para deletar um evento
    public function destroy($id) {
        
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    //Função para rota de edição de um evento
    public function edit($id) {

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    //Função para edição de um evento
    public function update(Request $request) {

        $data = $request->all();

            // Image Upload
            if($request->hasFile('image') && $request->file('image')->isValid()) {
                
                $requestImage = $request->image;

                $extension = $requestImage->extension();

                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                $requestImage->move(public_path('img/events'), $imageName);

                $data['image'] = $imageName;
            }
        
        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    // Função para confirmar a presença do usuario no evento
    public function joinEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento' . $event->title) . "!";
    }

     // Função para retirar a presença do usuario no evento
    public function leaveEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title) . "!";
    }

    private function obterDiaDaSemana($data) {
        
        // Array com os dias da semana em português
        $diasDaSemana = [
            'domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'
        ];
        
        // Converte a data para timestamp
        $timestamp = strtotime($data);
        
        // Obtém o índice do dia da semana (0 para domingo, 6 para sábado)
        $diaDaSemanaIndice = date('w', $timestamp);
        
        // Retorna o nome do dia da semana a partir do índice
        return $diasDaSemana[$diaDaSemanaIndice];
    }

    private function obterStatusDoEvento($data) {
        
        $hoje = date('Y-m-d');
        
        if ($data > $hoje) {
            return 'Aberto';
        } elseif ($data == $hoje) {
            return 'Hoje';
        } else {
            return 'Fechado';
        }
    }

}
