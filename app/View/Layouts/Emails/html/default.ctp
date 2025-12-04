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
    <style>
      body {
        font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;
      }
    </style>
  </head>
  <body>
    <table id="main" cellpadding="0" cellspacing="0" color="##FFF;" width="600" align="center" style="width:100%; height: 120px" >
      <tr>
        <td class="header">
          <table id="header" cellpadding="0" cellspacing="0" align="center" style="width:100%;" >
            <tr>
              <td align="center">
                <?php echo $this->html->image(Router::url('/',true)."images/logo.jpg", ['width' => '200px']); ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center"><?php echo $this->fetch('content'); ?></td>
      </tr>
      <tr style="text-align:center;">
        <td align="center">
          &copy; <?php echo date('Y',time()); ?> Châtelet <p>Todos los derechos reservados.</p>
        </td>
      </tr>
    </table>
  </body>
</html>