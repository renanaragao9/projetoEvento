@extends('layouts.main')

@section('title', 'Criar Evento')

@section('content')
    
    <div class="col-md-6 offset-md-3" id="event-create-container">
        <h1>Crie o seu evento</h1>
        <form action="{{ route('enviarEvento') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Nome do evento" required>
            </div>

            <div class="form-group">
                <label for="title">Data do evento:</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>

            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="tel" name="cep" class="form-control" id="cep" placeholder="CEP" required>
            </div>
            
            <div class="form-group">
                <label for="road">Rua:</label>
                <input type="text" name="road" class="form-control" id="rua" placeholder="Rua">
            </div>
            
            <div class="form-group">
                <label for="num">Número:</label>
                <input type="text" name="num" class="form-control" id="numero" placeholder="Número">
            </div>
            
            <div class="form-group">
                <label for="neighborhood">Bairro:</label>
                <input type="text" name="neighborhood" class="form-control" id="bairro" placeholder="Bairro">
            </div>
            
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" name="city" class="form-control" id="cidade" placeholder="Cidade">
            </div>
            
            <div class="form-group">
                <label for="state">Estado:</label>
                <input type="text" name="state" class="form-control" id="estado" placeholder="Estado">
            </div>
            

            <div class="form-group">
                <label for="title">O evento é privado ?:</label>
                <select name="private" id="private" class="form-control" required>
                    <option value="1">Não</option>
                    <option value="0">Sim</option>
                </select>
            </div>

            <div class="form-group">
                <label for="horario">Horário:</label>
                <input type="time" name="time" class="form-control" id="horario" placeholder="Horário" required>
            </div>

            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento ?" required></textarea>
            </div>

            <div class="form-group">
                <label for="title">Adicione itens de infraestrutura:</label>

                <div id="checkbox-list" class="checkbox-item">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
                        </label>
                    </div>
                
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="items[]" value="Palco"> Palco
                        </label>
                    </div>
                
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="items[]" value="Open Bar"> Open Bar
                        </label>
                    </div>
                
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="items[]" value="Open Food"> Open Food
                        </label>
                    </div>
                
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="items[]" value="Brindes"> Brindes
                        </label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <input type="text" id="new-item" class="form-control" placeholder="Adicionar novo item">
                    <button type="button" id="add-item" class="btn btn-primary mt-2">Adicionar Item</button>
                </div>
            </div>

            <div class="form-group">
                <label for="images">Imagens do Evento (Máximo de 5 imagens):</label>
                <input type="file" name="image[]" class="form-control-file" id="images" multiple accept="image/*">
            </div>
            
            <div id="preview"></div>
            
            <input type="submit" class="btn btn-primary" id="button-create" value="Criar Evento!">
        </form>
    </div>
    <script src="{{ asset('js/create.js') }}"></script>
@endsection
