<!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA KARDEX) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('errorconstancia_80%')): ?>
    <div class="alert alert-danger"><?= session()->get('errorconstancia_80%') ?></div>
<?php endif; ?>
<?php if (session()->get('successconstancia_80%')): ?>
    <div class="alert alert-success"><?= session()->get('successconstancia_80%') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($kardex): ?>
    <div class="col-md-6">
        Ya has subido un documento(Constancia 80%): <strong><?= $kardex['iddocumento'], $kardex['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Constancia 80%</strong>)?" data-href="<?= base_url('usuario/residentes/delete/1') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/1') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="constancia_80%">Subir Constancia del 80%</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="kardex" name="constancia_80%" multiple required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA SERVICIO SOCIAL) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('errorconstancia_servicio_social')): ?>
    <div class="alert alert-danger"><?= session()->get('errorconstanciaSS') ?></div>
<?php endif; ?>
<?php if (session()->get('successconstancia_servicio_social')): ?>
    <div class="alert alert-success"><?= session()->get('successconstancia_servicio_social') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($constanciaSS): ?>
    <div class="col-md-6">
        Ya has subido un documento(Constancia Servicio Social): <strong><?= $constanciaSS['iddocumento'], $constanciaSS['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Constancia de Servicio Social</strong>)?" data-href="<?= base_url('usuario/residentes/delete/2') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/2') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="constancia_servicio_social">Subir Constancia Servicio Social</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="constanciaSS" name="constancia_servicio_social" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA ACTIVIDADES COMPLEMENTARIAS) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('errorconstancia_actividades_complementarias')): ?>
    <div class="alert alert-danger"><?= session()->get('errorconstancia_actividades_complementarias') ?></div>
<?php endif; ?>
<?php if (session()->get('successconstancia_actividades_complementarias')): ?>
    <div class="alert alert-success"><?= session()->get('successconstancia_actividades_complementarias') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($constanciaAC): ?>
    <div class="col-md-6">
        Ya has subido un documento(Constancia Actividades Complementarias): <strong><?= $constanciaAC['iddocumento'], $constanciaAC['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Constancia de Actividades Complementarias</strong>)?" data-href="<?= base_url('usuario/residentes/delete/3') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/3') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="constancia_actividades_complementarias">Subir Constancia Actividades Complementarias</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="constanciaAC" name="constancia_actividades_complementarias" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA PAGO REINSCRIPCION) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('errorpago_reinscripcion')): ?>
    <div class="alert alert-danger"><?= session()->get('errorpago_reinscripcion') ?></div>
<?php endif; ?>
<?php if (session()->get('successpagoReinscripcion')): ?>
    <div class="alert alert-success"><?= session()->get('successpago_reinscripcion') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($pagoReinscripcion): ?>
    <div class="col-md-6">
        Ya has subido un documento(Pago de Reinscripción): <strong><?= $pagoReinscripcion['iddocumento'], $pagoReinscripcion['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Pago de Reinscripción</strong>)?" data-href="<?= base_url('usuario/residentes/delete/4') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/4') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="pagoReinscripcion">Subir Pago de Reinscripcion.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="pago_reinscripcion" name="pago_reinscripcion" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA VIGENCIA DE SEGURO) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('errorvigencia_seguro')): ?>
    <div class="alert alert-danger"><?= session()->get('errorvigencia_seguro') ?></div>
<?php endif; ?>
<?php if (session()->get('successvigencia_seguro')): ?>
    <div class="alert alert-success"><?= session()->get('successvigencia_seguro') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($vigenciaSeguro): ?>
    <div class="col-md-6">
        Ya has subido un documento(Vigencia de Seguro): <strong><?= $vigenciaSeguro['iddocumento'], $vigenciaSeguro['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Vigencia de Seguro</strong>)?" data-href="<?= base_url('usuario/residentes/delete/5') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/5') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="vigencia_seguro">Subir Vigencia de Seguro.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="vigencia_seguro" name="vigencia_seguro" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS (REQUISITOS)-->