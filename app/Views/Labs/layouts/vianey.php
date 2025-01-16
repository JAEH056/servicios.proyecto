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
        // Añadir el campo oculto para enviar el ID de la carrera seleccionada
        const carreraIdHidden = document.getElementById('carrera-id-hidden');

        carreraSelector.addEventListener('change', function() {
            const carreraId = carreraSelector.value;
            carreraIdHidden.value = carreraId;
            
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
                    // console.error('Error al obtener la clave de la asignatura:', error);
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
        const form = document.getElementById('eventForm');

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
                    //title: title,
                    start: start,
                    end: end,
                    category: 'time',
                    isAllDay: false,
                    raw: { docente },
                };

                calendar.createEvents([newEvent]);
                // modal.hide();
                form.reset();
                datepickerStart.destroy();
                datepickerEnd.destroy();
                modal.hide();
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

<!-- // Selección de elementos del DOM
    const carreraSelector = document.getElementById('event-selector-carrera');
    const carreraIdHidden = document.getElementById('carrera-id-hidden');
    const asignaturaSelector = document.getElementById('event-selector-asignatura');
    const asignaturaIdHidden = document.getElementById('asignatura-id-hidden');
    const claveAsignaturaInput = document.getElementById('event-clave-asignatura');
    const grupoSelector = document.getElementById('event-selector-grupo');
    const grupoIdHidden = document.getElementById('grupo-id-hidden');

    // Función para manejar el cambio en el selector de carrera
    carreraSelector.addEventListener('change', function () {
        const carreraId = carreraSelector.value;
        carreraIdHidden.value = carreraId;

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
                })
                .catch(() => {
                    asignaturaSelector.innerHTML = '<option value="">Error al cargar asignaturas</option>';
                });
        } else {
            asignaturaSelector.innerHTML = '<option value="">Seleccione una asignatura</option>';
        }
    }); -->