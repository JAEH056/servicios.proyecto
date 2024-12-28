// Script AJAX para manejo de eliminacion de Roles y Permisos asignados a roles
document.addEventListener('DOMContentLoaded', function () {
    // Se inicializan las variables de Tipo de eliminacion y el ID eliminado (Roles)
    let currentDeleteType = null;
    let currentDeleteId = null;

    // Event listener for delete buttons // Funcion de escucha para los botones de eliminar
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            currentDeleteType = this.getAttribute('data-type');
            currentDeleteId = this.getAttribute('data-id');

            // Show the modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });
    });

    // Handle delete confirmation  // Ejercisio para realizar la eliminacion
    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (currentDeleteType && currentDeleteId) {
            let endpoint = '';
            let payload = {};

            // Determine the endpoint and payload based on the type
            // Se determina la informacion entregada y el curso a seguir basado en el tipo de accion
            switch (currentDeleteType) {
                case 'role':
                    endpoint = '/admin/deleteRole';
                    payload = { role_id: currentDeleteId };
                    break;
                case 'role-permission':
                    const [roleId, permissionId] = currentDeleteId.split('-');
                    endpoint = '/admin/deleteRolePermission';
                    payload = { role_id: roleId, permission_id: permissionId };
                    break;
                case 'user-role':
                    const [UserID, RoleID] = currentDeleteId.split('-');
                    endpoint = '/admin/deleteUserRole';
                    payload = {user_id: UserID, role_id: RoleID };
                    break;
                default:
                    console.error('Unknown delete type:', currentDeleteType);
                    alert('Unknown delete type.');
                    return; // Exit if the type is unknown
            }

            // Send the AJAX request // Se envia la solicitud AJAX
            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remove the corresponding row or item // Se elimina la fila eliminada
                        if (currentDeleteType === 'role') {
                            document.querySelector(`#roles-list [data-id="${currentDeleteId}"]`).closest('li').remove();
                        } else if (currentDeleteType === 'role-permission') {
                            document.querySelector(`[data-id="${currentDeleteId}"]`).closest('tr').remove();
                        }
                        alert(data.message);
                    } else {
                        alert(data.message || 'Failed to delete the item.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the item.');
                });
        }

        // Hide the modal  // Se oculta el MODAL
        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        deleteModal.hide();
    });
});