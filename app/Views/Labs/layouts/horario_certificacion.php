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
            const Calendar = tui.Calendar;
            const locale = 'es-MX';

            // Obtener las fechas de inicio y fin del periodo desde el controlador
            const periodo = JSON.parse('<?= $periodoJson ?>');
            const periodoInicio = new Date(periodo.inicio);
            const periodoFin = new Date(periodo.fin);

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
            });

            // Establecer la fecha inicial del calendario
            calendar.setDate(periodoInicio);

            // Función para actualizar el rango de fechas en el navbar
            function actualizarRangoFechas() {
                const viewDate = calendar.getDate();
                const startOfWeek = new Date(viewDate);
                const endOfWeek = new Date(viewDate);

                startOfWeek.setDate(viewDate.getDate() - viewDate.getDay()); // Domingo de la semana
                endOfWeek.setDate(startOfWeek.getDate() + 6); // Sábado de la semana

                const fechaInicioStr = startOfWeek.toLocaleDateString(locale);
                const fechaFinStr = endOfWeek.toLocaleDateString(locale);

                document.querySelector('.navbar--range').textContent = `${fechaInicioStr} - ${fechaFinStr}`;
            }

            // Actualizar rango de fechas al cargar
            actualizarRangoFechas();

            // Botón "Anterior"
            document.querySelector('.prev').addEventListener('click', function () {
                const currentDate = calendar.getDate();
                const newDate = new Date(currentDate.setDate(currentDate.getDate() - 7));

                if (newDate >= periodoInicio) {
                    calendar.setDate(newDate);
                    actualizarRangoFechas();
                }
            });

            // Botón "Siguiente"
            document.querySelector('.next').addEventListener('click', function () {
                const currentDate = calendar.getDate();
                const newDate = new Date(currentDate.setDate(currentDate.getDate() + 7));

                if (newDate <= periodoFin) {
                    calendar.setDate(newDate);
                    actualizarRangoFechas();
                }
            });

            // Botón "Hoy"
            document.querySelector('.today').addEventListener('click', function () {
                const today = new Date();

                if (today >= periodoInicio && today <= periodoFin) {
                    calendar.setDate(today);
                    actualizarRangoFechas();
                }
            });
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_certificacion') ?>
    <div class="container-xl px-4 mt-n5">
        <div class="card mb-4">
            <nav class="navbar d-flex justify-content-start gap-2 px-2">
                <button class="btn btn-primary prev">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Anterior
                </button>
                <button class="btn btn-primary today">Hoy</button>
                <button class="btn btn-primary next">
                    Siguiente
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
                <span class="navbar--range"></span>
            </nav>
            <div class="card-body">
                <div id="calendar" style="height: 600px;"></div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
