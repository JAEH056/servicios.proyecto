<pre>
¿Qué tipo de solicitud tenemos?

<?php if($solicitud->getTipo() == 'varia'): ?>
    Para cositas locas
<?php else: ?>
    Para aprender
<?php endif ?>

<?php if( $solicitud instanceof App\Clases\SolicitudVaria ): ?>
    Para cositas locas (instanceof)
<?php else: ?>
    Para aprender (instanceof)
<?php endif ?>

</pre>