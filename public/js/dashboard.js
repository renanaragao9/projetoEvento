const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');
const noResultsMessage = document.getElementById('noResultsMessage');

searchInput.addEventListener('keyup', filterEvents);
searchButton.addEventListener('click', filterEvents);

function filterEvents() {
    const filter = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#eventsTableBody tr');
    let hasResults = false;

    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        const titleCell = cells[1]; // O título do evento está na segunda coluna

        // Verifica se o título contém o texto da pesquisa
        if (titleCell && titleCell.textContent.toLowerCase().includes(filter)) {
            row.style.display = ''; // Mostra a linha
            hasResults = true; // Pelo menos um resultado encontrado
        } else {
            row.style.display = 'none'; // Esconde a linha
        }
    });

    // Atualiza a visibilidade da mensagem de "nenhum resultado"
    if (hasResults) {
        noResultsMessage.style.display = 'none'; // Esconde a mensagem
    } else {
        noResultsMessage.style.display = 'block'; // Mostra a mensagem
    }
}


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

