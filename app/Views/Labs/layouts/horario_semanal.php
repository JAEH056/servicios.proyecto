<?= $this->extend('Labs/layouts/principal') ?>

<?= $this->section('include_css') ?>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" /> 
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" /> 
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<?= $this->endSection() ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/tui-code-snippet@latest/dist/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <!-- Bootstrap JS (con Popper.js) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const Calendar = tui.Calendar;
        
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
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_semanal') ?>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <!-- <header class="header"> -->
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
            <!-- </header> -->
            <!-- <div class="card-header">Calendario Dinámico con TUI Calendar</div> -->
            <div class="card-body">
                <div id="calendar" style="height: 600px;"></div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>