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
        newCheckbox.innerHTML = `<label> <input type="checkbox" name="items[]" value="${newItem}" checked> ${newItem} </label>`;

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
    const existingImages = preview.querySelectorAll('img').length;

    if (files.length + existingImages > 5) {
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