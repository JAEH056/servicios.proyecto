<?= $this->extend('Labs/layouts/principal_docente') ?>

<?= $this->section('include_css') ?>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" /> 
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" /> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/tui-code-snippet@latest/dist/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <!-- Bootstrap JS (con Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const Calendar = tui.Calendar;
            const locale = 'es-MX';

            // Obtener las fechas de inicio y fin del periodo desde el controlador
            const periodo = JSON.parse('<?= $periodoJson ?>');
            const periodoInicio = new Date(periodo.inicio); // Convertir la fecha de inicio
            const periodoFin = new Date(periodo.fin); // Convertir la fecha de fin
        
            // Inicializar el calendario TUI
            const calendar = new Calendar('#calendar', {
                defaultView: 'week',
                useFormPopup: false,
                useDetailPopup: false,
                week: {
                    taskView: false,
                    eventView: ['time'],
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

            // Renderizar los eventos en el calendario
            const eventos = <?= $events ?>;
            calendar.createEvents(eventos.map(event => {
                event.start = new Date(event.start);  // Convertir las fechas a objetos Date
                event.end = new Date(event.end);
                return event;
            }));

            // Función para actualizar el rango de fechas en el navbar
            function actualizarRangoFechas() {
                const viewDate = calendar.getDate();
                const startOfWeek = new Date(viewDate);
                const endOfWeek = new Date(viewDate);

                startOfWeek.setDate(viewDate.getDate() - viewDate.getDay()); // Domingo de la semana
                endOfWeek.setDate(startOfWeek.getDate() + 6); // Sábado de la semana

                // Formatear las fechas
                const fechaInicioStr = startOfWeek.toLocaleDateString(locale);
                const fechaFinStr = endOfWeek.toLocaleDateString(locale);

                // Actualizar el contenido en el navbar
                document.querySelector('.navbar--range').textContent = `${fechaInicioStr} - ${fechaFinStr}`;
            }

            // Llamar a la función para actualizar el rango de fechas inicialmente
            actualizarRangoFechas();

            // Botones de navegación con validación de fecha
            document.querySelector('.prev').addEventListener('click', function() {
                const currentDate = calendar.getDate();
                const newDate = new Date(currentDate.setDate(currentDate.getDate() - 7)); // Mueve una semana atrás

                if (newDate >= periodoInicio) {
                    calendar.setDate(newDate); // Mueve una semana atrás solo si está dentro del periodo
                    actualizarRangoFechas();  // Actualizar rango de fechas
                }
            });

            document.querySelector('.next').addEventListener('click', function() {
                const currentDate = calendar.getDate();
                const newDate = new Date(currentDate.setDate(currentDate.getDate() + 7)); // Mueve una semana adelante

                if (newDate <= periodoFin) {
                    calendar.setDate(newDate); // Mueve una semana adelante solo si está dentro del periodo
                    actualizarRangoFechas();  // Actualizar rango de fechas
                }
            });

            document.querySelector('.today').addEventListener('click', function() {
                const today = new Date();

                // Solo mueve al día de hoy si está dentro del periodo
                if (today >= periodoInicio && today <= periodoFin) {
                    calendar.setDate(today);
                }
            });
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horario2') ?>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <!-- <header class="header"> -->
                <nav class="navbar d-flex justify-content-start">
                    <button class="btn btn-light today">Hoy</button>
                    <button class="btn btn-light prev">
                        <img src="<?= base_url("Layouts/resources/assets/img/arrow-left-circle.svg") ?>" >
                        Anterior
                    </button>
                    <button class="btn btn-light next">
                        <img src="<?= base_url("Layouts/resources/assets/img/arrow-right-circle.svg") ?>">
                        Siguiente
                    </button>
                    <span class="navbar--range"></span>
                </nav>
            <!-- </header> -->
            <!-- <div class="card-header">Calendario Dinámico con TUI Calendar</div> -->
            <div class="card-body">
                <div id="calendar" style="height: 600px;"></div>
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
                            <input type="text" class="form-control"  name="title" id="event-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-docente" class="form-label">Docente</label>
                            <input type="text" class="form-control"  name="docente" id="event-docente" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-materia" class="form-label">Materia</label>
                            <input type="text" class="form-control" name="materia"  id="event-materia" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control"  name="grupo" id="event-grupo" required>
                        </div>

                        <!-- Fila para las fechas de inicio y fin -->
                        <div class="row">
                            <!-- Fecha y Hora de Inicio -->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="datepicker-start-input" class="form-label">Fecha y Hora de Inicio</label>
                                    <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                                        <input type="text" name="datepicker-end-input1" id="datepicker-start-input" aria-label="Start Date-Time" class="form-control">
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
                        <button type="Submit" class="btn btn-primary" id="saveEventBtn">Guardar Evento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>