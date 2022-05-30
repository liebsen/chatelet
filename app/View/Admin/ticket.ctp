<!DOCTYPE html>
  <html>
    <head>
      <title>Imprimir etiqueta</title>
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
      <link rel="shortcut icon" href="/img/favicon.ico">
      <?= $this->Html->css('bootstrap') ?>
      <style>
        body {
          padding: 1rem;
        }
        @media print {
          .form-actions {
            display: none;
          }
        }
      </style>
    </head>
    <body>
      <div class="container-fluid">
      <?php if(isset($ticket)): ?>
        <div class="row">
          <div class="col">
            <pre>
              <table class="table table-striped">
                <tr>
                  <th colspan="2"><?= strtoupper($ticket['def_orden_retiro']) ?></th>
                </tr>
                <tr>
                  <td><?php echo __('Nombre'); ?></td>
                  <td><?= $ticket['nombre'] ?> <?= $ticket['apellido'] ?></td>
                </tr>
                <tr>
                  <td><?php echo __('DNI'); ?></td>
                  <td><?= $ticket['dni'] ?></td>
                </tr>
                <tr>
                  <td><?php echo __('Teléfono'); ?></td>
                  <td><?= $ticket['telefono'] ?></td>
                </tr>
                <tr>
                  <td><?php echo __('Dirección'); ?></td>
                  <td><?= $ticket['calle'] ?> <?= $ticket['nro'] ?> <?= $ticket['piso'] ?> <?= $ticket['depto'] ?> (<?= $ticket['cp'] ?>) <?= $ticket['localidad'] ?> <?= $ticket['provincia'] ?></td>
                </tr>
                <tr>
                  <td><?php echo __('Fecha y hora'); ?></td>
                  <td><?= $ticket['created'] ?></td>
                </tr>
              </table>
            </pre>           
            <br />               
            <div class="form-actions">
              <button type="reset" class="btn btn-danger" onclick="window.close()"><i class="icon-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-success" onclick="window.print()"><i class="icon-print"></i> Imprimir</button>
            </div>
          </div>
        </div>
      <?php else: ?>
        <p>No se encontró la venta</p>
      <?php endif ?>
      </div>
    </body>
  </html>