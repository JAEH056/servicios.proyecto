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
                            <div class="event-empleado">${raw.empleado || ''}</div>
                            <div class="event-grupo">${raw.grupo || ''}</div>
                            <div class="event-clave-asignatura">${raw.clave_asignatura || ''}</div>

                            ${raw.id && false ? `<div class="event-id">${raw.id}</div>` : ''}
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
                                    event.color = '#ffffff'; //Color de la letra
                                } else if (event.raw.empleado && (!event.raw.grupo || !event.raw.clave_asignatura)) {
                                    event.backgroundColor = '#0059ff'; // Azul para solicitudes varias: "empleado asignado, pero faltan otros datos"
                                    event.color = '#ffffff'; //Color de la letra
                                } else if (event.raw.empleado && event.raw.grupo && event.raw.clave_asignatura) {
                                    event.backgroundColor = '#13199a'; // Azul marino para solicitudes practicas para: "todos los datos completos"
                                    event.color = '#ffffff'; //Color de la letra
                                } else {
                                    event.bgColor = '#D3D3D3'; // Gris como color predeterminado
                                    event.color = '#FFFFFF'; //Color de la letra
                                }
                                return event;
                            }));
                        } else {
                            console.error('La respuesta no tiene la propiedad "events" o no es un array:', eventos);
                        }
                    })
                    .catch(error => console.error('Error al recargar eventos:', error));
            }

            // function recargarEventos(calendar) {
            //     fetch('/usuario/mostrar/eventos')
            //         .then(response => response.json())
            //         .then(data => {
            //             console.log('Eventos recargados:', data);  // Verifica la estructura de la respuesta

            //             const eventos = data.events;  // Acceder a la propiedad 'events' que contiene los eventos

            //             if (Array.isArray(eventos)) {  // Asegurarse de que la respuesta es un array
            //                 calendar.clear();
            //                 calendar.createEvents(eventos.map(event => {
            //                     event.start = new Date(event.start);  // Convertir las fechas a formato Date
            //                     event.end = new Date(event.end);
            //                     return event;
            //                 }));
            //             } else {
            //                 console.error('La respuesta no tiene la propiedad "events" o no es un array:', eventos);
            //             }
            //         })
            //         .catch(error => console.error('Error al recargar eventos:', error));
            // }


            // ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            // Editar y aceptar o rechazar solicitudes
            //para cargar los timepicker de tui VARIAS
            var datepickerEntradaVarias = new tui.DatePicker('#hora-entrada-varias', {
                date: new Date(),
                input: {
                    element: '#hora-start-varias',
                    format: 'yyyy-MM-dd HH:mm A'  // El formato con la hora y el AM/PM
                },
                timePicker: true  // Habilitar el timepicker
            });

            var datepickerSalidaVarias = new tui.DatePicker('#hora-salida-varias', {
                date: new Date(),
                input: {
                    element: '#hora-end-varias',
                    format: 'yyyy-MM-dd HH:mm A'  // El formato con la hora y el AM/PM
                },
                timePicker: true
            });

            //para cargar los timepicker de tui PRACTICAS
            var datepickerEntradaPracticas = new tui.DatePicker('#hora-entrada-practicas', {
                date: new Date(),
                input: {
                    element: '#hora-start-practicas',
                    format: 'yyyy-MM-dd HH:mm A'  // El formato con la hora y el AM/PM
                },
                timePicker: true  // Habilitar el timepicker
            });

            var datepickerSalidaPracticas = new tui.DatePicker('#hora-salida-practicas', {
                date: new Date(),
                input: {
                    element: '#hora-end-practicas',
                    format: 'yyyy-MM-dd HH:mm A'  // El formato con la hora y el AM/PM
                },
                timePicker: true
            });

            // Funcion para convertir fecha UTC a la hora local de Mexico
            function convertirUTCaMexico(fechaUTC){
                const fecha = new Date(fechaUTC.date);

                return new Intl.DateTimeFormat("es-MX",{
                    timeZone: "America/Mexico_City",
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                    hour12: false
                }).format(fecha).replace(/\//g, "-");
            }

            // Función para formatear fechas al formato esperado por la BD
            function formatFechaHoraLocal(fecha) {
                const year = fecha.getFullYear();
                const month = String(fecha.getMonth() + 1).padStart(2, '0');
                const day = String(fecha.getDate()).padStart(2, '0');
                const hours = String(fecha.getHours()).padStart(2, '0');
                const minutes = String(fecha.getMinutes()).padStart(2, '0');
                const seconds = String(fecha.getSeconds()).padStart(2, '0');
                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            // Lógica para ver la información del evento creado
            calendar.on('clickEvent', function(event) {
                const evento = event.event;
                const idSolicitud = evento.id;

                console.log("ID de la solicitud seleccionada:", idSolicitud);

                // Construir la URL con el ID de la solicitud como parámetro de consulta
                const url = `/usuario/editar/solicitud/${idSolicitud}`;

                // Realizar la solicitud GET con fetch
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data);
                    // Obtener el tipo de solicitud
                    const tipoSolicitud = data.solicitud.tipo;

                    // Verificar si es tipo 'varia', solo en ese caso mostramos el modal
                    if (tipoSolicitud === 'varia') {
                        console.log("Es varia");
                        mostrarModalVarias(data.solicitud);  // Llamar al modal de Solicitudes Varias
                    } else {
                        console.log("Tipo de solicitud no es 'varia', no se mostrará el modal.");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos del servidor:", error);
                });

                // Mostrar modal de Solicitudes Varias
                function mostrarModalVarias(solicitud) {
                    // Asignamos el ID al campo oculto
                    document.getElementById('idSolicitud-varias').value = solicitud.idSolicitud;
                    console.log("ID de la solicitud en el modal varias:", document.getElementById('idSolicitud-varias').value);

                    // Asignamos los valores de la solicitud a los elementos del modal VARIAS
                    document.getElementById('modal-empleado-varias').value = solicitud.solicitante;
                    document.getElementById('modal-nombre-proyecto-actividad-otro').value = solicitud.nombre;
                    document.getElementById('modal-descripcion-tareas').value = solicitud.descripcion;
                    document.getElementById('modal-estado-varias').value = solicitud.autorizado;
                    document.getElementById('modal-observaciones-varias').value = solicitud.observaciones;
                    
                    // Convertir fechas UTC a hora local y asignarlas
                    const horaEntradaMX = convertirUTCaMexico(solicitud.inicio);
                    const horaSalidaMX = convertirUTCaMexico(solicitud.fin);
                    document.getElementById('hora-start-varias').value = horaEntradaMX;
                    document.getElementById('hora-end-varias').value = horaSalidaMX;

                    // Asignar fechas al datepicker
                    datepickerEntradaVarias.setDate(new Date(solicitud.inicio.date));
                    datepickerSalidaVarias.setDate(new Date(solicitud.fin.date));

                    // Configurar el tipo de uso
                    const tipo_uso = <?php echo json_encode($tipo_uso); ?>;
                    const selectTipoUso = document.getElementById('modal-tipo-uso');
                    selectTipoUso.innerHTML = ''; // Limpiar las opciones anteriores

                    tipo_uso.forEach(tipo => {
                        const option = document.createElement('option');
                        option.value = tipo.id;
                        option.textContent = tipo.nombre;
                        selectTipoUso.appendChild(option);
                    });

                    // Establecer el valor seleccionado
                    const selectedValue = solicitud.tipo_uso;
                    const tipoSeleccionado = tipo_uso.find(tipo => tipo.nombre.trim() === selectedValue);
                    selectTipoUso.value = tipoSeleccionado ? tipoSeleccionado.id : tipo_uso[0].id;

                    // Convertir las fechas
                    const inicio = new Date(solicitud.hora_fecha_entrada);
                    const fin = new Date(solicitud.hora_fecha_salida);

                    // Mostrar el modal correspondiente
                    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudesVarias'));
                    modal.show();
                }

                // Mostrar modal de Solicitudes Prácticas
                // function mostrarModalPracticas(solicitud) {
                //     // Asignamos el ID al campo oculto
                //     document.getElementById('idSolicitud-practicas').value = solicitud.id_solicitud;
                //     console.log("ID de la solicitud en el modal de practicas:", document.getElementById('idSolicitud-practicas').value);

                //     // Asignamos los valores de la solicitud a los elementos del modal PRACTICAS
                //     document.getElementById('modal-empleado-practicas').value = solicitud.correo;
                //     document.getElementById('modal-nombre-practica').value = solicitud.nombre_proyecto;
                //     document.getElementById('modal-objetivo').value = solicitud.objetivo;
                //     document.getElementById('modal-clave').value = solicitud.clave;  // Aquí asignamos la clave directamente
                //     document.getElementById('modal-grupo').value = solicitud.grupo;

                //     // Cargar las carreras y asignaturas
                //     const carreras = <?php echo json_encode($carreras); ?>;
                //     const selectCarrera = document.getElementById('modal-carrera');
                //     selectCarrera.innerHTML = ''; // Limpiar las opciones anteriores

                //     // Agregar opciones al selector de carrera
                //     carreras.forEach(carrera => {
                //         const option = document.createElement('option');
                //         option.value = carrera.id;
                //         option.textContent = carrera.nombre_carrera;
                //         selectCarrera.appendChild(option);
                //     });

                //     const selectedValue = solicitud.carrera;
                //     const carreraSeleccionada = carreras.find(carrera => carrera.nombre_carrera.trim() === selectedValue);
                //     selectCarrera.value = carreraSeleccionada ? carreraSeleccionada.id : carreras[0].id;

                //     // Cargar asignaturas y grupos según la carrera seleccionada
                //     const obtenerAsignaturaYGrupos = (carreraId) => {
                //         fetch(`/usuario/materias/carrera?carreraId=${carreraId}`)
                //             .then(response => response.json())
                //             .then(data => {
                //                 const selectAsignatura = document.getElementById('modal-asignatura');
                //                 const selectGrupo = document.getElementById('modal-grupo'); // Selector de grupos
                //                 selectAsignatura.innerHTML = ''; // Limpiar las opciones anteriores
                //                 selectGrupo.innerHTML = ''; // Limpiar las opciones de grupos

                //                 // Agregar opciones al selector de asignaturas
                //                 if (data && Array.isArray(data.asignaturas) && data.asignaturas.length > 0) {
                //                     data.asignaturas.forEach(asignatura => {
                //                         const option = document.createElement('option');
                //                         option.value = asignatura.id;
                //                         option.textContent = asignatura.nombre_asignatura;
                //                         selectAsignatura.appendChild(option);
                //                     });

                //                     // Establecer la asignatura preseleccionada (si existe en la solicitud)
                //                     const selectedAsignaturaValue = solicitud.id_asignatura; // Asegúrate de que 'asignatura' sea el id
                //                     const asignaturaSeleccionada = data.asignaturas.find(asignatura => asignatura.id === selectedAsignaturaValue);

                //                     console.log("Asignatura encontrada en la lista:", asignaturaSeleccionada);

                //                     // Si la asignatura se encuentra, la seleccionamos
                //                     selectAsignatura.value = asignaturaSeleccionada ? asignaturaSeleccionada.id : data.asignaturas[0].id;

                //                     // Obtener la clave de la asignatura seleccionada
                //                     obtenerInfoAsignatura(selectAsignatura.value);
                //                 } else {
                //                     const option = document.createElement('option');
                //                     option.value = '';
                //                     option.textContent = 'No hay asignaturas disponibles';
                //                     selectAsignatura.appendChild(option);
                //                 }

                //                 // Agregar opciones al selector de grupos
                //                 if (data && Array.isArray(data.grupos) && data.grupos.length > 0) {
                //                     data.grupos.forEach(grupo => {
                //                         const option = document.createElement('option');
                //                         option.value = grupo.id_grupo;
                //                         option.textContent = grupo.nombre_grupo;
                //                         selectGrupo.appendChild(option);
                //                     });

                //                     console.log("Grupo recibido en la solicitud:", solicitud.id_grupo);
                //                     console.log("Grupos disponibles:", data.grupos);


                //                     // Establecer el grupo preseleccionado (si existe en la solicitud)
                //                     const selectedGrupoValue = solicitud.id_grupo; // Asegúrate de que 'grupo' sea el id
                //                     const grupoSeleccionado = data.grupos.find(grupo => grupo.id_grupo === selectedGrupoValue);

                //                     console.log("Grupo encontrado en la lista:", grupoSeleccionado);

                //                     // Si el grupo se encuentra, lo seleccionamos
                //                     selectGrupo.value = grupoSeleccionado ? grupoSeleccionado.id_grupo : data.grupos[0].id;
                //                 } else {
                //                     const option = document.createElement('option');
                //                     option.value = '';
                //                     option.textContent = 'No hay grupos disponibles';
                //                     selectGrupo.appendChild(option);
                //                 }
                //             })
                //             .catch(error => {
                //                 console.error("Error al cargar asignaturas y grupos:", error);
                //             });
                //     };

                //     obtenerAsignaturaYGrupos(selectCarrera.value);

                //     // Evento de cambio de carrera
                //     selectCarrera.addEventListener('change', function() {
                //         obtenerAsignaturaYGrupos(selectCarrera.value); // Volver a cargar asignaturas y grupos basados en la nueva carrera
                //     });

                //     // Evento de cambio de asignatura
                //     const selectAsignatura = document.getElementById('modal-asignatura');
                //     selectAsignatura.addEventListener('change', function() {
                //         obtenerInfoAsignatura(selectAsignatura.value);
                //     });

                //     // Función para obtener más información sobre la asignatura seleccionada
                //     const obtenerInfoAsignatura = (asignaturaId) => {
                //         fetch(`/usuario/clave/asignatura?asignaturaId=${asignaturaId}`)
                //             .then(response => response.json())
                //             .then(data => {
                //                 if (data && Array.isArray(data.clave) && data.clave.length > 0) {
                //                     const claveAsignatura = data.clave[0].claveasignatura; 
                //                     console.log("Clave de la asignatura:", claveAsignatura);
                //                     document.getElementById('modal-clave').value = claveAsignatura;
                //                 } else {
                //                     console.log("No se encontró la clave de la asignatura o está vacía.");
                //                 }
                //             })
                //             .catch(error => {
                //                 console.error("Error al obtener la información de la asignatura:", error);
                //             });
                //     };

                //     // Mostrar el modal correspondiente
                //     const modal = new bootstrap.Modal(document.getElementById('modalSolicitudesPracticas'));
                //     modal.show();
                // }
            });


            document.getElementById('btnGuardarCambios').addEventListener('click', function (e) {
                e.preventDefault();

                const form = document.getElementById('formSolicitudVarias');
                const csrfField = document.querySelector('.txt_csrfname');
                const formData = new FormData(form);

                const horaEntradaFormatoDB = formatFechaHoraLocal(datePickerEntradaVarias.getDate());
                const horaSalidaFormatoDB = formatFechaHoraLocal(datePickerSalidaVarias.getDate());

                formData.set('hora_fecha_entrada', horaEntradaFormatoDB);
                formData.set('hora_fecha_salida', horaSalidaFormatoDB);

                if (!csrfField) {
                    console.error("No se encontró el campo CSRF");
                    return;
                }

                formData.append(csrfField.name, csrfField.value);

                const idSolicitud = formData.get('idSolicitud');
                const url = `/usuario/actualizar/solicitud/${idSolicitud}`;

                fetch(url, {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.csrf) {
                            csrfField.value = data.csrf;
                        }

                        if (data.success) {
                            alert('Cambios actualizados correctamente');
                            console.log("Intentando cerrar el modal...");
                            const modalElement = document.getElementById('modalSolicitudesVarias');
                            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                            modal.hide();
                            location.reload();
                        } else if (data.errors) {
                            for (let field in data.errors) {
                                displayErrorsInUI(field, data.errors[field]);
                            }
                        } else {
                            alert("Ocurrió un error: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Ocurrió un error al guardar los cambios.");
                    });
            });


            // Función para limpiar los errores previos antes de mostrar nuevos
            // function clearPreviousErrors() {
            //     const errorElements = document.querySelectorAll('.error-message');
            //     errorElements.forEach(element => element.remove());
            // }

            // // Función para mostrar los errores en el formulario
            // function displayErrorsInUI(field, errors) {
            //     const inputField = document.querySelector(`[name="${field}"]`);
            //     if (inputField) {
            //         // Crear un contenedor de errores
            //         const errorContainer = document.createElement('div');
            //         errorContainer.classList.add('error-message');
            //         errorContainer.style.color = 'red';
            //         errorContainer.style.fontSize = '0.875rem'; // Ajusta el tamaño de fuente si lo necesitas

            //         // Unir los errores en un solo mensaje
            //         errorContainer.innerText = errors.join(', ');

            //         // Agregar el contenedor de errores después del campo de entrada
            //         inputField.parentNode.appendChild(errorContainer);
            //     }
            // }
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content_horario_laboratorista_prueba') ?>
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

