<?php $weekdays = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'] ?>
<!DOCTYPE html>
  <html>
    <head>
      <title><?= strtoupper($ticket['def_orden_retiro']) ?></title>
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
      <link rel="shortcut icon" href="/img/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,500,600,700" rel="stylesheet">
      <?= $this->Html->css('plugins') ?>
      <?= $this->Html->css('bootstrap') ?>
      <style>
        body {
          font-family: 'Roboto Condensed', Verdana, Arial, Sans-Serif;
          font-size: 1rem;
          padding: 1rem;
        }
        .bg-light {
          background-color: whitesmoke;
        }
        .shop-logo {
          margin-left: 1rem;
          margin-bottom: 1.5rem;
        }
        .is-close {
          width: 4rem;
          height: 4rem;          
          position: fixed;
          z-index: 10;
          top: 2rem;
          right: 1rem;
          color: red;
          font-size: 2rem;
        }
        .table {
          display: inline-block;
          margin-bottom: 0;
        }
        .text-orden-retiro {
          font-size: 1.5rem;
          font-weight: 800;
        }
        @media print {
          .form-actions {
            padding-top: 1rem;
            display: none;
          }
        }
      </style>
    </head>
    <body>
      <div class="container-fluid">
        <span class="is-close is-clickable" onclick="window.close()">
            <i class="gi gi-remove_2"></i>
        </span>

      <?php if(isset($ticket)): ?>
        <div class="row">
          <div class="col">
            <img class="shop-logo" height="40" src="/img/logo.jpg">
            <table class="table table-striped">
              <tr>
                <td width="150"><h6><?php echo __('Órden de retiro'); ?></h6></td>
                <td><h5 class="text-orden-retiro"><?= strtoupper($ticket['def_orden_retiro']) ?></h5></td>
              </tr>
              <tr>
                <td><h6><?php echo __('Fecha y hora'); ?></h6></td>
                <td><h5><?= implode(' ', [date('j/n/y H:i', strtotime($ticket['created'])), ' ('.$weekdays[date('w', strtotime($ticket['created']))].')']) ?></h5></td>
              </tr>
              <tr>
                <td><h6><?php echo __('Nombre'); ?></h6></td>
                <td><h5><?= $ticket['nombre'] ?> <?= $ticket['apellido'] ?></h5></td>
              </tr>
              <tr>
                <td><h6><?php echo __('DNI'); ?></h6></td>
                <td><h5><?= $ticket['dni'] ?></h5></td>
              </tr>
              <tr>
                <td><h6><?php echo __('Teléfono'); ?></h6></td>
                <td><h5><?= $ticket['telefono'] ?></h5></td>
              </tr>
              <tr>
                <td><h6><?php echo __('Dirección'); ?></h6></td>
                <td>
                  <h5><?= $ticket['calle'] ?> <?= $ticket['nro'] ?> <?= $ticket['piso'] ?> <?= $ticket['depto'] ?><br>
                  <?= $ticket['localidad'] ?> (<?= $ticket['cp'] ?>)<br><?= $ticket['provincia'] ?></h5>
                  <br>
                </td>
              </tr>
              <!--tr class="bg-light">
                <td><h6><?php echo __('Peso'); ?></h6></td>
                <td><?= $package['weight'] / 1000 ?>kg</td>
              </tr>
              <tr class="bg-light">
                <td><h6><?php echo __('Volumen'); ?></h6></td>
                <td><?= (integer) $package['width'] * $package['height'] * $package['depth'] ?>cm3</td>
              </tr-->
            </table>
            <?php $address = $ticket['calle'].' '.$ticket['nro'].', '.$ticket['localidad'].' '.$ticket['cp']. ', Argentina'; ?>

            <img width="200" height="200" src="https://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($address) ?>&scale=1&markers=color:blue|<?= urlencode($address) ?>&zoom=10&size=300x300&maptype=roadmap&key=AIzaSyCQu35UZPyvcpbjfgr6EYyebBdgI-kR4X8" alt="<?= $address ?>">
            <img width="200" height="200" src="https://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($address) ?>&scale=1&markers=color:blue|<?= urlencode($address) ?>&zoom=16&size=300x300&maptype=roadmap&key=AIzaSyCQu35UZPyvcpbjfgr6EYyebBdgI-kR4X8" alt="<?= $address ?>">            
            <br />
            <h6>Gracias por su compra.</h6>            
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