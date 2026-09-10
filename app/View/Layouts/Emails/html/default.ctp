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
    <title>Châtelet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body style="font-family:-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;font-size: 16px;font-color: #333;background-color: #ffffff; width:100%; overflow-x: hidden;">
    <table cellpadding="0" cellspacing="0" width="100%" align="center">
<?php if(empty($skip_header)):?>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 16px;min-height: 120px;">
            <tr>
              <td align="center"><a href="<?=$site_url?>" target="_blank"><?php echo $this->html->image($site_url."/images/logo.png", ['width' => '140px']); ?></a></td>
            </tr>
          </table>
        </td>
      </tr>
<?php endif ?>
      <tr>
        <td align="center" class="content"><?php echo $this->fetch('content'); ?></td>
      </tr>
      <?php if(!empty($socials) && count(@$socials)): ?>
      <tr>
        <td align="center" style="padding: 20px; color: #888888">
          <div style="margin-bottom: 20px;">
            <h6>Seguinos en nuestras redes<h6>
          </div>
          <table border="0">
            <tr>
<?php foreach($socials as $social => $url) : ?>
              <td align="center" valign="center">
                <a href="<?php echo $url ?>" style="margin-right: 15px; text-decoration: none; color: #888888; font-weight: 300; font-size: 14px" target="_blank">
                  <img src="<?=$site_url?>/img/share/<?php echo $social ?>-brands-solid.png" style="transform: translateY(7px);" width="24" height="24">
                  <span><?php echo ucfirst($social) ?></span></a>
              </td>
<?php endforeach ?>
            </tr>
          </table>
        </td>
      </tr>
      <?php endif ?>
      <tr>
        <td align="center" style="padding: 8px; color: #aaaaaa">
          <small style="font-size: 12px">&copy; <?php echo date('Y',time()); ?> Châtelet &mdash; Todos los derechos reservados</small>
<?php if(!empty($unsubscribe_id)):?>
					<small>
						<a href="<?="{$site_url}/newsletter/unsubscribe/{$unsubscribe_id}"?>" style="font-size: 12px; padding-top: 10px">Deseo desuscribirme de este Newsletter</a>
					</small>          
<?php endif ?>
        </td>
      </tr>
    </table>
  </body>
</html>