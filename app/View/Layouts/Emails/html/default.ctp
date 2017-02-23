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
<table id="main" cellpadding="0" cellspacing="0" color="##FFF;" width="600" align="center">
            <tr >
                <td class="header">
                    <table style="width:100%;" id="header" cellpadding="0" cellspacing="0" align="center">
                        <tr style="text-align:center;">
                            
                        </tr>
                    </table>
                </td>
            </tr>
            <?php echo $this->fetch('content'); ?>
            <tr>
                <td>
                    <table style="margin-top:5%;" id="copy" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td style="padding:15px!important;text-align: center;font-weight: bold;" width="600" height="48">
                                <table cellpadding="0" cellspacing="0">
                                  
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
</body>
</html>