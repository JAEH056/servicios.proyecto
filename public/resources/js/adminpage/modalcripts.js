// Event listener for modal show
const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const roleName = button.getAttribute('data-role'); // Extract role name
    const deleteUrl = button.getAttribute('data-url'); // Extract delete URL

    // Update modal content
    const roleNameSpan = deleteModal.querySelector('#roleName');
    const confirmDeleteButton = deleteModal.querySelector('#confirmDeleteButton');

    roleNameSpan.textContent = roleName;
    confirmDeleteButton.setAttribute('href', deleteUrl);
});