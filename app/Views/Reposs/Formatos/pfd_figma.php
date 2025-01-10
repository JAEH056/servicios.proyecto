<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formato de solicitud de residencias</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
    <!-- link rel="stylesheet" href="index.css" /-->
    <style>
        :root {
            --default-font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                Ubuntu, "Helvetica Neue", Helvetica, Arial, "PingFang SC",
                "Hiragino Sans GB", "Microsoft Yahei UI", "Microsoft Yahei",
                "Source Han Sans CN", sans-serif;
        }

        .main-container {
            overflow: hidden;
        }

        .main-container,
        .main-container * {
            box-sizing: border-box;
        }

        input,
        select,
        textarea,
        button {
            outline: 0;
        }

        .main-container {
            position: relative;
            width: 612px;
            height: 792px;
            margin: 0 auto;
            font-size: 0px;
            background: #ffffff;
            overflow: hidden;
        }

        .solicitud-residencias {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            position: relative;
            width: 225px;
            height: 12px;
            margin: 64px 0 0 194px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 10px;
            font-weight: 700;
            line-height: 12px;
            text-align: center;
            white-space: nowrap;
        }

        .location-date {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            position: relative;
            width: 312px;
            height: 12px;
            margin: 26px 0 0 259px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 10px;
            font-weight: 700;
            line-height: 12px;
            text-align: center;
            white-space: nowrap;
            z-index: 1;
        }

        .jefe-residencias {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            position: relative;
            width: 307px;
            height: 24px;
            margin: 12px 0 0 24px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 10px;
            font-weight: 700;
            line-height: 12.102px;
            text-align: left;
            z-index: 2;
        }

        .solicitud-inicio {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            position: relative;
            width: 520px;
            height: 20px;
            margin: 50px 0 0 46px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 8px;
            font-weight: 700;
            line-height: 9.682px;
            text-align: left;
            text-overflow: initial;
            z-index: 3;
            overflow: hidden;
        }

        .flex-row-fa {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            width: 536px;
            height: 40px;
            margin: 26px 0 0 30px;
            z-index: 6;
        }

        .rectangle {
            flex-shrink: 0;
            position: relative;
            width: 116px;
            height: 40px;
            cursor: pointer;
            background: rgba(217, 217, 217, 0.6);
            border: 1px solid #000000;
            z-index: 4;
        }

        .nombre-proyecto {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            position: absolute;
            height: 10px;
            top: 15px;
            left: 15px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 8px;
            font-weight: 700;
            line-height: 9.682px;
            text-align: left;
            white-space: nowrap;
            z-index: 5;
        }

        .rectangle-1 {
            flex-shrink: 0;
            position: relative;
            width: 403px;
            height: 40px;
            background: rgba(217, 217, 217, 0.6);
            border: 1px solid #000000;
            z-index: 6;
        }

        .rectangle-2 {
            position: relative;
            width: 536px;
            height: 310px;
            margin: 55px 0 0 30px;
            background: #d9d9d9;
            z-index: 7;
        }

        .table {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex-wrap: nowrap;
            position: absolute;
            width: 536px;
            height: 310px;
            top: 0;
            left: 0;
            border: 1px solid #000000;
            z-index: 8;
            overflow: hidden;
        }

        .table-head {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 9;
            overflow: hidden;
        }

        .head {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 10;
        }

        .row-bottom-border {
            flex-shrink: 0;
            position: absolute;
            width: 536px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/a176dcb6-d1de-4f72-94c2-cf4f288418c3.png) no-repeat center;
            background-size: cover;
            z-index: 12;
        }

        .head-3 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 11;
        }

        .row {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 13;
            overflow: hidden;
        }

        .cell-text {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 14;
        }

        .row-bottom-border-4 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/642ac687-4333-4b7d-99ae-07477aa466df.png) no-repeat center;
            background-size: cover;
            z-index: 16;
        }

        .cell-text-5 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 15;
        }

        .row-6 {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 17;
            overflow: hidden;
        }

        .cell-text-7 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 18;
        }

        .row-bottom-border-8 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/d5bb30a2-0e65-4c02-afd4-64d8698de1f0.png) no-repeat center;
            background-size: cover;
            z-index: 20;
        }

        .cell-text-9 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 19;
        }

        .row-a {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 21;
            overflow: hidden;
        }

        .cell-text-b {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 22;
        }

        .row-bottom-border-c {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/7f4c2813-66d4-46e3-8ee8-2ed12cebd683.png) no-repeat center;
            background-size: cover;
            z-index: 24;
        }

        .cell-text-d {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 23;
        }

        .row-e {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 25;
            overflow: hidden;
        }

        .cell-text-f {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 26;
        }

        .row-bottom-border-10 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/f8d0bc1a-a3b6-4c20-81e7-e14e133fee41.png) no-repeat center;
            background-size: cover;
            z-index: 28;
        }

        .cell-text-11 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 27;
        }

        .row-12 {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 29;
            overflow: hidden;
        }

        .cell-text-13 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 30;
        }

        .row-bottom-border-14 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/577a1ff7-09f5-4d56-b611-da1ac38c8108.png) no-repeat center;
            background-size: cover;
            z-index: 32;
        }

        .cell-text-15 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 31;
        }

        .row-16 {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 33;
            overflow: hidden;
        }

        .cell-text-17 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 34;
        }

        .row-bottom-border-18 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/92b2707e-34d8-4bd7-83ef-71439cf594a8.png) no-repeat center;
            background-size: cover;
            z-index: 36;
        }

        .cell-text-19 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 35;
        }

        .row-1a {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 37;
            overflow: hidden;
        }

        .cell-text-1b {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 38;
        }

        .row-bottom-border-1c {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/ec8327cd-7f3b-4c68-9e09-be21b0bc80b4.png) no-repeat center;
            background-size: cover;
            z-index: 40;
        }

        .cell-text-1d {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 39;
        }

        .row-1e {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 41;
            overflow: hidden;
        }

        .cell-text-1f {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 42;
        }

        .row-bottom-border-20 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/0e43f4a0-0ee9-47e1-b629-790738034aa4.png) no-repeat center;
            background-size: cover;
            z-index: 44;
        }

        .cell-text-21 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 43;
        }

        .row-22 {
            display: flex;
            align-items: flex-start;
            align-self: stretch;
            flex-wrap: nowrap;
            flex-shrink: 0;
            position: relative;
            min-width: 0;
            z-index: 45;
            overflow: hidden;
        }

        .cell-text-23 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 46;
        }

        .row-bottom-border-24 {
            flex-shrink: 0;
            position: absolute;
            width: 126px;
            height: 1px;
            top: 30px;
            left: 0;
            background: url(./assets/images/8963efe3-f868-4046-ab4c-c3509ef6f972.png) no-repeat center;
            background-size: cover;
            z-index: 48;
        }

        .cell-text-25 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            width: 63px;
            height: 31px;
            color: #000000;
            font-family: Inter, var(--default-font-family);
            font-size: 12px;
            font-weight: 400;
            line-height: 14.523px;
            text-align: center;
            z-index: 47;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <span class="solicitud-residencias">SOLICITUD DE RESIDENCIAS PROFESIONALES</span><span class="location-date">Huatusco de Chicuellar, Ver., a ____ de ________________ del 2023 </span><span class="jefe-residencias">LIC. ADOLFO RENE ALVAREZ LIMA <br />Jefe del Depto. de Residencias
            Profesionales y Servicio Social </span><span class="solicitud-inicio">Por este medio, me permito solicitar el inicio de mi proceso de
            Residencia Profesional para el período escolar actual, contando con
            los<br />siguientes generales:
        </span>
        <div class="flex-row-fa">
            <button class="rectangle">
                <span class="nombre-proyecto">Nombre del Proyecto:</span>
            </button>
            <div class="rectangle-1"></div>
        </div>
        <div class="rectangle-2">
            <div class="table">
                <div class="table-head">
                    <span class="head">Head</span>
                    <div class="row-bottom-border"></div>
                    <span class="head-3">Head</span>
                </div>
                <div class="row">
                    <span class="cell-text">Cell Text</span>
                    <div class="row-bottom-border-4"></div>
                    <span class="cell-text-5">Cell Text</span>
                </div>
                <div class="row-6">
                    <span class="cell-text-7">Cell Text</span>
                    <div class="row-bottom-border-8"></div>
                    <span class="cell-text-9">Cell Text</span>
                </div>
                <div class="row-a">
                    <span class="cell-text-b">Cell Text</span>
                    <div class="row-bottom-border-c"></div>
                    <span class="cell-text-d">Cell Text</span>
                </div>
                <div class="row-e">
                    <span class="cell-text-f">Cell Text</span>
                    <div class="row-bottom-border-10"></div>
                    <span class="cell-text-11">Cell Text</span>
                </div>
                <div class="row-12">
                    <span class="cell-text-13">Cell Text</span>
                    <div class="row-bottom-border-14"></div>
                    <span class="cell-text-15">Cell Text</span>
                </div>
                <div class="row-16">
                    <span class="cell-text-17">Cell Text</span>
                    <div class="row-bottom-border-18"></div>
                    <span class="cell-text-19">Cell Text</span>
                </div>
                <div class="row-1a">
                    <span class="cell-text-1b">Cell Text</span>
                    <div class="row-bottom-border-1c"></div>
                    <span class="cell-text-1d">Cell Text</span>
                </div>
                <div class="row-1e">
                    <span class="cell-text-1f">Cell Text</span>
                    <div class="row-bottom-border-20"></div>
                    <span class="cell-text-21">Cell Text</span>
                </div>
                <div class="row-22">
                    <span class="cell-text-23">Cell Text</span>
                    <div class="row-bottom-border-24"></div>
                    <span class="cell-text-25">Cell Text</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Generated by Codia AI - https://codia.ai/ -->
</body>

</html>