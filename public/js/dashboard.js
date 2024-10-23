document.getElementById('searchInput').addEventListener('input', function() {

    const searchValue = this.value.toLowerCase();
    const table = document.getElementById('eventsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    let hasResults = false;

    document.getElementById('noResultsMessage').style.display = 'none';

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let rowText = '';

        for (let j = 0; j < cells.length; j++) {
            rowText += cells[j].innerText.toLowerCase() + ' ';
        }

        if (rowText.includes(searchValue)) {
            rows[i].style.display = ''; 
            hasResults = true;
        } else {
            rows[i].style.display = 'none';
        }
    }

    if (!hasResults) {
        document.getElementById('noResultsMessage').style.display = 'block';
    }
});

document.getElementById('searchInput2').addEventListener('input', function() {
    
    const searchValue = this.value.toLowerCase();
    const table = document.getElementById('eventsTableParticipants');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    let hasResults = false;

    document.getElementById('noResultsMessage').style.display = 'none';

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let rowText = '';

        for (let j = 0; j < cells.length; j++) {
            rowText += cells[j].innerText.toLowerCase() + ' ';
        }

        if (rowText.includes(searchValue)) {
            rows[i].style.display = '';
            hasResults = true;
        } else {
            rows[i].style.display = 'none';
        }
    }

    if (!hasResults) {
        document.getElementById('noResultsMessageParticipant').style.display = 'block';
    }
});

function setEventId(id) {
    document.getElementById('eventId').value = id;
    document.getElementById('imageUploadForm').action = '/events/' + id + '/galleries';
}

document.getElementById('images').addEventListener('change', function () {
    const fileInput = this;
    const maxFiles = 50;
    const fileCount = fileInput.files.length;

    const messageDiv = document.getElementById('imageCountMessage');
    
    // Limitar o número de arquivos selecionados
    if (fileCount > maxFiles) {
        messageDiv.textContent = 'Você pode selecionar no máximo ' + maxFiles + ' imagens.';
        messageDiv.style.display = 'block';
        fileInput.value = ''; // Limpa o campo de entrada
    } else {
        messageDiv.style.display = 'none'; // Esconde a mensagem de erro se o número estiver dentro do limite
    }
});

