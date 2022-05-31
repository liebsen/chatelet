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
        .bg-light {
          background-color: whitesmoke;
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
            <code>
              <table class="table">
                <tr>
                  <th colspan="2"><strong><?= strtoupper($ticket['def_orden_retiro']) ?></strong></th>
                </tr>
                <tr>
                  <td><strong><?php echo __('Fecha y hora'); ?></strong></td>
                  <td><?= $ticket['created'] ?></td>
                </tr>
                <tr>
                  <td><strong><?php echo __('Nombre'); ?></strong></td>
                  <td><?= $ticket['nombre'] ?> <?= $ticket['apellido'] ?></td>
                </tr>
                <tr>
                  <td><strong><?php echo __('DNI'); ?></strong></td>
                  <td><?= $ticket['dni'] ?></td>
                </tr>
                <tr>
                  <td><strong><?php echo __('Teléfono'); ?></strong></td>
                  <td><?= $ticket['telefono'] ?></td>
                </tr>
                <tr>
                  <td><strong><?php echo __('Dirección'); ?></strong></td>
                  <td><?= $ticket['calle'] ?> <?= $ticket['nro'] ?> <?= $ticket['piso'] ?> <?= $ticket['depto'] ?> (<?= $ticket['cp'] ?>) <?= $ticket['localidad'] ?> <?= $ticket['provincia'] ?></td>
                </tr>
                <!--tr class="bg-light">
                  <td><strong><?php echo __('Peso'); ?></strong></td>
                  <td><?= $package['weight'] / 1000 ?>kg</td>
                </tr>
                <tr class="bg-light">
                  <td><strong><?php echo __('Volumen'); ?></strong></td>
                  <td><?= (integer) $package['width'] * $package['height'] * $package['depth'] ?>cm3</td>
                </tr-->
              </table>
            </code>           
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