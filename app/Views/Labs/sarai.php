<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
   </button>

   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5" id="exampleModalLabel">Select Career</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <!-- Select element for careers -->
               <form>
                  <div class="mb-3">
                     <label for="carrera" class="form-label">Choose a career:</label>
                     <select class="form-select" id="carrera">
                        <option value="">Loading...</option>
                     </select>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Save changes</button>
            </div>
         </div>
      </div>
   </div>

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <!-- Bootstrap JS (includes Popper.js) -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

   <!-- <script>
      $(document).ready(function () {
         // Cargar las carreras al abrir el modal
         $('#exampleModal').on('show.bs.modal', function () {
            $.ajax({
               url: '// Cambia esta URL
               method: 'GET',
               dataType: 'json',
               success: function (data) {
                  // Limpiar el select antes de agregar nuevas opciones
                  $('#carrera').empty();
                  // Agregar las opciones de carrera
                  if (data.carrera && data.carrera.length > 0) {
                     $.each(data.carrera, function (index, carrera) {
                        $('#carrera').append($('<option>', {
                           value: id, // Cambia según tu estructura de datos
                           text: nombre_carrera // Cambia según tu estructura de datos
                        }));
                     });
                  } else {
                     $('#carrera').append('<option value="">No careers available</option>');
                  }
               },
               error: function (xhr, status, error) {
                  console.error('Error al cargar las carreras:', error);
                  $('#carrera').html('<option value="">Error loading options</option>');
               }
            });
         });
      });
   </script> -->
   <script>
   $(document).ready(function () {
      // Cargar las carreras al abrir el modal
      $('#exampleModal').on('show.bs.modal', function () {
         var carreras = <?php echo $carrerasJson; ?>;
         
         // Verificar que los datos se están cargando correctamente
        
         // Limpiar el select antes de agregar nuevas opciones
         $('#carrera').empty();

         // Verificar si 'carreras' contiene datos
         if (carreras && carreras.length > 0) {
            $.each(carreras, function (index, carrera) {
               $('#carrera').append($('<option>', {
                  value: carrera.id, // Asegúrate de usar la propiedad correcta
                  text: carrera.nombre_carrera // Asegúrate de que 'nombre_carrera' exista
               }));
            });
         } else {
            $('#carrera').append('<option value="">No careers available</option>');
         }
      });
   });
</script>


</body>
</html>
