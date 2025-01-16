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
        // Lógica del calendario
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
                        <div class="event-docente">${raw.docente}</div>
                    `;
                }
            }
        });

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

        // Renderizar los eventos en el calendario
        const eventosInhabiles = JSON.parse('<?= $events ?>');
        const eventosFormateados = eventosInhabiles.map(evento => {
            let backgroundColor, borderColor;
            if (evento.raw && evento.raw.tipo_inhabil) {
                backgroundColor = '#ff6f61'; // Rojo
                borderColor = '#ff3b30';
            } else {
                backgroundColor = '#007bff'; // Azul
                borderColor = '#0056b3';
            }

            return {
                ...evento,
                start: new Date(evento.start),
                end: new Date(evento.end),
                backgroundColor,
                borderColor,
                color: '#ffffff',
            };
        });
        calendar.createEvents(eventosFormateados);

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

// Validación de formulario y mostrar errores
function validateForm(event) {
            let isValid = true;
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(msg => msg.style.display = 'none'); // Limpiar errores previos

            // Validar tipo de solicitud
            const tipoSolicitud = tipoSolicitudSelector.value;
            if (!tipoSolicitud) {
                showError('event-selector-solicitud', 'Por favor, seleccione un tipo de solicitud.');
                isValid = false;
            }

            // Validación para 'practicas'
            if (tipoSolicitud === 'practicas') {
                const nombrePractica = document.getElementById('event-nombre-practica').value;
                const objetivo = document.getElementById('event-objetivo-competencia').value;
                const carrera = document.getElementById('event-selector-carrera').value;
                const asignatura = document.getElementById('event-selector-asignatura').value;
                const grupo = document.getElementById('event-selector-grupo').value;

                if (!nombrePractica) {
                    showError('event-nombre-practica', 'El nombre de la práctica es obligatorio.');
                    isValid = false;
                }
                if (!objetivo) {
                    showError('event-objetivo-competencia', 'El objetivo/competencia es obligatorio.');
                    isValid = false;
                }
                if (!carrera) {
                    showError('event-selector-carrera', 'Debe seleccionar una carrera.');
                    isValid = false;
                }
                if (!asignatura) {
                    showError('event-selector-asignatura', 'Debe seleccionar una asignatura.');
                    isValid = false;
                }
                if (!grupo) {
                    showError('event-selector-grupo', 'Debe seleccionar un grupo.');
                    isValid = false;
                }
            }

            // Validación para 'varias'
            if (tipoSolicitud === 'varias') {
                const fechaStart = document.getElementById('event-date-start').value;
                const fechaEnd = document.getElementById('event-date-end').value;

                if (!fechaStart) {
                    showError('event-date-start', 'La fecha de inicio es obligatoria.');
                    isValid = false;
                }
                if (!fechaEnd) {
                    showError('event-date-end', 'La fecha de finalización es obligatoria.');
                    isValid = false;
                }
            }

            // Si no es válido, evitar el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        }

        // Función para mostrar errores
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorElement = document.createElement('div');
            errorElement.classList.add('text-danger');
            errorElement.textContent = message;
            field.closest('.form-group').appendChild(errorElement);
        }

        form.addEventListener('submit', validateForm);


        // Mostrar el modal para crear eventos
        calendar.on('selectDateTime', function(event) {
            const modal = new bootstrap.Modal(document.getElementById('createEventModal'));
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

        // ------------------------------------------------------------------------------------------------------------------------------------------------------
        // Reiniciar el formulario y limpiar los errores al abrir el modal
        document.getElementById('createEventModal').addEventListener('show.bs.modal', function() {
            // Restablecer el formulario
            form.reset();

            // Ocultar los campos adicionales
            camposPracticas.style.display = 'none';
            camposVarias.style.display = 'none';

            // Asegura que el selector de tipo esté en su valor por defecto
            tipoSolicitudSelector.value = "";

            // Limpia los selectores de fecha y hora si existen
            datepickerStart?.destroy();
            datepickerEnd?.destroy();
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_docente') ?>
<div class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <nav class="navbar d-flex flex-column align-items-center px-2 gap-2">
            <div class="d-flex align-items-center justify-content-center gap-2">
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
            
            <?= form_open('/usuario/solicitud', ['id' => 'eventForm', 'method' => 'post', 'onsubmit' => 'return handleFormSubmit(event)']) ?>
                <?= csrf_field() ?>
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
                            'name' => 'event-nombre-practica',
                            'id' => 'event-nombre-practica',
                            'class' => 'form-control form-control-solid',
                            'value' => set_value('event-nombre-practica')
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?= form_label('Objetivo/Competencia de la práctica', 'event-objetivo-competencia', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'event-objetivo-competencia',
                            'id' => 'event-objetivo-competencia',
                            'class' => 'form-control form-control-solid',
                            'value' => set_value('event-objetivo-competencia')
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?php if (!empty($carreras)): ?>
                            <?= form_label('Seleccione una carrera', 'event-selector-carrera', ['class' => 'form-label']) ?>
                            <?= form_dropdown(
                                'event-selector-carrera',
                                ['' => 'Seleccione una carrera'] + array_column($carreras, 'nombre_carrera', 'id'),
                                set_value('event-selector-carrera'),
                                ['id' => 'event-selector-carrera', 'class' => 'form-select custom-select form-control-solid', 'onchange' => "document.getElementById('carrera-id-hidden').value = this.value"]
                            ) ?>
                        <?php else: ?>
                            <p>No hay carreras disponibles.</p>
                        <?php endif; ?>
                        <!-- Campo oculto para enviar el ID de la carrera -->
                        <input type="hidden" name="carrera_id" id="carrera-id-hidden" value="<?= set_value('carrera_id') ?>">
                    </div>
                    <div class="mb-3">
                        <?= form_label('Seleccione una asignatura', 'event-selector-asignatura', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'event-selector-asignatura',
                            ['' => 'Seleccione una asignatura'],
                            set_value('event-selector-asignatura'),
                            ['id' => 'event-selector-asignatura', 'class' => 'form-select custom-select form-control-solid']
                        ) ?>
                        <input type="hidden" name="asignatura_id" id="asignatura-id-hidden" value="<?= set_value('asignatura_id') ?>">
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
                            set_value('event-selector-grupo'),
                            ['id' => 'event-selector-grupo', 'class' => 'form-select custom-select form-control-solid']
                        ) ?>
                        <input type="hidden" name="grupo_id" id="grupo-id-hidden" value="<?= set_value('grupo_id') ?>">
                    </div>
                </div>

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
                        <span id="empleado-error" class="text-danger" style="display: none;"></span> <!-- Contenedor de error -->
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
                        <span id="empleado-error" class="text-danger" style="display: none;"></span> <!-- Contenedor de error -->
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
                        <span id="empleado-error" class="text-danger" style="display: none;"></span> <!-- Contenedor de error -->
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
                    <?= form_submit('submit', 'Guardar Evento', ['class' => 'btn btn-primary me-2']) ?>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>