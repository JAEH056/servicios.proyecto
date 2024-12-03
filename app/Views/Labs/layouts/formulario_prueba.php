<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_agregar_dias_inhabiles_dos') ?>
<?= form_open('/dias_inabiles') ?>
<div>
        <?= form_label('Nombre del Producto', 'nombre') ?>
        <?= form_input('nombre', set_value('nombre'), ['id' => 'nombre', 'class' => 'form-control']) ?>
        <?= \Config\Services::validation()->getError('nombre') ?>
    </div>
    <div>
        <?= form_label('Precio', 'precio') ?>
        <?= form_input('precio', set_value('precio'), ['id' => 'precio', 'class' => 'form-control']) ?>
        <?= \Config\Services::validation()->getError('precio') ?>
    </div>
    <div>
        <?= form_submit('submit', 'Agregar', ['class' => 'btn btn-primary']) ?>
    </div>
<?= form_close() ?>
<?= $this->endSection() ?>