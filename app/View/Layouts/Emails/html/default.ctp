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
  <body>
    <table id="main" cellpadding="0" cellspacing="0" color="##FFF;" width="600" align="center" style="width:100%;" >
      <tr>
        <td class="header">
          <table id="header" cellpadding="0" cellspacing="0" align="center" style="width:100%;" >
            <tr style="text-align:center;">
              <?php echo $this->html->image(Router::url('/',true)."images/logo.jpg", ['width' => '200px']); ?>
            </tr>
          </table>
        </td>
      </tr>
      <tr style="text-align:center;">
        <td><?php echo $this->fetch('content'); ?></td>
      </tr>
      <tr style="text-align:center;">
        <td>
          &copy; <?php echo date('Y',time()); ?> &copy; Châtelet <p>Todos los derechos reservados.</p>
        </td>
      </tr>
    </table>
  </body>
</html>