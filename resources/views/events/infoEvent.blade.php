@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Informações sobre o evento: {{ $event->title }}</h1>

        <button class="btn btn-primary" id="backButton">
            <i class="fas fa-arrow-left"></i> Voltar
        </button>
    </div>

    <div class="col-md-10 offset-md-1 dashboard-events-container">
       
        <h5 id="info-sub-titulo">Tabela de participantes</h5>
        
        @if(count($users) > 0)
            <div class="table-responsive">
                <div class="input-group w-50 mb-3">
                    
                    <input type="text" id="searchInput" class="form-control" placeholder="Pesquisa...">
                    
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="searchButton" type="button">
                            Pesquisar
                        </button>
                    </div>
                </div>
                
                <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
                    Nenhuma pessoa com esse nome encontrado.
                </div>
                
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data da confirmação</th>
                            <th scope="col">Situação</th>
                            <th scope="col" colspan="2">Ações</th>
                        </tr>
                    </thead>
                
                    <tbody id="eventsTableBody">
                        @foreach($users as $user)
                            <tr>
                                <td class="user-id">{{ $user->id }}</td>
                                <td class="user-name">{{ $user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->date_confirm)->format('d/m/Y') }}</td>
                                <td>{{ $user->confirm ? 'Aprovado' : 'Reprovado' }}</td>
                                <td>
                                    @if($user->confirm == true)
                                        {{--  Botão para rejeitar  --}}
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModalReject" title="Excluír da lista">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    @else
                                        {{--  Botão para aprovar  --}}
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModalApprove" title="Incluir na lista">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    @endif
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
    
    <div class="col-md-10 offset-md-1 dashboard-events-container mt-3">

        <h5 id="info-sub-titulo">Tabela de Imagens do evento</h5>     

        @if(count($gallerys) > 0)
            <div class="table-responsive">      
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Imagem</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                
                    <tbody id="eventsTableBody">
                        @foreach($gallerys as $gallery)
                            <tr>
                                <td>{{ $gallery->id }}</td>
                                
                                <td>{{ $gallery->image_path }}</td>
                                
                                <td>
                                    <img src="{{ asset('img/gallery/' . $gallery->image_folder . '/' . $gallery->image_path) }}" class="gallery-image-circle" alt="Gallery Image" data-id="{{ $gallery->id }}" data-folder="{{ $gallery->image_folder }}" data-path="{{ $gallery->image_path }}" onclick="openModal(this)">
                                </td>
                                
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModalDelete" data-image-id="{{ $gallery->id }}" title="Excluír">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModalDeleteAll" data-event-folder="{{ $gallerys[0]->image_folder }}" title="Excluir Tudo">
                    <i class="fas fa-trash-alt"></i> Excluir Tudo
                </button> 
            </div>   
        @else
            <p>Evento ainda não possui galeria de fotos</p>
        @endif
    </div>

    <!-- Modal para Aprovação -->
    <div class="modal fade" id="confirmModalApprove" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmação de Aprovação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    Você tem certeza que deseja incluir este usuário na lista de convidados ?
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="confirmApproveButton">
                        <span id="approveSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Rejeição -->
    <div class="modal fade" id="confirmModalReject" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmação de Rejeição</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    Você tem certeza que deseja excluír este usuário da lista de convidados ?
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectButton">
                        <span id="rejectSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Imagem Completa</h5>
                    
                    <!-- Botão de fechar atualizado -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gallery Image Full">
                </div>
                
                <div class="modal-footer">
                    
                    <!-- Botão Fechar do Footer -->
                    <button type="button" id="downloadButton" class="btn btn-primary">Baixar Imagem</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação para Exclusão -->
    <div class="modal fade" id="confirmModalDelete" tabindex="-1" aria-labelledby="confirmModalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalDeleteLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir esta imagem?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteImageForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação para Exclusão de Todas as Imagens -->
    <div class="modal fade" id="confirmModalDeleteAll" tabindex="-1" aria-labelledby="confirmModalDeleteAllLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalDeleteAllLabel">Confirmar Exclusão de Todas as Imagens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir todas as imagens e a pasta do evento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteAllImagesForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir Tudo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Formulários escondidos para submissão -->
    <form id="approveForm" action="{{ route('events.approveRequest', [$event->id, $user->id]) }}" method="POST" style="display:none;">
        @csrf
    </form>

    <form id="rejectForm" action="{{ route('events.rejectRequest', [$event->id, $user->id]) }}" method="POST" style="display:none;">
        @csrf
    </form>

    <script src="{{ asset('js/infoEvent.js') }}"></script>
@endsection