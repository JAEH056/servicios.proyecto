<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        a,
        button,
        input,
        select,
        h1,
        h2,
        h3,
        h4,
        h5,
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            background: none;

            -webkit-font-smoothing: antialiased;
        }

        menu,
        ol,
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
    </style>
    <style id="style">
        /* Figma Styles of your File */
        :root {
            /* Colors */
            --itshuatuscoedumx-mysharepointcom-black: #000000;
            --itshuatuscoedumx-mysharepointcom-black-10: rgba(0, 0, 0, 0.1);
            --itshuatuscoedumx-mysharepointcom-black-60: rgba(0, 0, 0, 0.6);
            --itshuatuscoedumx-mysharepointcom-cerulean: #00a4ef;
            --itshuatuscoedumx-mysharepointcom-cod-gray: #1b1b1b;
            --itshuatuscoedumx-mysharepointcom-concrete: #f2f2f2;
            --itshuatuscoedumx-mysharepointcom-dove-gray: #737373;
            --itshuatuscoedumx-mysharepointcom-dove-gray: #666666;
            --itshuatuscoedumx-mysharepointcom-endeavour: #005da6;
            --itshuatuscoedumx-mysharepointcom-limeade: #7fba00;
            --itshuatuscoedumx-mysharepointcom-pomegranate: #f25022;
            --itshuatuscoedumx-mysharepointcom-science-blue: #0067b8;
            --itshuatuscoedumx-mysharepointcom-selective-yellow: #ffb900;
            --itshuatuscoedumx-mysharepointcom-tundora: #404040;
            --itshuatuscoedumx-mysharepointcom-white: #ffffff;
            --itshuatuscoedumx-mysharepointcom-white-white: linear-gradient(to left,
                    #ffffff,
                    #ffffff),
                linear-gradient(to left, #ffffff, #ffffff);

            /* Fonts */
            --itshuatuscoedumx-mysharepointcom-semantic-input-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-semantic-input-font-size: 14.1796875px;
            --itshuatuscoedumx-mysharepointcom-semantic-input-line-height: normal;
            --itshuatuscoedumx-mysharepointcom-semantic-input-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-semantic-input-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-family: Roboto-Bold,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-size: 23.0625px;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-line-height: 28px;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-weight: 700;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-size: 10.5px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-line-height: 28px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-size: 11.6796875px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-line-height: 20px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-size: 13.9453125px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-line-height: 16px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-size: 14.1796875px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-line-height: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-size: 10.5px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-line-height: 28px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-family: Roboto-Regular,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-size: 11.578125px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-line-height: 20px;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-weight: 400;
            --itshuatuscoedumx-mysharepointcom-roboto-regular-underline-font-style: normal;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-family: Roboto-Bold,
                sans-serif;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-size: 16px;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-line-height: 22px;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-weight: 700;
            --itshuatuscoedumx-mysharepointcom-roboto-bold-font-style: normal;

            /* Effects */
        }
        .solicitud-de-residencias-profesionales,
        .solicitud-de-residencias-profesionales * {
            box-sizing: border-box;
        }

        .solicitud-de-residencias-profesionales {
            background: #ffffff;
            height: 792px;
            position: relative;
            overflow: hidden;
        }

        .info-pie-de-pagina-itsh {
            color: rgba(0, 0, 0, 0.5);
            text-align: center;
            font-family: "Montserrat-Medium", sans-serif;
            font-size: 8px;
            font-weight: 500;
            position: absolute;
            left: 0px;
            top: 719px;
            width: 612px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-pie-de-pagina {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 7px;
            font-weight: 400;
            position: absolute;
            left: 0px;
            top: 700px;
            width: 612px;
            height: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .firma-alumno {
            color: #000000;
            text-align: center;
            font-family: "-", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 0px;
            top: 670px;
            width: 612px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .firma-alumno-span {
            color: #000000;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
        }

        .firma-alumno-span2 {
            color: #000000;
            font-family: "Arial-NarrowBold", sans-serif;
            font-size: 10px;
            font-weight: 400;
        }

        .recuadro-numero-de-control {
            background: #d9d9d9;
            width: 60px;
            height: 20px;
            position: absolute;
            left: 335px;
            top: 526px;
        }

        .pie-de-tabla {
            color: #000000;
            text-align: left;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 33px;
            top: 608px;
            width: 231px;
            height: 12px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .datos-del-residente-table {
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            display: flex;
            flex-direction: column;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            width: 536px;
            height: 125px;
            position: absolute;
            left: 29px;
            top: 480px;
            overflow: hidden;
        }

        .table-head {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .nombre {
            color: #000000;
            text-align: left;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 61px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-del-residente {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 536px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 20px;
        }

        .separador-nombre {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 25px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 25px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-1 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .carrera {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 61px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-carrera {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 240px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .no-de-control {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 60px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .numero {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-ramo {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 305px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-ramo2 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-ramo3 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 366px;
            top: 19px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-2 {
            padding: 0px 4px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .domicilio {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 61px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .direccion {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-sector {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-rfc {
            border-style: solid;
            border-color: #000000;
            border-width: 0px 1px 1px 1px;
            padding: 10px;
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
            justify-content: flex-start;
            flex-shrink: 0;
            width: 191px;
            height: 65px;
            position: absolute;
            left: 345px;
            top: 60px;
            overflow: hidden;
        }

        .imss {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 3px;
            top: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .issste {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 69px;
            top: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border2 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 192px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 17px;
        }

        .no-ss {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 3px;
            top: 19px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .numero-ss {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 69px;
            top: 19px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border3 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 190px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 48px;
        }

        .row-3 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 32px;
            position: relative;
            overflow: hidden;
        }

        .correo {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            width: 61px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-correo {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            width: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .seguro-s {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-colonia {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: var(--height-32, 32px);
            height: 0px;
            position: absolute;
            left: 65px;
            top: 32px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-bottom-border4 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 536px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 32px;
        }

        .separador-ss {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: var(--height-32, 32px);
            height: 0px;
            position: absolute;
            left: 265px;
            top: 32px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-nombre2 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 16px;
            height: 0px;
            position: absolute;
            left: 408px;
            top: 16px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-4 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 32px;
            position: relative;
            overflow: hidden;
        }

        .ciudad {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 61px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .datos-ciudad {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 200px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tel-text {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 265px;
            top: 0px;
            width: 80px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cel-text {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 265px;
            top: 16px;
            width: 80px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .num-tel {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 346px;
            top: 0px;
            width: 189px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .num-cel {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 346px;
            top: 16px;
            width: 189px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-ciudad {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 32px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 32px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-cel-tel {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 32px;
            height: 0px;
            position: absolute;
            left: 265px;
            top: 32px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-bottom-border5 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 81px;
            height: 0px;
            position: absolute;
            left: 265px;
            top: 16px;
        }

        .datos-del-la-residente {
            color: #000000;
            text-align: left;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 30px;
            top: 467px;
        }

        .rectangle-3 {
            width: 536px;
            height: 196px;
            position: absolute;
            left: 29px;
            top: 268px;
            overflow: visible;
        }

        .datos-de-la-empresa-table {
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            display: flex;
            flex-direction: column;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            width: 536px;
            height: 196px;
            position: absolute;
            left: 29px;
            top: 268px;
            overflow: hidden;
        }

        .table-head2 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .nombre2 {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-de-la-empresa {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border6 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 536px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 31px;
        }

        .separador-nombre3 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 31px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 31px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-12 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            flex-shrink: 0;
            width: 415px;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .giro-ramo {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .industrial-x-servicios-x-otro-x {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 350px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border7 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 415px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 20px;
        }

        .row-bottom-border8 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 0px;
            height: 20px;
            position: absolute;
            left: 415px;
            top: 0px;
            transform-origin: 0 0;
            transform: rotate(0deg) scale(1, 1);
        }

        .row-22 {
            padding: 0px 4px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            flex-shrink: 0;
            width: 415px;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .sector {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .p-blico-x-privado-x {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 350px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-rfc2 {
            border-style: solid;
            border-color: #000000;
            border-width: 0px 1px 1px 1px;
            padding: 10px;
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
            justify-content: flex-start;
            flex-shrink: 0;
            width: 121px;
            height: 40px;
            position: absolute;
            left: 415px;
            top: 31px;
            overflow: hidden;
        }

        .separador-nombre4 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 40px;
            height: 0px;
            position: absolute;
            left: 51px;
            top: 40px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .r-f-c {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 12px;
            top: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-32 {
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 14px;
            position: relative;
            overflow: hidden;
        }

        .domicilio2 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            align-self: stretch;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row-bottom-border9 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 536px;
            height: 0px;
            position: absolute;
            left: 0px;
            top: 14px;
        }

        .row-42 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .colonia-text-1 {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 64px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .datos-text-2 {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cp-text-3 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 45px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .datos-text-4 {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fax-text-5 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 45px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .datos-text-6 {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-colonia2 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-5 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .ciudad-text-1 {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .datos-text-22 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .celular-tel-text-3 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 45px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .datos-text-5 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 176px;
            height: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .datos-text-42 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 359px;
            top: 9px;
            width: 176px;
            height: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-ciudad2 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 31px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 31px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-6 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .misi-n-de-la-empresa {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            line-height: 121.08%;
            font-weight: 400;
            position: relative;
            width: 61px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .campo-de-texto-empresa {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-colonia3 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 31px;
            height: 0px;
            position: absolute;
            left: 65px;
            top: 31px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-7 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            height: 20px;
            position: relative;
            overflow: hidden;
        }

        .nombre-del-titular-de-la-empresa {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 100px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-del-titular {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .puesto {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 63px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-colonia4 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 289px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-colonia5 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 352px;
            top: 19px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-colonia6 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 100px;
            top: 19px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .row-8 {
            padding: 0px 0px 0px 4px;
            display: flex;
            flex-direction: row;
            gap: 0px;
            align-items: flex-start;
            justify-content: flex-start;
            align-self: stretch;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .nombre-del-asesor-externo {
            color: #000000;
            text-align: left;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 100px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nombre-asesor {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .puesto2 {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            width: 65px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nombre-del-puesto {
            color: #000000;
            text-align: center;
            font-family: "Arial-Narrow", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: relative;
            flex: 1;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .separador-colonia7 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 100px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .separador-colonia8 {
            margin-top: -1px;
            border-style: solid;
            border-color: #000000;
            border-width: 1px 0 0 0;
            flex-shrink: 0;
            width: 20px;
            height: 0px;
            position: absolute;
            left: 352px;
            top: 20px;
            transform-origin: 0 0;
            transform: rotate(-90deg) scale(1, 1);
        }

        .datos-de-la-empresa {
            color: #000000;
            text-align: left;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 32px;
            top: 255px;
        }

        .periodo-group {
            width: 612px;
            height: 14px;
            position: absolute;
            left: 0px;
            top: 225px;
            overflow: hidden;
        }

        .campo-no-r {
            color: #000000;
            text-align: center;
            font-family: "Abel-Regular", sans-serif;
            font-size: 10px;
            line-height: 31px;
            font-weight: 400;
            position: absolute;
            left: 458px;
            top: 0px;
            width: 100px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .periodo {
            color: #000000;
            text-align: center;
            font-family: "Abel-Regular", sans-serif;
            font-size: 10px;
            line-height: 31px;
            font-weight: 400;
            position: absolute;
            left: 164px;
            top: 0px;
            width: 150px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .opcion-elegida-fondo {
            background: rgba(217, 217, 217, 0.6);
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 116px;
            height: 14px;
            position: absolute;
            left: 30px;
            top: 0px;
        }

        .periodo2 {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 30px;
            top: 0px;
            width: 116px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rectangle-no-r {
            background: #d9d9d9;
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 80px;
            height: 14px;
            position: absolute;
            left: 378px;
            top: 0px;
        }

        .no-res {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 378px;
            top: 0px;
            width: 80px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .opciones-group {
            width: 612px;
            height: 14px;
            position: absolute;
            left: 0px;
            top: 208px;
            overflow: hidden;
        }

        .opcion-pp {
            color: #000000;
            text-align: center;
            font-family: "Abel-Regular", sans-serif;
            font-size: 10px;
            line-height: 31px;
            font-weight: 400;
            position: absolute;
            left: 278px;
            top: 0px;
            width: 100px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .opcion-bp {
            color: #000000;
            text-align: center;
            font-family: "Abel-Regular", sans-serif;
            font-size: 10px;
            line-height: 31px;
            font-weight: 400;
            position: absolute;
            left: 164px;
            top: 0px;
            width: 100px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .opcion-elegida {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 30px;
            top: 0px;
            width: 116px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rectangle-o-1 {
            background: #d9d9d9;
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 14px;
            height: 14px;
            position: absolute;
            left: 264px;
            top: 0px;
        }

        .marca-o-1-x {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 264px;
            top: 0px;
            width: 14px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rectangle-o-2 {
            background: #d9d9d9;
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 14px;
            height: 14px;
            position: absolute;
            left: 378px;
            top: 0px;
        }

        .marca-o-2-x {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 378px;
            top: 0px;
            width: 14px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nombre-del-proyecto-fondo {
            background: rgba(217, 217, 217, 0.6);
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 403px;
            height: 31px;
            position: absolute;
            left: 163px;
            top: 174px;
        }

        .datos-del-proyecto {
            color: #000000;
            text-align: center;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            line-height: 31px;
            font-weight: 400;
            position: absolute;
            left: 164px;
            top: 174px;
            width: 402px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nombre-fondo {
            background: rgba(217, 217, 217, 0.6);
            border-style: solid;
            border-color: #000000;
            border-width: 1px;
            width: 116px;
            height: 31px;
            position: absolute;
            left: 30px;
            top: 174px;
        }

        .nombre-del-proyecto {
            color: #000000;
            text-align: center;
            font-family: "Inter-Bold", sans-serif;
            font-size: 8px;
            font-weight: 700;
            position: absolute;
            left: 30px;
            top: 174px;
            width: 116px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .introduccion {
            color: #000000;
            text-align: left;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 66px;
            top: 140px;
            width: 480px;
            height: 22px;
        }

        .nombre-jefe-dpto {
            color: #000000;
            text-align: left;
            font-family: "Arial-NarrowBold", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 64px;
            top: 112px;
            width: 254px;
        }

        .hoja-1-de-1 {
            color: #000000;
            text-align: right;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 7px;
            font-weight: 400;
            position: absolute;
            left: 519px;
            top: 77px;
            width: 30px;
            height: 12px;
        }

        .ciudad-y-fecha {
            color: #000000;
            text-align: right;
            font-family: "ArialNarrow-Regular", sans-serif;
            font-size: 10px;
            font-weight: 400;
            position: absolute;
            left: 285px;
            top: 100px;
            width: 268px;
            height: 12px;
        }

        .solicitud-de-residencias-profesionales2 {
            color: #000000;
            text-align: center;
            font-family: "BerlinSansFb-Bold", sans-serif;
            font-size: 10px;
            font-weight: 700;
            position: absolute;
            left: 196px;
            top: 75px;
        }

        .imagenes-encabezado {
            width: 612px;
            height: 72px;
            position: absolute;
            left: 0px;
            top: 0px;
            overflow: hidden;
        }

        .image-2 {
            width: 548.44px;
            height: 65px;
            position: absolute;
            left: 32px;
            top: 7px;
            object-fit: cover;
        }
    </style>
      <style>
    body {
      margin: 40px auto;
      width: 80%;
    }
  </style>
</head>

<body>
    <div class="solicitud-de-residencias-profesionales">
        <div class="info-pie-de-pagina-itsh">
            Av . 25 Poniente Num. 100 Col. Reserva territorial
            <br />
            Huatusco, Veracruz, México. C.P. 94100
            <br />
            Tel. (01 273-73-4-40- 00), e-mail: residencias@huatusco.tecnm.mx
            <br />
            www.itshuatusco.edu.mx
        </div>
        <div class="info-pie-de-pagina">
            Los datos personales recabados serán protegidos, incorporados y tratados en
            el sistema de datos personales del departamento de Residencias Profesionales
            y Servicio Social del Instituto
            <br />
            Tecnológico Superior de Huatusco.
        </div>
        <div class="firma-alumno">
            <span>
                <span class="firma-alumno-span">
                    _______________________________
                    <br />
                </span>
                <span class="firma-alumno-span2">Firma del alumno/a</span>
            </span>
        </div>
        <div class="recuadro-numero-de-control"></div>
        <div class="pie-de-tabla">
             Sin más por el momento, agradezco la atención al presente.
        </div>
        <div class="datos-del-residente-table">
            <div class="table-head">
                <div class="nombre">Nombre:</div>
                <div class="nombre-del-residente">Nombre del residente</div>
                <div class="row-bottom-border"></div>
                <div class="separador-nombre"></div>
            </div>
            <div class="row-1">
                <div class="carrera">Carrera:</div>
                <div class="nombre-carrera">Nombre carrera</div>
                <div class="no-de-control">No. de control:</div>
                <div class="numero">número</div>
                <div class="separador-ramo"></div>
                <div class="separador-ramo2"></div>
                <div class="separador-ramo3"></div>
                <div class="row-bottom-border"></div>
            </div>
            <div class="row-2">
                <div class="domicilio">Domicilio:</div>
                <div class="direccion">direccion residente</div>
                <div class="separador-sector"></div>
                <div class="row-bottom-border"></div>
            </div>
            <div class="row-rfc">
                <div class="imss">IMSS ( X )</div>
                <div class="issste">ISSSTE( X )</div>
                <div class="row-bottom-border2"></div>
                <div class="no-ss">No.:</div>
                <div class="numero-ss">123456789122</div>
                <div class="row-bottom-border3"></div>
            </div>
            <div class="row-3">
                <div class="correo">E-mail:</div>
                <div class="nombre-correo">nombre@dominio.com</div>
                <div class="seguro-s">Seguridad Social:</div>
                <div class="separador-colonia"></div>
                <div class="row-bottom-border4"></div>
                <div class="separador-ss"></div>
                <div class="separador-nombre2"></div>
            </div>
            <div class="row-4">
                <div class="ciudad">Ciudad:</div>
                <div class="datos-ciudad">datos ciudad</div>
                <div class="tel-text">Telefono:</div>
                <div class="cel-text">Celular:</div>
                <div class="num-tel">numero tel</div>
                <div class="num-cel">numero cel</div>
                <div class="separador-ciudad"></div>
                <div class="separador-cel-tel"></div>
                <div class="row-bottom-border5"></div>
            </div>
        </div>
        <div class="datos-del-la-residente">Datos del/la Residente:</div>
        <img class="rectangle-3" src="rectangle-30.svg" />
        <div class="datos-de-la-empresa-table">
            <div class="table-head2">
                <div class="nombre2">Nombre:</div>
                <div class="nombre-de-la-empresa">Nombre de la empresa</div>
                <div class="row-bottom-border6"></div>
                <div class="separador-nombre3"></div>
            </div>
            <div class="row-12">
                <div class="giro-ramo">Giro, Ramo:</div>
                <div class="industrial-x-servicios-x-otro-x">
                    Industrial ( X )      Servicios ( X )       Otro  ( X )    
                </div>
                <div class="row-bottom-border7"></div>
                <div class="row-bottom-border8"></div>
                <div class="separador-ramo2"></div>
            </div>
            <div class="row-22">
                <div class="sector">Sector:</div>
                <div class="p-blico-x-privado-x">Público ( X )     Privado ( X )</div>
                <div class="row-bottom-border"></div>
                <div class="separador-sector"></div>
            </div>
            <div class="row-rfc2">
                <div class="separador-nombre4"></div>
                <div class="r-f-c">R.F.C.</div>
            </div>
            <div class="row-32">
                <div class="domicilio2">Domicilio:</div>
                <div class="row-bottom-border9"></div>
            </div>
            <div class="row-42">
                <div class="colonia-text-1">Colonia:</div>
                <div class="datos-text-2">datos colonia</div>
                <div class="cp-text-3">C.P:</div>
                <div class="datos-text-4">codigo postal</div>
                <div class="fax-text-5">Fax</div>
                <div class="datos-text-6">datos fax</div>
                <div class="row-bottom-border"></div>
                <div class="separador-colonia2"></div>
            </div>
            <div class="row-5">
                <div class="ciudad-text-1">Ciudad:</div>
                <div class="datos-text-22">datos ciudad</div>
                <div class="celular-tel-text-3">
                    Telefono:
                    <br />
                    Celular:
                </div>
                <div class="datos-text-5">datos cel</div>
                <div class="row-bottom-border"></div>
                <div class="datos-text-42">datos tel</div>
                <div class="separador-ciudad2"></div>
            </div>
            <div class="row-6">
                <div class="misi-n-de-la-empresa">Misión de la empresa:</div>
                <div class="campo-de-texto-empresa">campo de texto empresa</div>
                <div class="separador-colonia3"></div>
                <div class="row-bottom-border6"></div>
            </div>
            <div class="row-7">
                <div class="nombre-del-titular-de-la-empresa">
                    Nombre del Titular de la empresa:
                </div>
                <div class="nombre-del-titular">nombre titular</div>
                <div class="puesto">Puesto:</div>
                <div class="nombre-del-titular">Nombre del puesto</div>
                <div class="row-bottom-border"></div>
                <div class="separador-colonia4"></div>
                <div class="separador-colonia5"></div>
                <div class="separador-colonia6"></div>
            </div>
            <div class="row-8">
                <div class="nombre-del-asesor-externo">Nombre del Asesor Externo:</div>
                <div class="nombre-asesor">Nombre del asesor</div>
                <div class="puesto2">Puesto:</div>
                <div class="nombre-del-puesto">Nombre del puesto</div>
                <div class="separador-colonia7"></div>
                <div class="separador-colonia8"></div>
                <div class="separador-colonia4"></div>
            </div>
        </div>
        <div class="datos-de-la-empresa">Datos de la empresa:</div>
        <div class="periodo-group">
            <div class="campo-no-r">num</div>
            <div class="periodo">26-01-2025 al 26-07-2025</div>
            <div class="opcion-elegida-fondo"></div>
            <div class="periodo2">Periodo Proyectado:</div>
            <div class="rectangle-no-r"></div>
            <div class="no-res">No. de Residentes:</div>
        </div>
        <div class="opciones-group">
            <div class="opcion-pp">Propuesta Propia:</div>
            <div class="opcion-bp">Banco de Proyectos:</div>
            <div class="opcion-elegida-fondo"></div>
            <div class="opcion-elegida">Opcion Elegida:</div>
            <div class="rectangle-o-1"></div>
            <div class="marca-o-1-x">X</div>
            <div class="rectangle-o-2"></div>
            <div class="marca-o-2-x">X</div>
        </div>
        <div class="nombre-del-proyecto-fondo"></div>
        <div class="datos-del-proyecto">Datos del proyecto</div>
        <div class="nombre-fondo"></div>
        <div class="nombre-del-proyecto">Nombre del Proyecto:</div>
        <div class="introduccion">
            Por este medio, me permito solicitar el inicio de mi proceso de Residencia
            Profesional para el período escolar actual, contando con
            <br />
            los siguientes generales: 
        </div>
        <div class="nombre-jefe-dpto">
            LIC. ADOLFO RENE ALVAREZ LIMA 
            <br />
            Jefe del Depto. de Residencias Profesionales y Servicio Social  
        </div>
        <div class="hoja-1-de-1">Hoja 1 de 1</div>
        <div class="ciudad-y-fecha">
            Huatusco de Chicuellar, Ver., a ____ de ________________ del 2023 
        </div>
        <div class="solicitud-de-residencias-profesionales2">
            SOLICITUD DE RESIDENCIAS PROFESIONALES
        </div>
        <div class="imagenes-encabezado">
            <img class="image-2" src="data:image/png;base64,<?=base_url('/var/www/servicios.proyecto/public/formatos_RP/image-20.png')?>" />
        </div>
    </div>
</body>

</html>