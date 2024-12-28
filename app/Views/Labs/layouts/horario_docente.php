<?= $this->extend('Labs/layouts/principal_docente') ?>

<?= $this->section('include_css') ?>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" /> 
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"> -->
<?= $this->endSection() ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/tui-code-snippet@latest/dist/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const laboratorioSelector = document.getElementById("seleccionarLaboratorio");

            laboratorioSelector.addEventListener("change", function () {
                const laboratorioId = laboratorioSelector.value;
                if (laboratorioId) {
                    window.location.href = `${laboratorioId}`;
                }
            });

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
                        // Mostrar título, docente, materia y grupo
                        const raw = schedule.raw || {};
                        return `
                            <div class="event-title">${schedule.title}</div>
                            <div class="event-docente">${raw.docente}</div>
                            <div class="event-materia">${raw.materia}</div>
                            <div class="event-grupo">${raw.grupo}</div>
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
                        format: 'yyyy-MM-dd HH:mm', // Usar el formato que quieres para fecha y hora
                    },
                });

                const datepickerEnd = new tui.DatePicker('#datepicker-end-wrapper', {
                    date: endDateTime,
                    timePicker: true,
                    input: {
                        element: '#datepicker-end-input',
                        format: 'yyyy-MM-dd HH:mm', // Usar el formato que quieres para fecha y hora
                    },
                });

            
                //Guardar evento
                const form = document.getElementById('eventForm');

                form.addEventListener('submit', function (event){
                    event.preventDefault(); // Prevenir el envío del formulario hasta validarlo

                    const title = document.getElementById('event-title').value;
                    const docente = document.getElementById('event-docente').value;
                    const materia = document.getElementById('event-materia').value;
                    const grupo = document.getElementById('event-grupo').value;
                    const startEventDate = datepickerStart.getDate();
                    const endEventDate = datepickerEnd.getDate();

                    if (!title || !docente || !materia || !grupo || !startEventDate || !endEventDate) {
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
                        raw: { docente, materia, grupo },
                    };

                    calendar.createEvents([newEvent]);

                    // Enviar el formulario si es necesario
                    // form.submit(); // Ahora puedes enviar el formulario después de la validación
                    // document.getElementById('createEventModal').modal('hide');
                    modal.hide();
                    document.getElementById('eventForm').reset();
                });                
            });

            // Mostrar modal con detalles del evento cuando se hace clic
            calendar.on('clickEvent', function(event) {
                const evento = event.event;

                // Llenar el modal con los detalles del evento
                document.getElementById('eventoNombre').textContent = evento.title;
                document.getElementById('eventoInicio').textContent = evento.start.toLocaleString(locale);
                document.getElementById('eventoFin').textContent = evento.end.toLocaleString(locale);
                document.getElementById('eventoDescripcion').textContent = evento.description || "No hay descripción disponible";

                // Mostrar el modal
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
                <select id="seleccionarLaboratorio" class="form-control form-control-solid w-auto ms-3">
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

<!-- Modal para Crear Evento -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">Crear Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm" action="<?= base_url('eventos/insertarEvento') ?>" method="POST">
                        <div class="mb-3">
                            <label for="event-title" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-solid"  name="title" id="event-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-docente" class="form-label">Docente</label>
                            <input type="text" class="form-control form-control-solid"  name="docente" id="event-docente" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-materia" class="form-label">Materia</label>
                            <input type="text" class="form-control form-control-solid" name="materia"  id="event-materia" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control form-control-solid"  name="grupo" id="event-grupo" required>
                        </div>

                        <!-- Fila para las fechas de inicio y fin -->
                        <div class="row">
                            <!-- Fecha y Hora de Inicio -->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="datepicker-start-input" class="form-label">Fecha y Hora de Inicio</label>
                                    <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                                        <input type="text" name="datepicker-end-input1" id="datepicker-start-input" aria-label="Start Date-Time" class="form-control ">
                                        <span class="tui-ico-date"></span>
                                    </div>
                                    <div id="datepicker-start-wrapper" style="width: 100%;"></div>
                                </div>
                            </div>

                            <!-- Fecha y Hora de Fin -->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="datepicker-end-input" class="form-label">Fecha y Hora de Fin</label>
                                    <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                                        <input type="text"  name="datepicker-end-input2" id="datepicker-end-input" aria-label="End Date-Time" class="form-control">
                                        <span class="tui-ico-date"></span>
                                    </div>
                                    <div id="datepicker-end-wrapper" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="saveEventBtn">Guardar Evento</button>
                        </div>

                        <!-- <button type="Submit" class="btn btn-primary" id="saveEventBtn">Guardar Evento</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
