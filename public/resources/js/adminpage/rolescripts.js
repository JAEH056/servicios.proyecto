// Add event listener to the delete button
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listeners to delete buttons
    document.querySelectorAll('.delete-role-permission').forEach(button => {
        button.addEventListener('click', function () {
            const roleId = this.getAttribute('data-role-id');
            const permissionId = this.getAttribute('data-permission-id');

            if (confirm('Are you sure you want to delete this assignment?')) {
                fetch('/admin/deleteRolePermission', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        role_id: roleId,
                        permission_id: permissionId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the corresponding table row
                            const row = document.getElementById(`row-${roleId}-${permissionId}`);
                            if (row) row.remove();
                            alert(data.message);
                        } else {
                            alert(data.message || 'Failed to delete the assignment.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the assignment.');
                    });
            }
        });
    });
});