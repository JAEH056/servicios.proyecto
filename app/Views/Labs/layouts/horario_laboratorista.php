<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

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
            // Función para manejar el cambio en el selector de laboratorio
            const laboratorioSelector = document.getElementById("seleccionarLaboratorio");
            laboratorioSelector.addEventListener("change", function () {
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

            // --------------------------------------------------------------------------------------------------------------------------------------------
            //Lógica del horario
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
                            <div class="event-empleado">${raw.empleado || 'Sin asignar'}</div>
                            <div class="event-grupo">${raw.grupo || ''}</div>
                            <div class="event-clave-asignatura">${raw.clave_asignatura || ''}</div>
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

            // Mostrar modal con detalles del evento cuando se hace clic
            calendar.on('clickEvent', function(event) {
                const evento = event.event;

                // Llenar el modal con los detalles del evento
                document.getElementById('eventoTitulo').textContent = evento.title;
                document.getElementById('event-empleado').textContent = evento.raw.empleado;
                document.getElementById('event-grupo').textContent = evento.raw.grupo;
                document.getElementById('event-clave-asignatura').textContent = evento.raw.clave_asignatura;
                document.getElementById('eventoInicio').textContent = evento.start.toLocaleString(locale);
                document.getElementById('eventoFin').textContent = evento.end.toLocaleString(locale);
                // document.getElementById('eventoDescripcion').textContent = evento.description || "No hay descripción disponible";

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
                modal.show();
            });

            function recargarEventos(calendar) {
            fetch('/usuario/mostrar/eventos')
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
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_laboratorista') ?>
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

<!-- Modal para mostrar los detalles del evento -->
<div class="modal fade" id="EventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalLabel">Detalles del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="eventoTitulo"></span></p>
                <p><strong>Empleado:</strong> <span id="event-empleado"></span></p>
                <p><strong>Grupo:</strong> <span id="event-grupo"></span></p>
                <p><strong>Asignatura:</strong> <span id="event-clave-asignatura"></span></p>
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
