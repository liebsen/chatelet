<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
  </head>
  <body style="font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;font-size: 16px;font-color: #333;background-color: #f8f8f8; width:100%; overflow-x: hidden;">
    <table cellpadding="0" cellspacing="0" width="600" align="center">
<?php if(empty($skip_header)):?>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 16px;height: 120px;">
            <tr>
              <td align="center"><?php echo $this->html->image($site_url."/images/logo.png", ['width' => '200px']); ?></td>
            </tr>
          </table>
        </td>
      </tr>
<?php endif ?>
      <tr>
        <td align="center">
          <table cellpadding="0" cellspacing="0" align="center" style="background-color: #ffffff; border-radius: 16px;height: 120px;width:auto; padding: 32px 24px; box-shadow: 0 0 8px rgba(0,0,0,0.1)">
            <tr>
              <td align="center"><?php echo $this->fetch('content'); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <?php if(isset($socials) && count(@$socials)): ?>
      <tr>
        <td align="center" style="padding: 20px; color: #888888">
          <small>Seguinos en nuestras redes<small><br>
          <?php foreach($socials as $social => $url) : ?>
            <a href="<?php echo $url ?>" style="margin-right: 10px;" target="_blank">
              <img src="/img/share/<?php echo $social ?>-brands-solid.png" style="display: inline; margin-bottom: -10px" width="24" height="24">
              <?php echo ucfirst($social) ?>
            </a>
          <?php endforeach ?>
          </small>
        </td>
      </tr>
      <?php endif ?>
      <tr>
        <td align="center" style="padding: 8px; color: #888888">
          <small>&copy; <?php echo date('Y',time()); ?> Châtelet &mdash; Todos los derechos reservados</small>
        </td>
      </tr>
    </table>
  </body>
</html>