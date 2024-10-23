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

    var input = document.getElementById('searchInput').value.toLowerCase();

    var tableBody = document.getElementById('eventsTableBody');

    var rows = tableBody.getElementsByTagName('tr');

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

document.getElementById('downloadButton').addEventListener('click', function() {
    const imageSrc = document.getElementById('modalImage').src;
    const imageName = imageSrc.substring(imageSrc.lastIndexOf('/') + 1);

    const a = document.createElement('a');
    a.href = imageSrc;
    a.download = imageName;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
});

document.addEventListener('DOMContentLoaded', function () {
    const confirmModalDelete = document.getElementById('confirmModalDelete');
    confirmModalDelete.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imageId = button.getAttribute('data-image-id');

        const deleteForm = document.getElementById('deleteImageForm');
        deleteForm.action = `/gallery/images/${imageId}`;
    });

    const confirmModalDeleteAll = document.getElementById('confirmModalDeleteAll');
    confirmModalDeleteAll.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const eventFolder = button.getAttribute('data-event-folder');

        const deleteForm = document.getElementById('deleteAllImagesForm');
        deleteForm.action = `/gallery/event/delete-all/${eventFolder}`;
    });
});

// Ação do botão voltar
document.getElementById('backButton').addEventListener('click', function() {
    window.history.back(); // Volta para a URL anterior
});