<!-- ---------------------------------------------------------------------------------------------------------------------- -->

<!-- Modal para mostrar los detalles de los días inhábiles -->
<div class="modal fade" id="modalDiaInhabil" tabindex="-1" role="dialog" aria-labelledby="inhabilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inhabilModalLabel">Detalles del Día Inhábil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-solid" id="nombre_dia_inhabil" name="nombre_dia_inhabil" disabled>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------------------------------------------------------------------------------------- -->

<!-- Modal de Bootstrap para Mostrar solicitudes varias -->
<div class="modal fade" id="modalSolicitudesVarias" tabindex="-1" aria-labelledby="modalSolicitudesVariasLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSolicitudesVariasLabel">Detalles de la Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

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
                
                <form id="formSolicitudVarias" method="POST" action="usuario/actualizar/solicitud">
                    <?= csrf_field() ?>
                            <!-- token oculto  -->
                    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" id="idSolicitud-varias" name="idSolicitud">
                    <div class="mb-3">
                        <label for="modal-empleado-varias" class="form-label">Empleado</label>
                        <input type="email" class="form-control form-control-solid" id="modal-empleado-varias" name="empleado_varias" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-nombre-proyecto-actividad-otro" class="form-label">Nombre del proyecto, actividad u otro</label>
                        <input type="text" class="form-control form-control-solid" id="modal-nombre-proyecto-actividad-otro" name="nombre_proyecto">
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal-descripcion-tareas" class="form-label">Descripción de Tareas</label>
                        <textarea class="form-control form-control-solid" id="modal-descripcion-tareas" name="descripcion_tareas" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modal-tipo-uso" class="form-label">Tipo de Uso</label>
                        <select class="form-select custom-select form-control form-control-solid" id="modal-tipo-uso" name="id_tipo_uso">
                            <!-- Las opciones se llenarán dinámicamente con JS -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal-estado-varias" class="form-label">Estado actual</label>
                        <input type="text" class="form-control form-control-solid" id="modal-estado-varias" name="estado_varias" readonly>
                    </div>

                    <!-- Opcional: Campo de estado de la solicitud -->
                    <div class="mb-3">
                        <label for="modal-autorizacion-varias" class="form-label">Autorización</label>
                        <select class="form-select custom-select form-control form-control-solid" id="modal-autorizacion-varias" name="autorizacion">
                            <option value="" disabled selected>Seleccione una opción de autorización</option>
                            <option value="1">Aprobado</option>
                            <option value="2">Rechazado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal-observaciones-varias" class="form-label">Observaciones</label>
                        <textarea class="form-control form-control-solid" id="modal-observaciones-varias" name="observaciones_varias" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="hora-entrada" class="form-label">Hora de Entrada</label>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <input type="text" id="hora-start-varias" class="form-control" aria-label="Date-Time" name = "hora_fecha_entrada">
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="hora-entrada-varias" style="margin-top: -1px;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="hora-salida" class="form-label">Hora de Salida</label>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <input type="text" id="hora-end-varias" class="form-control" aria-label="Date-Time" name = "hora_fecha_salida">
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="hora-salida-varias" style="margin-top: -1px;"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Bootstrap para Mostrar solicitudes prácticas -->
<div class="modal fade" id="modalSolicitudesPracticas" tabindex="-1" aria-labelledby="modalSolicitudesPracticasLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSolicitudesPracticasLabel">Detalles de la Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSolicitudPractica" method="POST" action="usuario/actualizar/solicitud">
                <?= csrf_field() ?>
                            <!-- token oculto  -->
                    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" id="idSolicitud-practicas" name="idSolicitud">

                    <div class="mb-3">
                        <label for="modal-empleado-practicas" class="form-label">Empleado</label>
                        <input type="email" class="form-control form-control-solid" id="modal-empleado-practicas" name="empleado-practicas" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-nombre-practica" class="form-label">Nombre de la práctica</label>
                        <input type="text" class="form-control form-control-solid" id="modal-nombre-practica" name="nombre_practica" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-objetivo" class="form-label">Objetivo</label>
                        <input type="text" class="form-control form-control-solid" id="modal-objetivo" name="objetivo" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-carrera" class="form-label">Carrera</label>
                        <select class="form-select custom-select form-control form-control-solid" id="modal-carrera" name="carrera">

                        </select>
                        <!-- Campo oculto para almacenar el ID -->
                        <input type="hidden" id="carrera-id" name="carrera_id" value="">
                    </div>

                    <div class="mb-3">
                        <label for="modal-asignatura" class="form-label">Asignatura</label>
                        <select class="form-select custom-select form-control form-control-solid" id="modal-asignatura" name="asignatura">

                        </select>
                        <!-- Campo oculto para almacenar el ID -->
                        <input type="hidden" id="asignatura-id" name="asignatura_id" value="">
                    </div>

                    <div class="mb-3">
                        <label for="modal-clave" class="form-label">Clave de la Asignatura</label>
                        <input type="text" class="form-control form-control-solid" id="modal-clave" name="clave" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-grupo" class="form-label">Grupo</label>
                        <select class="form-select custom-select form-control form-control-solid" id="modal-grupo" name="grupo">

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal-estado-practicas" class="form-label">Estado</label>
                        <input type="text" class="form-control form-control-solid" id="modal-estado-practicas" name="estado_practicas" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modal-observaciones-practicas" class="form-label">Observaciones</label>
                        <textarea class="form-control form-control-solid" id="modal-observaciones-practicas" name="observaciones_practicas" rows="3" readonly></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="hora-entrada-practicas" class="form-label">Hora de Entrada</label>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <input type="text" id="hora-start-practicas" class="form-control" aria-label="Date-Time" name = "datepicker-start-inputPracticas">
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="hora-entrada-practicas" style="margin-top: -1px;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="hora-salida-practicas" class="form-label">Hora de Salida</label>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <input type="text" id="hora-end-practicas" class="form-control" aria-label="Date-Time" name = "datepicker-end-inputPracticas">
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="hora-salida-practicas" style="margin-top: -1px;"></div>
                    </div>
            
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>