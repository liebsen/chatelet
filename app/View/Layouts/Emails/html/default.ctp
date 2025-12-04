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
      #main {
        font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;
        font-size: 16px;
        font-color: #333;
        background-color: #f8f8f8;
      }

      #header {
        width: auto;
        backgound-color: #ffffff; 
        border-radius: 16px;
        padding: 16px;
        height: 120px;
      }

      #content {
        backgound-color: #ffffff; 
        border-radius: 16px;
        height: 120px;
        width:auto; 
        padding: 16px;
      }
    </style>
  </head>
  <body>
    <table id="main" cellpadding="0" cellspacing="0" width="600" align="center" style="backgound-color: #f8f8f8; width:100%;" >
      <tr>
        <td>
          <table id="header" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td align="center"><?php echo $this->html->image(Router::url('/',true)."images/logo.jpg", ['width' => '200px']); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center">
          <table id="content" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td align="center"><?php echo $this->fetch('content'); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><small>&copy; <?php echo date('Y',time()); ?> Châtelet &mdash; Todos los derechos reservados</small></td>
      </tr>
    </table>
  </body>
</html>