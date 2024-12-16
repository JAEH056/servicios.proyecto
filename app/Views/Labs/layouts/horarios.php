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
            const laboratorioSelector = document.getElementById("seleccionarLaboratorio");

            laboratorioSelector.addEventListener("change", function () {
                const laboratorioId = laboratorioSelector.value;

                if (laboratorioId) {
                    // Redirige a la misma ruta con el ID del laboratorio seleccionado
                    window.location.href = `${laboratorioId}`;
                }
            });

            // Código del calendario
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
                    eventView: ['time','allday'],
                    showNowIndicator: false,
                    hourStart: 7,
                    hourEnd: 20,
                    dayNames: ['Dom', 'Lun', 'Mar', 'Miér', 'Juev', 'Vier', 'Sáb'],
                },
            });

            calendar.setDate(periodoInicio);

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

            // Añadir colores personalizados para diferentes tipos de eventos
            const eventosFormateados = eventosInhabiles.map(evento => {
                let backgroundColor, borderColor;

                // Asignar colores según el tipo de evento (puedes usar cualquier lógica aquí)
                if (evento.raw && evento.raw.tipo_inhabil) {
                    // Colores para días inhábiles
                    backgroundColor = '#ff6f61'; // Rojo
                    borderColor = '#ff3b30';
                } else {
                    // Colores para otros eventos
                    backgroundColor = '#007bff'; // Azul
                    borderColor = '#0056b3';
                }

                // Convertir fechas y agregar colores
                return {
                    ...evento,
                    start: new Date(evento.start), // Convertir a objeto Date
                    end: new Date(evento.end),
                    backgroundColor, // Establecer color de fondo
                    borderColor, // Establecer color de borde
                    color: '#ffffff', // Color del texto
                };
            });

            // Crear eventos en el calendario
            calendar.createEvents(eventosFormateados);
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horarios') ?>
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
<?= $this->endSection() ?>
