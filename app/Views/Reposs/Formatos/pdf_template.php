<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Residencias Profesionales</title>
    <style>
        body {
            font-family: 'Segoe Print', Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        header,
        footer {
            text-align: center;
            margin-bottom: 20px;
        }

        h6 {
            font-family: 'Berlin Sans FB Demi', sans-serif;
            color: #000;
            text-align: center;
            text-decoration: underline;
            text-decoration-color: #000;
        }

        h2 {
            color: #333;
        }

        .lugar-fecha {
            text-align: right;
        }
        .datos-proyecto {
            table-layout: auto;
            border-color: #000;
        }

        input {
            display: block;
            margin: 10px 0;
            padding: 8px;
            width: 100%;
            max-width: 400 px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .contact-info {
            font-size: 12px;
            color: #737373;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .wcpage {
                page-break-after: always;
            }
        }

        @font-face {
            font-family: 'Open Sans';
            src: url('fonts/OpenSans-Regular.ttf') format('truetype');
            font-style: normal;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <header>

    </header>

    <main class="wcpage">
        <h6>SOLICITUD DE RESIDENCIAS PROFESIONALES</h6>
        </div>
        <p class="western" align="center" style="line-height: 100%; margin-bottom: 0in">
            <font face="Berlin Sans FB Demi, sans-serif">
                <font size="2" style="font-size: 10pt">
                    <span lang="es-ES">
                        <u><b>SOLICITUD DE RESIDENCIAS PROFESIONALES</b></u>
                    </span>
                </font>
            </font>
            <font face="Arial Narrow, sans-serif">
                <font size="1" style="font-size: 7pt">
                    <span lang="es-ES">
                        <p class="lugar-fecha">Huatusco de Chicuellar, Ver., a ____ de ________________ del 2023</p>
                        <p>LIC. MARIA TERESA COLIN SARATE</p>
                        <p>Jefa del Depto. de Residencias Profesionales y Servicio Social</p>
                    </span>
                </font>
            </font>
        </p>

        <section>
            <h2>Datos del Proyecto</h2>
            <table class="datos-proyecto">
                <th>
                    <tr>
                        <td>Nombre del Proyecto:</td>
                        <td>____________________</td>
                    </tr>
                </th>
            </table>
            <label for="project-name">Nombre del Proyecto:</label>
            <input type="text" id="project-name" name="project-name">
            <!-- Add more fields as necessary -->
        </section>

        <section>
            <h2>Datos de la Empresa</h2>
            <label for="company-name">Nombre:</label>
            <input type="text" id="company-name" name="company-name">
            <!-- Add more fields as necessary -->
        </section>

        <div class="firmas">
            <p>Sin más por el momento, agradezco la atención al presente.</p>
            <p>_______________________________</p>
            <p>Firma del alumno/a</p>
            <p>Los datos personales serán protegidos...</p>
        </div>

        <footer>
            <div class="contact-info">
                <p>Av. 25 Poniente Num. *** Col. Reserva Territorial Huatusco, Veracruz, México. C.P. 94100</p>
                <p>Tel. (** 273-73-4-40-00), e-mail: <a href="mailto:residencias@huatusco.tecnm.mx">residencias@huatusco.tecnm.mx</a></p>
                <p><a href="http://www.itshuatusco.edu.mx">www.itshuatusco.edu.mx</a></p>
            </div>
        </footer>
    </main>

    <script src="script.js"></script> <!-- Optional JavaScript -->
</body>

</html>