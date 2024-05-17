@extends('layouts.main')

@section('title', 'Criar Evento')

@section('content')
    
    <div class="col-md-6 offset-md-3" id="event-create-container">
        <h1>Crie o seu evento</h1>
        <form action="{{ route('enviarEvento') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Nome do evento">
            </div>

            <div class="form-group">
                <label for="title">Data do evento:</label>
                <input type="date" name="date" class="form-control" id="date">
            </div>

            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="tel" name="cep" class="form-control" id="cep" placeholder="CEP">
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
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>

            <div class="form-group">
                <label for="horario">Horário:</label>
                <input type="time" name="time" class="form-control" id="horario" placeholder="Horário">
            </div>

            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento ?"></textarea>
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
                <input type="file" name="images[]" class="form-control-file" id="images" multiple accept="image/*">
            </div>
            
            <div id="preview"></div>
            
            <input type="submit" class="btn btn-primary" id="button-create" value="Criar Evento!">
        </form>
    </div>

    <script>

        document.getElementById('cep').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });

        document.getElementById('cep').addEventListener('blur', function() {
            var cep = this.value.replace(/\D/g, '');
        
            if (cep.length === 8) {
                var url = `https://viacep.com.br/ws/${cep}/json/`;
        
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!('erro' in data)) {
                            document.getElementById('rua').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            alert("CEP não encontrado.");
                        }
                    })
                    .catch(error => {
                        alert("Erro ao buscar o CEP. Tente novamente mais tarde.");
                        console.error("Erro ao buscar o CEP: ", error);
                    });
            } else {
                alert("Formato de CEP inválido.");
            }
        });

        document.getElementById('add-item').addEventListener('click', function() {
            var newItem = document.getElementById('new-item').value.trim();
            if (newItem) {
                var checkboxList = document.getElementById('checkbox-list');

                // Cria um novo elemento de checkbox
                var newCheckbox = document.createElement('div');
                newCheckbox.classList.add('form-group');
                newCheckbox.innerHTML = `<label> <input type="checkbox" name="items[]" value="${newItem}"> ${newItem} </label>`;

                // Adiciona o novo checkbox à lista
                checkboxList.appendChild(newCheckbox);

                // Limpa o campo de entrada
                document.getElementById('new-item').value = '';
            }
        });


        document.getElementById('images').addEventListener('change', handleFileSelect, false);

        function handleFileSelect(event) {
            const files = event.target.files;
            const preview = document.getElementById('preview');

            preview.innerHTML = ''; // Limpa a visualização anterior

            if (files.length > 5) {
                alert('Por favor, selecione no máximo 5 imagens.');
                event.target.value = ''; // Limpa a seleção de imagens
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const imageTypeRegExp = /^image\//;

                if (!imageTypeRegExp.test(file.type)) {
                    alert('Por favor, selecione apenas imagens.');
                    event.target.value = ''; // Limpa a seleção de imagens
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    const imgContainer = document.createElement('div');
                    const img = document.createElement('img');
                    const closeButton = document.createElement('button');
                    const icon = document.createElement('ion-icon');

                    img.src = event.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';

                    closeButton.addEventListener('click', function() {
                        imgContainer.remove();
                    });

                    icon.setAttribute('name', 'close');
                    icon.setAttribute('class', 'icon-close');

                    closeButton.appendChild(icon);
                    imgContainer.appendChild(img);
                    imgContainer.appendChild(closeButton);
                    preview.appendChild(imgContainer);
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
        
@endsection
