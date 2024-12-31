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
    document.addEventListener("DOMContentLoaded", function () {
        // Lógica para el selector de laboratorio (que ya tenías)
        const laboratorioSelector = document.getElementById("seleccionarLaboratorio");
        laboratorioSelector.addEventListener("change", function () {
            const laboratorioId = laboratorioSelector.value;
            if (laboratorioId) {
                window.location.href = `${laboratorioId}`;
            }
        });

        // Selección de elementos
        const carreraSelector = document.getElementById('event-selector-carrera');
        // const asignaturaSelector = document.getElementById('event-selector-asignatura');
        // const claveAsignaturaInput = document.getElementById('event-clave-asignatura');
        
        // Añadir el campo oculto para enviar el ID de la carrera seleccionada
        const carreraIdHidden = document.getElementById('carrera-id-hidden');
        // const asignaturaIdHidden = document.getElementById('asignatura-id-hidden');

        carreraSelector.addEventListener('change', function() {
            const carreraId = carreraSelector.value;
            carreraIdHidden.value = carreraId;
            // console.log("ID de la asignatura seleccionada:", asignaturaIdHidden.value); // Confirmar en la consola
            
            if (carreraId) {
                fetch(`/usuario/pr/horario?carreraId=${carreraId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const asignaturaSelector = document.getElementById('event-selector-asignatura');
                    asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
                    data.asignatura.forEach(asignatura => {
                        const option = document.createElement('option');
                        option.value = asignatura.id;
                        option.textContent = asignatura.nombre_asignatura;
                        asignaturaSelector.appendChild(option);
                    });
                })
                .catch(error => {
                    asignaturaSelector.innerHTML = '<option value="">Error al cargar asignaturas</option>';
                });
            } else {
                asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
            }
        });

        document.querySelector('#eventForm').addEventListener('submit', function(event) {
            const carreraSelector = document.getElementById('event-selector-carrera');
            const asignaturaSelector = document.getElementById('event-selector-asignatura');
            const docenteInput = document.getElementById('event-docente');
            const nombrePractica = document.getElementById('event-nombre-practica');

            if (!carreraSelector.value || !asignaturaSelector.value || !docenteInput.value.trim() || (nombrePractica && !nombrePractica.value.trim())) {
                alert('Por favor, complete todos los campos requeridos.');
                event.preventDefault(); // Prevenir el envío del formulario si no está completo
            }
        });

        // Lógica para el selector de asignatura
    const asignaturaSelector = document.getElementById('event-selector-asignatura');
    const asignaturaIdHidden = document.getElementById('asignatura-id-hidden');
    const claveAsignaturaInput = document.getElementById('event-clave-asignatura');

    asignaturaSelector.addEventListener('change', function () {
        const asignaturaId = asignaturaSelector.value;
        asignaturaIdHidden.value = asignaturaId;

        if (asignaturaId) {
            fetch(`/usuario/asignaturaclave/horario?asignaturaId=${asignaturaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Accede a la propiedad 'claveasignatura' dentro del primer objeto de 'data.clave'
                if (data.clave && data.clave.length > 0) {
                    claveAsignaturaInput.value = data.clave[0].claveasignatura || "Clave no disponible";
                } else {
                    claveAsignaturaInput.value = "Clave no disponible";
                }
            })
            .catch(error => {
                console.error('Error al obtener la clave de la asignatura:', error);
                claveAsignaturaInput.value = "Error al obtener la clave";
            });
    } else {
        claveAsignaturaInput.value = "";
    }
    });

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
            calendars: [{ id: 'cal2', name: 'Mi Calendario' }],
            template: {
                time: function (schedule) {
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

        document.querySelector('.prev').addEventListener('click', function () {
            const currentDate = calendar.getDate();
            const newDate = new Date(currentDate.setDate(currentDate.getDate() - 7));
            if (newDate >= periodoInicio) {
                calendar.setDate(newDate);
                actualizarRangoFechas();
            }
        });

        document.querySelector('.next').addEventListener('click', function () {
            const currentDate = calendar.getDate();
            const newDate = new Date(currentDate.setDate(currentDate.getDate() + 7));
            if (newDate <= periodoFin) {
                calendar.setDate(newDate);
                actualizarRangoFechas();
            }
        });

        document.querySelector('.today').addEventListener('click', function () {
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

        tipoSolicitudSelector.addEventListener('change', function () {
            const tipoSolicitud = this.value;
            // Ocultar todos los campos adicionales
            camposPracticas.style.display = 'none';
            camposVarias.style.display = 'none';

            // Mostrar los campos correspondientes al tipo seleccionado
            if (tipoSolicitud === 'practicas') {
                camposPracticas.style.display = 'block';
            } else if (tipoSolicitud === 'varias') {
                camposVarias.style.display = 'block';
            }
        });

        // Asegurar que los campos se muestren correctamente al cargar la página
        if (tipoSolicitudSelector.value === 'practicas') {
            camposPracticas.style.display = 'block';
        } else if (tipoSolicitudSelector.value === 'varias') {
            camposVarias.style.display = 'block';
        }

        // Mostrar el modal para crear eventos
        calendar.on('selectDateTime', function (event) {
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

            // Guardar evento
            const form = document.getElementById('eventForm');
            form.addEventListener('submit', function handleSubmit(event) {
                event.preventDefault(); // Prevenir el envío por defecto

                const docente = document.getElementById('event-docente').value.trim();
                const startEventDate = datepickerStart.getDate();
                const endEventDate = datepickerEnd.getDate();

                if (!docente || !startEventDate || !endEventDate) {
                    alert('Todos los campos son obligatorios.');
                    return;
                }

                const start = new Date(startEventDate);
                const end = new Date(endEventDate);

                if (start >= end) {
                    alert('La fecha y hora de inicio deben ser anteriores a la fecha y hora de fin.');
                    return;
                }

                const newEvent = {
                    id: String(new Date().getTime()),
                    calendarId: 'cal2',
                    title: title,
                    start: start,
                    end: end,
                    category: 'time',
                    isAllDay: false,
                    raw: { docente },
                };

                calendar.createEvents([newEvent]);
                modal.hide();
                form.reset();
                datepickerStart.destroy();
                datepickerEnd.destroy();
            });
        });

        // Mostrar modal con detalles del evento
        calendar.on('clickEvent', function (event) {
            const evento = event.event;
            document.getElementById('eventoNombre').textContent = evento.title;
            document.getElementById('eventoInicio').textContent = evento.start.toLocaleString(locale);
            document.getElementById('eventoFin').textContent = evento.end.toLocaleString(locale);
            document.getElementById('eventoDescripcion').textContent = evento.description || "No hay descripción disponible";

            const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
            modal.show();
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
                <?= form_open('eventos/insertarEvento', ['id' => 'eventForm'])?>
                    <?= csrf_field() ?>    
                    <!-- Campo Docente -->
                    <div class="mb-3">
                        <?= form_label('Docente', 'event-docente', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'docente',
                            'id' => 'event-docente',
                            'class' => 'form-control form-control-solid',
                            'required' => true,
                            'value' => set_value('docente')
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
                                    ['id' => 'event-selector-carrera', 'class' => 'form-select custom-select form-control-solid', 'required' => true, 'onchange' => "document.getElementById('carrera-id-hidden').value = this.value"]
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
                                ['id' => 'event-selector-asignatura', 'class' => 'form-select custom-select form-control-solid', 'required' => true]
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
                                'readonly' => true
                            ]) ?>
                        </div>
                    </div>
                    
                    <!-- Campos adicionales para "Proyecto/Actividad/Otro" -->
                    <div id="campos-varias" class="additional-fields" style="display: none;">
                        <div class="mb-3">
                            <?= form_label('Seleccione el tipo de uso', 'event-selector-tipo-uso', ['class' => 'form-label']) ?>
                            <?= form_dropdown(
                                'event-selector-tipo-uso',
                                [
                                    '' => 'Seleccione el tipo de uso',
                                    'proyecto' => 'Proyecto',
                                    'actividad' => 'Actividad',
                                    'otro' => 'Otro'
                                ],
                                set_value('event-selector-tipo-uso'),
                                ['id' => 'event-selector-tipo-uso', 'class' => 'form-select custom-select form-control-solid']
                            ) ?>
                        </div>
                        <div class="mb-3">
                            <?= form_label('Nombre del proyecto, actividad u otro', 'event-nombre', ['class' => 'form-label']) ?>
                            <?= form_input([
                                'name' => 'event-nombre',
                                'id' => 'event-nombre',
                                'class' => 'form-control form-control-solid',
                                'value' => set_value('event-nombre')
                            ]) ?>
                        </div>
                        <div class="mb-3">
                            <?= form_label('Descripción de las tareas que se realizarán', 'proyecto-descripcion', ['class' => 'form-label']) ?>
                            <?= form_textarea([
                                'name' => 'proyecto-descripcion',
                                'id' => 'proyecto-descripcion',
                                'class' => 'form-control form-control-solid',
                                'rows' => 3,
                                'value' => set_value('proyecto-descripcion')
                            ]) ?>
                        </div>
                    </div>
                    <!-- Fecha y Hora -->
                    <!-- <div class="row"> -->
                        <!-- <div class="col-6"> -->
                            <div class="mb-3">
                                <?= form_label('Fecha y Hora de Inicio', 'datepicker-start-input', ['class' => 'form-label']) ?>
                                <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                                    <?= form_input([
                                        'name' => 'datepicker-end-input1',
                                        'id' => 'datepicker-start-input',
                                        'aria-label' => 'Start Date-Time',
                                        'class' => 'form-control'
                                    ]) ?>
                                    <span class="tui-ico-date"></span>
                                </div>
                                <div id="datepicker-start-wrapper" style="width: 100%;"></div>
                            </div>
                        <!-- </div> -->

                        <!-- Fecha y Hora de Fin -->
                        <!-- <div class="col-6"> -->
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
                        <!-- </div> -->
                    <!-- </div> -->
                    <button type="Submit" class="btn btn-primary" id="saveEventBtn">Guardar Evento</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar los detalles del evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalLabel">Detalles del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="eventoNombre"></span></p>
                <p><strong>Descripción:</strong> <span id="eventoDescripcion"></span></p>
                <p><strong>Fecha de Inicio:</strong> <span id="eventoInicio"></span></p>
                <p><strong>Fecha de Fin:</strong> <span id="eventoFin"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button">Aceptar</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>