<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\File;

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
            $statusInfo = $this->obterStatusDoEvento($event->date);
            $event->status = $statusInfo['status'];
            $event->classe = $statusInfo['classe'];
            
        }


        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    //Retorna a pagina de criação de evento
    public function create() {
        return view('events.create');
    }

    //Retorna os dados enviados da pagina de criação
    public function store(Request $request) {

        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'cep' => 'required|string|max:255',
            'private' => 'required|boolean',
            'time' => 'required|date_format:H:i',
            'description' => 'required|string',
            'items' => 'required|array',
            'items.*' => 'string|max:255',
        ], [
            'title.required' => 'Preencha o título',
            'date.required' => 'Preencha a data',
            'cep.required' => 'Preencha o CEP',
            'private.required' => 'Selecione se o evento é privado ou não',
            'time.required' => 'Preencha o horário',
            'description.required' => 'Preencha a descrição',
            'items.required' => 'Preencha pelo menos um item',
            'items.*.required' => 'Preencha todos os itens',
        ]);

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->cep = $request->cep;
        $event->road = $request->road;
        $event->num = $request->num;
        $event->neighborhood = $request->neighborhood;
        $event->city = $request->city;
        $event->state = $request->state;
        $event->private = $request->private;
        $event->time = $request->time;
        $event->description = $request->description;
        $event->items = $request->items;

        $images = [];
        if($request->hasFile('image')) {
            foreach($request->file('image') as $image) {
                if ($image->isValid()) {
                    $extension = $image->extension();
                    $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $image->move(public_path('img/events'), $imageName);
                    $images[] = $imageName;
                }
            }
        }
    
        // Convertendo o array de nomes de arquivos de imagens para JSON
        $event->image = json_encode($images);

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

        $status = 0;

        $enderecoCompleto = "{$event->road}, {$event->num}, {$event->neighborhood}, {$event->city}, {$event->state}, {$event->cep}";
        $enderecoEncode = urlencode($enderecoCompleto);
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$enderecoEncode}";
        
        if($user) {
            
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id) {
                    $confirm = $event->users()->withPivot('confirm')->get()->toArray();
                    $status = $confirm[0]['pivot']['confirm'];
                    $hasUserJoined = true;
                    
                }
            }
        }
        
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined, 'googleMapsUrl' => $googleMapsUrl, 'enderecoCompleto' => $enderecoCompleto, 'status' => $status]);
    }

    // Função para manipular os dados na dashboard
    public function dashboard() {
        
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsAsParticipant' => $eventsAsParticipant]);
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
        $event = Event::findOrFail($id);

        if ($event->private == 0) {
            $user->eventsAsParticipant()->attach($id, ['confirm' => false, 'date_confirm' => null]);
            return redirect()->back()->with('msg', 'Sua solicitação para entrar no evento ' . $event->title . ' está pendente de aprovação.');
        } else {
            $user->eventsAsParticipant()->attach($id, ['confirm' => true, 'date_confirm' => now()]);
            return redirect()->back()->with('msg', 'Sua presença está confirmada no evento ' . $event->title . '!');
        }
    }

    public function showPendingRequests($eventId) {
        $event = Event::findOrFail($eventId);

        // Verifica se o usuário logado é o dono do evento
        if (auth()->user()->id != $event->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para ver essas solicitações.');
        }

        $pendingRequests = $event->users()->wherePivot('confirm', false)->get();

        return view('events.pendingRequests', ['event' => $event, 'pendingRequests' => $pendingRequests]);
    }

    public function approveRequest($eventId, $userId) {
        $event = Event::findOrFail($eventId);

        if (auth()->user()->id != $event->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para aprovar essa solicitação.');
        }

        $event->users()->updateExistingPivot($userId, ['confirm' => true, 'date_confirm' => now()]);

        return redirect()->back()->with('msg', 'Solicitação aprovada.');
    }

    public function rejectRequest($eventId, $userId) {
        
        $event = Event::findOrFail($eventId);
        $user = auth()->user();

        if (auth()->user()->id != $event->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para rejeitar essa solicitação.');
        }

        $event->users()->detach($userId);
        $user->eventsAsParticipant()->detach($userId);

        return redirect()->back()->with('msg', 'Solicitação rejeitada.');
    }

    public function approveAllRequests($eventId) {
        $event = Event::findOrFail($eventId);
    
        // Verifica se o usuário logado é o dono do evento
        if (auth()->user()->id != $event->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para aprovar essas solicitações.');
        }
    
        // Aprova todas as solicitações pendentes de uma vez
        $event->users()->wherePivot('confirm', false)->update(['confirm' => true, 'date_confirm' => now()]);
    
        return redirect()->back()->with('msg', 'Todas as solicitações foram aprovadas.');
    }

     // Função para retirar a presença do usuario no evento
    public function leaveEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title) . "!";
    }

    //Função para deletar um evento
    public function destroy($id) {
        
        $event = Event::findOrFail($id);
    
        
        if (!empty($event->image)) {
            
            $images = json_decode($event->image, true);
    
            $imageFolder = public_path('img/events/');
    
            foreach ($images as $imageName) {
                $imagePath = $imageFolder . $imageName;
                
                if (file_exists($imagePath)) {
                    
                    unlink($imagePath);
                }
            }
        }
    
        
        $event->users()->detach();
    
        
        $event->delete();
    
        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
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
        $status = '';
        $classe = '';

        if ($data > $hoje) {
            $status = 'Aberto';
            $classe = 'card-icon-green';
        } elseif ($data == $hoje) {
            $status = 'Hoje';
            $classe = 'card-icon-yellow';
        } else {
            $status = 'Fechado';
            $classe = 'card-icon-red';
        }

        return ['status' => $status, 'classe' => $classe];
    }

}
