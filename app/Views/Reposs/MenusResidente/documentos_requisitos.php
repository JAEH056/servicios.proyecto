<!-- FORMA PARA SUBIR DOCUMENTOS (SOLICITUD RESIDENCIA) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('error' . 'solicitud_residencias')): ?>
    <div class="alert alert-danger"><?= session()->get('error' . 'solicitud_residencias') ?></div>
<?php endif; ?>
<?php if (session()->get('success' . 'solicitud_residencias')): ?>
    <div class="alert alert-success"><?= session()->get('success' . 'solicitud_residencias') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($solicitud_residencias): ?>
    <div class="col-md-6">
        Ya has subido un documento(Solicitud Residencias): <strong><?= $solicitud_residencias['iddocumento'], $solicitud_residencias['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Solicitud Residencias</strong>)?" data-href="<?= base_url('usuario/residentes/delete/6') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/6') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
        <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="solicitud_residencias">Subir Solicitud Residencias.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="solicitud_residencias" name="solicitud_residencias" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CARTA PRESENTACION) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('error' . 'carta_presentacion')): ?>
    <div class="alert alert-danger"><?= session()->get('error' . 'carta_presentacion') ?></div>
<?php endif; ?>
<?php if (session()->get('success' . 'carta_presentacion')): ?>
    <div class="alert alert-success"><?= session()->get('success' . 'carta_presentacion') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($carta_presentacion): ?>
    <div class="col-md-6">
        Ya has subido un documento(Carta Presentacion): <strong><?= $carta_presentacion['iddocumento'], $carta_presentacion['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Carta Presentacion</strong>)?" data-href="<?= base_url('usuario/residentes/delete/7') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/7') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="carta_presentacion">Subir Carta Presentacion.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="carta_presentacion" name="carta_presentacion" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CARTA ACEPTACION) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('error' . 'carta_aceptacion')): ?>
    <div class="alert alert-danger"><?= session()->get('error' . 'carta_aceptacion') ?></div>
<?php endif; ?>
<?php if (session()->get('success' . 'carta_aceptacion')): ?>
    <div class="alert alert-success"><?= session()->get('success' . 'carta_aceptacion') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($carta_aceptacion): ?>
    <div class="col-md-6">
        Ya has subido un documento(Carta Aceptación): <strong><?= $carta_aceptacion['iddocumento'], $carta_aceptacion['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Carta Aceptación</strong>)?" data-href="<?= base_url('usuario/residentes/delete/8') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/8') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="carta_aceptacion">Subir Carta Aceptación.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="carta_aceptacion" name="carta_aceptacion" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

<!-- FORMA PARA SUBIR DOCUMENTOS (CARTA ACEPTACION) -->
<!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
<?php if (session()->get('error' . 'anteproyecto')): ?>
    <div class="alert alert-danger"><?= session()->get('error' . 'anteproyecto') ?></div>
<?php endif; ?>
<?php if (session()->get('success' . 'anteproyecto')): ?>
    <div class="alert alert-success"><?= session()->get('success' . 'anteproyecto') ?></div>
<?php endif; ?>
<!-- Fin Bloque de mensajes -->
<!-- Verificar si ya hay un documento cargado -->
<?php if ($anteproyecto): ?>
    <div class="col-md-6">
        Ya has subido un documento(Anteproyecto): <strong><?= $anteproyecto['iddocumento'], $anteproyecto['archivo'] ?></strong>
    </div>
    <div class="col-md-6">
        <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
            data-info="¿Desea eliminar el Documento (<strong>Anteproyecto</strong>)?" data-href="<?= base_url('usuario/residentes/delete/9') ?>">Eliminar</button>
    </div>
<?php else: ?>
    <form action="<?= base_url('usuario/residentes/upload/9') ?>" method="POST" enctype="multipart/form-data">
        <!-- Form Row-->
        <div class="row gx-3 mb-3">
            <?= csrf_field() ?>
            <!-- Form Group (Nombre archivo)-->
            <label for="anteproyecto">Subir Anteproyecto.</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="anteproyecto" name="anteproyecto" required>
            </div>
            <!-- Form Group (boton de carga)-->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Subir Documento</button>
            </div>
        </div>
    </form>
<?php endif; ?>
<!-- FIN FORMA PARA SUBIR DOCUMENTOS -->