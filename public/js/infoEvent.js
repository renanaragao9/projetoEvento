document.getElementById('confirmApproveButton').addEventListener('click', function () {
    var spinner = document.getElementById('approveSpinner');
    spinner.classList.remove('d-none');  // Mostra o spinner
    document.getElementById('approveForm').submit();  // Submete o formulário
});

document.getElementById('confirmRejectButton').addEventListener('click', function () {
    var spinner = document.getElementById('rejectSpinner');
    spinner.classList.remove('d-none');  // Mostra o spinner
    document.getElementById('rejectForm').submit();  // Submete o formulário
});

// Filtro de pesquisa
document.getElementById('searchButton').addEventListener('click', function () {
    filterTable();
});

document.getElementById('searchInput').addEventListener('keyup', function () {
    filterTable();
});

function filterTable() {
    // Input de pesquisa
    var input = document.getElementById('searchInput').value.toLowerCase();
    // Corpo da tabela
    var tableBody = document.getElementById('eventsTableBody');
    // Todas as linhas da tabela
    var rows = tableBody.getElementsByTagName('tr');
    // Variável para contar quantos resultados foram encontrados
    var noResults = true;

    // Loop por cada linha da tabela
    for (var i = 0; i < rows.length; i++) {
        // Coluna do nome do usuário
        var userName = rows[i].getElementsByClassName('user-name')[0].textContent.toLowerCase();
        // Coluna do ID do usuário
        var userId = rows[i].getElementsByClassName('user-id')[0].textContent.toLowerCase();

        // Verifica se o nome ou o ID do usuário contém o texto de pesquisa
        if (userName.includes(input) || userId.includes(input)) {
            rows[i].style.display = ''; // Mostra a linha
            noResults = false; // Encontrou resultados
        } else {
            rows[i].style.display = 'none'; // Esconde a linha
        }
    }

    // Mostra a mensagem "Nenhum evento encontrado" se não houver resultados
    var noResultsMessage = document.getElementById('noResultsMessage');
    if (noResults) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}


// Função para modal da imagem
function openModal(element) {
    const imageFolder = element.getAttribute('data-folder');
    const imagePath = element.getAttribute('data-path');
    
    // Atualiza o src da imagem no modal
    const modalImage = document.getElementById('modalImage');
    modalImage.src = `/img/gallery/${imageFolder}/${imagePath}`; // Caminho relativo

    // Abre o modal
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}