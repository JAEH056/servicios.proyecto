<?= $this->extend('Labs/layouts/principal_docente') ?>

<?= $this->section('include_css') ?>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
<?= $this->endSection() ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/tui-code-snippet@latest/dist/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let datepickerStart;
        let datepickerEnd;

        // Función para manejar el cambio en el selector de laboratorio
        const laboratorioSelector = document.getElementById("seleccionarLaboratorio");
        laboratorioSelector.addEventListener("change", function() {
            const laboratorioId = laboratorioSelector.value;
            if (laboratorioId) {
                window.location.href = `${laboratorioId}`;
            }
        });

        // Elementos del DOM
        const carreraSelector = document.getElementById('event-selector-carrera');
        const carreraIdHidden = document.getElementById('carrera-id-hidden');
        const asignaturaSelector = document.getElementById('event-selector-asignatura');
        const asignaturaIdHidden = document.getElementById('asignatura-id-hidden');
        const claveAsignaturaInput = document.getElementById('event-clave-asignatura');
        const grupoSelector = document.getElementById('event-selector-grupo');
        const grupoIdHidden = document.getElementById('grupo-id-hidden');

        // Función para manejar el cambio en el selector de carrera
        carreraSelector.addEventListener('change', function() {
            const carreraId = carreraSelector.value;
            carreraIdHidden.value = carreraId;
            // Limpiar el selector de asignaturas y grupos al cambiar de carrera
            asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
            grupoSelector.innerHTML = '<option value="">Seleccione un grupo</option>';
            // Limpia el campo de clave de asignatura
            claveAsignaturaInput.value = "";

            if (carreraId) {
                fetch(`/usuario/pr/horario?carreraId=${carreraId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
                        data.asignaturas.forEach(asignatura => {
                            const option = document.createElement('option');
                            option.value = asignatura.id;
                            option.textContent = asignatura.nombre_asignatura;
                            asignaturaSelector.appendChild(option);
                        });

                        // Llama a la función para cargar los grupos
                        cargarGrupos(carreraId);
                    })
                    .catch(() => {
                        asignaturaSelector.innerHTML = '<option value="">Error al cargar asignaturas</option>';
                    });
            } else {
                asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
                grupoSelector.innerHTML = '<option value="">Seleccione un grupo</option>';
            }
        });

        // Función para cargar los grupos en función de la carrera seleccionada
        function cargarGrupos(carreraId) {
            fetch(`/usuario/pr/horario?carreraId=${carreraId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    grupoSelector.innerHTML = '<option value="">Seleccione un grupo</option>';

                    if (data.grupos && data.grupos.length > 0) {
                        data.grupos.forEach(grupo => {
                            const option = document.createElement('option');
                            option.value = grupo.id_grupo;
                            option.textContent = grupo.nombre_grupo;
                            grupoSelector.appendChild(option);
                        });
                    } else {
                        // Si no hay grupos, mostrar un mensaje en el selector
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = "No hay grupos disponibles";
                        grupoSelector.appendChild(option);
                    }
                })
                .catch(() => {
                    grupoSelector.innerHTML = '<option value="">Error al cargar grupos</option>';
                });
        }
        // Función para manejar el cambio en el selector de grupo
        grupoSelector.addEventListener('change', function() {
            const grupoId = grupoSelector.value;
            grupoIdHidden.value = grupoId; // Actualizar el valor del campo oculto con el ID del grupo seleccionado
        });

        // Función para manejar el cambio en el selector de asignatura
        asignaturaSelector.addEventListener('change', function() {
            const asignaturaId = asignaturaSelector.value;
            // Limpia el campo de clave y el campo oculto
            asignaturaIdHidden.value = asignaturaId;
            claveAsignaturaInput.value = "";

            if (asignaturaId) {
                fetch(`/usuario/asignaturaclave/horario?asignaturaId=${asignaturaId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.clave && data.clave.length > 0) {
                            claveAsignaturaInput.value = data.clave[0].claveasignatura || "Clave no disponible";
                        } else {
                            claveAsignaturaInput.value = "Clave no disponible";
                        }
                    })
                    .catch(() => {
                        claveAsignaturaInput.value = "Error al obtener la clave";
                    });
            }
        });
        // -------------------------------------------------------------------------------------------------------------------------------------------------------
        // Lógica del horario
        const Calendar = tui.Calendar;
        const locale = 'es-MX';

        const periodo = JSON.parse('<?= $periodoJson ?>');
        const periodoInicio = new Date(periodo.inicio);
        const periodoFin = new Date(periodo.fin);

        const calendar = new Calendar('#calendar', {
            defaultView: 'week',
            useFormPopup: false,
            useDetailPopup: false,
            week: {
                taskView: false,
                eventView: ['time', 'allday'],
                showNowIndicator: false,
                hourStart: 7,
                hourEnd: 20,
                dayNames: ['Dom', 'Lun', 'Mar', 'Miér', 'Juev', 'Vier', 'Sáb'],
            },
            calendars: [{
                id: 'cal2',
                name: 'Mi Calendario'
            }],
            template: {
                time: function(schedule) {
                    const raw = schedule.raw || {};
                    return `
                        <div>${schedule.title || 'sin titulo'}</div>
                        <div class="event-empleado">${raw.empleado || ''}</div>
                        <div class="event-grupo">${raw.grupo || ''}</div>
                        <div class="event-asignatura">${raw.clave_asignatura || ''}</div>

                        ${raw.objetivo && false ? `<div class="event-objetivo">${raw.objetivo}</div>` : ''}
                        ${raw.carrera && false ? `<div class="event-carrera">${raw.carrera}</div>` : ''}
                        ${raw.tipo_uso && false ? `<div class="event-tipo-uso">${raw.tipo_uso}</div>` : ''}
                        ${raw.descripcion_tareas && false ? `<div class="event-descripcion-tareas">${raw.descripcion_tareas}</div>` : ''}
                        ${raw.estado && false ? `<div class="event-estado">${raw.estado}</div>` : ''}
                    `;
                }
            }
        });

        recargarEventos(calendar);

        const today = new Date();
        if (today >= periodoInicio && today <= periodoFin) {
            calendar.setDate(today);
        } else {
            calendar.setDate(periodoInicio);
        }

        function actualizarRangoFechas() {
            const viewDate = calendar.getDate();
            const startOfWeek = new Date(viewDate);
            const endOfWeek = new Date(viewDate);
            
            startOfWeek.setDate(viewDate.getDate() - viewDate.getDay());
            endOfWeek.setDate(startOfWeek.getDate() + 6);

            const fechaInicioStr = startOfWeek.toLocaleDateString(locale);
            const fechaFinStr = endOfWeek.toLocaleDateString(locale);
            document.querySelector('.navbar--range').textContent = `${fechaInicioStr} - ${fechaFinStr}`;
        }

        actualizarRangoFechas();

        document.querySelector('.prev').addEventListener('click', function() {
            const currentDate = calendar.getDate();
            const newDate = new Date(currentDate.setDate(currentDate.getDate() - 7));
            if (newDate >= periodoInicio) {
                calendar.setDate(newDate);
                actualizarRangoFechas();
            }
        });

        document.querySelector('.next').addEventListener('click', function() {
            const currentDate = calendar.getDate();
            const newDate = new Date(currentDate.setDate(currentDate.getDate() + 7));
            if (newDate <= periodoFin) {
                calendar.setDate(newDate);
                actualizarRangoFechas();
            }
        });

        document.querySelector('.today').addEventListener('click', function() {
            const today = new Date();
            if (today >= periodoInicio && today <= periodoFin) {
                calendar.setDate(today);
                actualizarRangoFechas();
            }
        });

        // Lógica del formulario de creación de eventos
        const tipoSolicitudSelector = document.getElementById('event-selector-solicitud');
        const camposPracticas = document.getElementById('campos-practicas');
        const camposVarias = document.getElementById('campos-varias');
        const form = document.getElementById('eventForm');

        tipoSolicitudSelector.addEventListener('change', function() {
            const tipoSolicitud = this.value;
            // Ocultar todos los campos adicionales
            camposPracticas.style.display = 'none';
            camposVarias.style.display = 'none';

            // Restablecer los valores de los campos en ambas secciones
            const inputsPracticas = camposPracticas.querySelectorAll('input, select, textarea');
            inputsPracticas.forEach(input => input.value = '');

            const inputsVarias = camposVarias.querySelectorAll('input, select, textarea');
            inputsVarias.forEach(input => input.value = '');

            // Mostrar los campos correspondientes al tipo seleccionado
            if (tipoSolicitud === 'practicas') {
                camposPracticas.style.display = 'block';
            } else if (tipoSolicitud === 'varias') {
                camposVarias.style.display = 'block';
            }
        });

        // Mostrar el modal para crear eventos
        calendar.on('selectDateTime', function(event) {
            const modal = new bootstrap.Modal(document.getElementById('createEventModal'));
            resetModalFields();
            modal.show();

            const startDateTime = event.start;
            const endDateTime = new Date(event.start.getTime() + 60 * 60 * 1000);

            // Inicializar el datepicker con timepicker
            const datepickerStart = new tui.DatePicker('#datepicker-start-wrapper', {
                date: startDateTime,
                timePicker: true,
                input: {
                    element: '#datepicker-start-input',
                    format: 'yyyy-MM-dd HH:mm',
                },
            });

            const datepickerEnd = new tui.DatePicker('#datepicker-end-wrapper', {
                date: endDateTime,
                timePicker: true,
                input: {
                    element: '#datepicker-end-input',
                    format: 'yyyy-MM-dd HH:mm',
                },
            });
        });

        function recargarEventos(calendar) {
            fetch('/usuario/eventos/empleados')
                .then(response => response.json())
                .then(data => {
                    console.log('Eventos recargados:', data);  // Verifica la estructura de la respuesta

                    const eventos = data.events;  // Acceder a la propiedad 'events' que contiene los eventos

                    if (Array.isArray(eventos)) {  // Asegurarse de que la respuesta es un array
                        calendar.clear();
                        calendar.createEvents(eventos.map(event => {
                            event.start = new Date(event.start);  // Convertir las fechas a formato Date
                            event.end = new Date(event.end);

                            // Asignar colores de fondo basados en condiciones
                            if (!event.raw.empleado && !event.raw.grupo && !event.raw.clave_asignatura) {
                                event.backgroundColor = '#ff6f00'; // Naranja para dias inhabiles: "sin asignar"
                                event.color = '#ffffff';
                            } else if (event.raw.empleado && (!event.raw.grupo || !event.raw.clave_asignatura)) {
                                event.backgroundColor = '#0059ff'; // Morado para solicitudes varias: "empleado asignado, pero faltan otros datos"
                                event.color = '#ffffff';
                            } else if (event.raw.empleado && event.raw.grupo && event.raw.clave_asignatura) {
                                event.backgroundColor = '#13199a'; // Azul para solicitudes practicas para: "todos los datos completos"
                                event.color = '#ffffff';
                            } else {
                                event.bgColor = '#D3D3D3'; // Gris como color predeterminado
                                event.color = '#FFFFFF';
                            }
                            return event;
                        }));
                    } else {
                        console.error('La respuesta no tiene la propiedad "events" o no es un array:', eventos);
                    }
                })
                .catch(error => console.error('Error al recargar eventos:', error));
        }

        // ------------------------------------------------------------------------------------------------------------------------------------------------------
        // Función que maneja el envío del formulario
        function handleFormSubmit(event) {
            event.preventDefault(); // Previene el envío normal del formulario

            // Obtener el formulario y el campo CSRF
            const form = document.getElementById('eventForm'); // Asegúrate de que el formulario tenga este ID
            const csrfField = document.querySelector('.txt_csrfname'); // Asegúrate de que el campo CSRF tenga esta clase

            if (!csrfField) {
                console.error("No se encontró el campo CSRF");
                return;
            }

            const csrfName = csrfField.name;  // Nombre del campo CSRF
            const csrfHash = csrfField.value; // Valor del token CSRF

            const formData = new FormData(form); // Asegúrate de que 'form' esté correctamente referenciado
            formData.append(csrfName, csrfHash); // Agregar CSRF al FormData

            // Limpiar los errores previos antes de mostrar nuevos errores
            clearPreviousErrors();

            // Realizar la solicitud al servidor
            fetch('/usuario/solicitud', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log("Respuesta del servidor:", data); // Verifica qué se está recibiendo

                if (data.csrf) {
                    csrfField.value = data.csrf;  // Actualizar el CSRF token en el formulario
                }

                // Si hay errores de validación, mostrarlos
                if (data.errors) {
                    let errorMessages = '';
                    for (let field in data.errors) {
                        let fieldErrors = Array.isArray(data.errors[field]) ? data.errors[field] : [data.errors[field]];
                        errorMessages += `${field}: ${fieldErrors.join(', ')}\n`;
                        displayErrorsInUI(field, fieldErrors);
                    }
                }else{
                    // Mostrar el alert y cerrar el modal
                    alert('Solicitud enviada correctamente.');

                    // Cerrar el modal después de hacer clic en OK en el alert
                    const modalElement = document.getElementById('createEventModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                        // window.location.reload(); // Recarga completa de la página
                    }
                    // Reiniciar el formulario
                    resetModalFields();
                    recargarEventos(calendar);
                }
            })
            .catch(error => console.error('Error en la solicitud:', error));
        }

        // Función para limpiar los errores previos antes de mostrar nuevos
        function clearPreviousErrors() {
            const errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(element => element.remove());
        }

        // Función para mostrar los errores en el formulario
        function displayErrorsInUI(field, errors) {
            const inputField = document.querySelector(`[name="${field}"]`);
            if (inputField) {
                const errorContainer = document.createElement('div');
                errorContainer.classList.add('error-message');
                errorContainer.style.color = 'red'; // Estilo de color de error

                errorContainer.innerText = errors.join(', ');  // Mostrar los errores
                inputField.parentNode.appendChild(errorContainer);  // Insertar el contenedor de errores
            }
        }

        // Función para reiniciar los campos del modal al estado inicial
        function resetModalFields() {
            // Ocultar todas las secciones
            camposPracticas.style.display = 'none';
            camposVarias.style.display = 'none';

            // Restablecer selectores y campos
            tipoSolicitudSelector.value = ''; // Restablece el selector principal
            const inputsPracticas = camposPracticas.querySelectorAll('input, select, textarea');
            const inputsVarias = camposVarias.querySelectorAll('input, select, textarea');

            inputsPracticas.forEach(input => input.value = ''); // Limpia los valores en prácticas
            inputsVarias.forEach(input => input.value = '');   // Limpia los valores en varias

            // Restablecer errores visuales
            clearPreviousErrors();
        }
    
        // Agregar un listener de evento para el envío del formulario
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        } else {
            console.error("No se encontró el formulario con ID 'eventForm'");
        }

        calendar.on('clickEvent', function(event) {
            const evento = event.event;
            const colorEvento = evento.backgroundColor;

            // Ocultar todos los modales
            const modals = ['practicaModal', 'solicitudesModal', 'inhabilModal'];
            modals.forEach(modalId => {
                const modalElement = new bootstrap.Modal(document.getElementById(modalId));
                modalElement.hide();
            });

            if (colorEvento === '#13199a') {
                // Mostrar el modal de práctica
                const modal = new bootstrap.Modal(document.getElementById('practicaModal'));
                modal.show();

                // Actualizar campos del modal de práctica
                document.getElementById('empleado').value = evento.raw.empleado || 'Sin asignar';
                document.getElementById('nombre').value = evento.title;
                document.getElementById('objetivo').value = evento.raw.objetivo;
                document.getElementById('carrera').value = evento.raw.carrera;
                document.getElementById('grupo').value = evento.raw.grupo || '';
                document.getElementById('claveAsignatura').value = evento.raw.clave_asignatura || '';
                document.getElementById('estado').value = evento.raw.estado;

            } else if (colorEvento === '#0059ff') {
                // Mostrar el modal de solicitudes varias
                const modal = new bootstrap.Modal(document.getElementById('solicitudesModal'));
                modal.show();

                // Actualizar campos del modal de solicitud
                document.getElementById('empleadoVarias').value = evento.raw.empleado || 'Sin asignar';
                document.getElementById('nombreVarias').value = evento.title;
                document.getElementById('descripcionTareas').value = evento.raw.descripcion_tareas;
                document.getElementById('tipoUso').value = evento.raw.tipo_uso;
                document.getElementById('estadoVarias').value = evento.raw.estado;

            } else if (colorEvento === '#ff6f00') {
                // Mostrar el modal de días inhábiles
                const modal = new bootstrap.Modal(document.getElementById('inhabilModal'));
                modal.show();

                document.getElementById('nombreDiaInhabil').value = evento.title;
            }
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_docente') ?>
<div class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <nav class="navbar d-flex flex-column align-items-center px-2 gap-2">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                <label>Seleccione laboratorio:</label>
                <select id="seleccionarLaboratorio" class="form-control form-select custom-select form-control-solid w-auto ms-3">
                    <?php foreach ($laboratorios as $datoslab): ?>
                        <option value="<?= $datoslab['id'] ?>"
                            <?= isset($laboratorioSeleccionado) && $datoslab['id'] == $laboratorioSeleccionado ? 'selected' : '' ?>>
                            <?= $datoslab['nombre_laboratorio'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-light prev">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Anterior
                </button>
                <button class="btn btn-light today">Hoy</button>
                <button class="btn btn-light next">
                    Siguiente
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
                <span class="navbar--range"></span>
            </div>
        </nav>
        <div class="card-body">
            <div id="calendar" style="height: 600px;"></div>
        </div>
    </div>
</div>

<!-- Modal para Crear Evento -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Crear Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Mostrar los errores de validación dentro del modal -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <?php $errors = session()->getFlashdata('errors'); ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
   
                <?= form_open('/usuario/solicitud', ['id' => 'eventForm', 'method' => 'post']) ?>
                    <?= csrf_field() ?>
                    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                    <!-- Campo Docente -->
                    <div class="mb-3">
                        <?= form_label('Nombre de la persona responsable', 'event-empleado', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'empleado',
                            'id' => 'event-empleado',
                            'type' => 'text',
                            'class' => 'form-control form-control-solid',
                            'disabled' => true,
                            'value' => esc($usuario['principal_name']),
                        ]) ?>
                    </div>

                    <!-- Selector de tipo de solicitud -->
                    <div class="mb-3">
                        <?= form_label('Seleccione el tipo de solicitud', 'event-selector-solicitud', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'event-selector-solicitud',
                            [
                                '' => 'Seleccione el tipo de solicitud',
                                'practicas' => 'Prácticas',
                                'varias' => 'Proyectos y Actividades'
                            ],
                            set_value('event-selector-solicitud'),
                            ['id' => 'event-selector-solicitud', 'class' => 'form-select custom-select form-control-solid', 'required' => true]
                        ) ?>
                    </div>

                    <!-- Campos adicionales para "Prácticas" -->
                    <div id="campos-practicas" class="additional-fields" style="display: none;">
                        <div class="mb-3">
                            <?= form_label('Nombre de la práctica', 'event-nombre-practica', ['class' => 'form-label']) ?>
                            <?= form_input([
                                'name' => 'nombre_practica',
                                'id' => 'event-nombre-practica',
                                'class' => 'form-control form-control-solid',
                                'value' => set_value('nombre_practica')
                            ]) ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Objetivo/Competencia de la práctica', 'event-objetivo-competencia', ['class' => 'form-label']) ?>
                            <?= form_input([
                                'name' => 'objetivo',
                                'id' => 'event-objetivo-competencia',
                                'class' => 'form-control form-control-solid',
                                'value' => set_value('objetivo')
                            ]) ?>
                        </div>

                        <div class="mb-3">
                            <?php if (!empty($carreras)): ?>
                                <?= form_label('Seleccione una carrera', 'event-selector-carrera', ['class' => 'form-label']) ?>
                                <?= form_dropdown(
                                    'event-selector-carrera',
                                    ['' => 'Seleccione una carrera'] + array_column($carreras, 'nombre_carrera', 'id'),
                                    set_value('id_carrera'),
                                    ['id' => 'event-selector-carrera', 'class' => 'form-select custom-select form-control-solid', 'onchange' => "document.getElementById('carrera-id-hidden').value = this.value"]
                                ) ?>
                            <?php else: ?>
                                <p>No hay carreras disponibles.</p>
                            <?php endif; ?>
                            <!-- Campo oculto para enviar el ID de la carrera -->
                            <input type="hidden" name="id_carrera" id="carrera-id-hidden" value="<?= set_value('carrera_id') ?>">
                        </div>
                        <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        <div class="mb-3">
                            <?= form_label('Seleccione una asignatura', 'event-selector-asignatura', ['class' => 'form-label']) ?>
                            <?= form_dropdown(
                                'event-selector-asignatura',
                                ['' => 'Seleccione una asignatura'],
                                set_value('id_asignatura'),
                                ['id' => 'event-selector-asignatura', 'class' => 'form-select custom-select form-control-solid']
                            ) ?>
                            <input type="hidden" name="id_asignatura" id="asignatura-id-hidden" value="<?= set_value('asignatura_id') ?>">
                        </div>

                        <div class="mb-3">
                            <?= form_label('Clave de la asignatura', 'event-clave-asignatura', ['class' => 'form-label']) ?>
                            <?= form_input([
                                'name' => 'clave-asignatura',
                                'id' => 'event-clave-asignatura',
                                'class' => 'form-control form-control-solid',
                                'value' => set_value('clave-asignatura'),
                                'disabled' => true,
                            ]) ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Seleccione un grupo', 'event-selector-grupo', ['class' => 'form-label']) ?>
                            <?= form_dropdown(
                                'event-selector-grupo',
                                ['' => 'Seleccione un grupo'],
                                set_value('id_grupo'),
                                ['id' => 'event-selector-grupo', 'class' => 'form-select custom-select form-control-solid']
                            ) ?>
                            <input type="hidden" name="id_grupo" id="grupo-id-hidden" value="<?= set_value('id_grupo') ?>">
                        </div>
                    </div>
                    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                    <!-- Campos adicionales para "Proyecto/Actividad/Otro" -->
                    <div id="campos-varias" class="additional-fields" style="display: none;">
                        <div class="mb-3">
                            <?php if (!empty($tipouso)): ?>
                                <?= form_label('Seleccione el tipo de uso', 'id_tipo_uso', ['class' => 'form-label']) ?>
                                <?= form_dropdown(
                                    'id_tipo_uso',
                                    ['' => 'Seleccione el tipo de uso'] + array_column($tipouso, 'nombre', 'id'),
                                    set_value('id_tipo_uso'),
                                    ['id' => 'id_tipo_uso', 'class' => 'form-select custom-select form-control-solid', 'onchange' => "document.getElementById('tipo-id-hidden').value = this.value"]
                                ) ?>
                                <input type="hidden" id="tipo-id-hidden" name="tipo_id_uso">
                            <?php else: ?>
                                <p>No hay tipos de uso disponibles.</p>
                            <?php endif; ?>    
                        </div>
                
                        <div class="mb-3">
                            <?= form_label('Nombre del proyecto, actividad u otro', 'nombre_proyecto', ['class' => 'form-label']) ?>
                            <?= form_input([
                                'name' => 'nombre_proyecto',
                                'id' => 'id_nombre_proyecto',
                                'class' => 'form-control form-control-solid',
                                // 'required' => true,
                                'value' => set_value('nombre_proyecto')
                            ]) ?>
                            <?php if (session()->get('errors') && isset(session()->get('errors')['nombre_proyecto'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session()->get('errors')['nombre_proyecto']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Descripción de las tareas que se realizarán', 'descripcion_tareas', ['class' => 'form-label']) ?>
                            <?= form_textarea([
                                'name' => 'descripcion_tareas',
                                'id' => 'id_descripcion_tareas',
                                'class' => 'form-control form-control-solid',
                                'rows' => 3,
                                'value' => set_value('descripcion_tareas')
                            ]) ?>
                           <?php if (session('errors.descripcion_tareas')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.descripcion_tareas')) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Fecha y Hora -->
                    <div class="mb-3">
                        <?= form_label('Fecha y Hora de Inicio', 'datepicker-start-input', ['class' => 'form-label']) ?>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <?= form_input([
                                'name' => 'datepicker-start-input1',
                                'id' => 'datepicker-start-input',
                                'aria-label' => 'Start Date-Time',
                                'class' => 'form-control'
                            ]) ?>
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="datepicker-start-wrapper" style="width: 100%;"></div>
                    </div>

                    <!-- Fecha y Hora de Fin -->
                    <div class="mb-3">
                        <?= form_label('Fecha y Hora de Fin', 'datepicker-end-input', ['class' => 'form-label']) ?>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <?= form_input([
                                'name' => 'datepicker-end-input2',
                                'id' => 'datepicker-end-input',
                                'aria-label' => 'End Date-Time',
                                'class' => 'form-control'
                            ]) ?>`
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="datepicker-end-wrapper" style="width: 100%;"></div>
                    </div>

                    <!-- Botones de Guardar y Cancelar -->
                    <div class="mt-3 d-flex justify-content-end">
                        <?= form_submit('submit', 'Enviar solicitud', ['class' => 'btn btn-primary me-2']) ?>
                        <?= form_button('cancel', 'Cancelar', ['type' => 'button','class' => 'btn btn-secondary','data-bs-dismiss' => 'modal',]) ?>
                        
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div> 
</div>

<!-- Modal para mostrar los detalles de la práctica -->
<div class="modal fade" id="practicaModal" tabindex="-1" role="dialog" aria-labelledby="practicaModalLabel">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="practicaModalLabel">Detalles de la Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Empleado</label>
                        <input type="text" class="form-control form-control-solid" id="empleado" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de la práctica</label>
                        <input type="text" class="form-control form-control-solid" id="nombre" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Objetivo de la práctica</label>
                        <input type="text" class="form-control form-control-solid" id="objetivo" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Carrera</label>
                        <input type="text" class="form-control form-control-solid" id="carrera" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grupo</label>
                        <input type="text" class="form-control form-control-solid" id="grupo" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Clave Asignatura</label>
                        <input type="text" class="form-control form-control-solid" id="claveAsignatura" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado de la solicitud</label>
                        <input type="text" class="form-control form-control-solid" id="estado" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar las solicitudes varias -->
<div class="modal fade" id="solicitudesModal" tabindex="-1" role="dialog" aria-labelledby="solicitudesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="solicitudesModalLabel">Detalles de la Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Empleado</label>
                        <input type="text" class="form-control form-control-solid" id="empleadoVarias" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control form-control-solid" id="nombreVarias" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción de las tareas</label>
                        <input type="text" class="form-control form-control-solid" id="descripcionTareas" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de uso</label>
                        <input type="text" class="form-control form-control-solid" id="tipoUso" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado de la solicitud</label>
                        <input type="text" class="form-control form-control-solid" id="estadoVarias" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar los detalles de los días inhábiles -->
<div class="modal fade" id="inhabilModal" tabindex="-1" role="dialog" aria-labelledby="inhabilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inhabilModalLabel">Detalles del Día Inhábil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-solid" id="nombreDiaInhabil" disabled>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>