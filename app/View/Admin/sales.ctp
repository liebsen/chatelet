<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->css('/css/admin-sales.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-sales', array('inline' => false)); ?>

<!-- logistic selector -->
<div class="fullhd-selector logistic-selector">
    <span class="close is-clickable" onclick="logisticsClose()">
        <i class="gi gi-remove_2"></i>
    </span>
    <div class="row">
        <div class="col-xs-12">
            <form id="update_logistic">
                <h3>Logística de venta <span id="logistic_sale_id"></span></h3>
                <div class="form-group">
                <?php foreach($logistics as $logistic): ?>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="logistic_option" id="logistic_option_<?= $logistic['Logistics']['id'] ?>" value="<?= $logistic['Logistics']['id'] ?>" data-name="<?= $logistic['Logistics']['code'] ?>">
                      <label class="form-check-label" for="logistic_option_<?= $logistic['Logistics']['id'] ?>">
                        <?= $logistic['Logistics']['title'] ?>
                      </label>
                    </div>
                <?php endforeach ?>
                </div>
                <div class="form-group">
                    <button type="button" id="logistic_save_btn" class="btn btn-primary" onclick="logisticUpdate()">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="/admin/sales_export_mails" target="_blank">
            <button class="btn btn-success" type="button" style="margin-top: -2px;">Exportar Emails</button>
        </a> 
        <?php if(!isset($_GET['extended'])) :?>
        <a href="/admin/sales?extended=1">
            <button class="btn btn-success" type="button" style="margin-top: -2px;">Más ventas</button>
        </a>
        <?php endif ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table id="example-datatables2" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Cliente - (MercadoPago)</th>
                    <th class="text-center">Detalles</th>
                    <th class="text-center">Envio</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale):

                $personalInfoShowed=false;
                ?>
                <tr>
                    <td class="col-xs-1 text-center" data-sort="<?php echo date('Y-m-d',strtotime($sale['collection']['date_approved'])) ?>">
                        <?php echo date('d/m/Y',strtotime($sale['collection']['date_approved'])) ?><br />
                        <?php echo date('H:i:s',strtotime($sale['collection']['date_approved'])) ?><br />
                    </td>
                    <td class="col-xs-3">
                        <div class="row">
                            <div class="col-xs-2"></div>
                            <div class="col-xs-10">
                                <dl class="list">
                                    <dt>Nombre</dt>
                                    <dd><?php echo $sale['collection']['payer']['first_name'] ?>&nbsp;</dd>
                                    <dt>Apellido</dt>
                                    <dd><?php echo $sale['collection']['payer']['last_name'] ?>&nbsp;</dd>
                                    <dt>Email</dt>
                                    <dd><?php echo $sale['collection']['payer']['email'] ?>&nbsp;</dd>
                                    <dt>Telefono</dt>
                                    <dd><?php echo $sale['collection']['payer']['phone']['number'] ?>&nbsp;</dd>
                                </dl>
                            </div>
                        </div>
                    </td>
                    <td class="col-xs-6">
                        <?php
                         foreach ($sale['collection']['sale_products'] as $reason): ?>
                            <div class="row">
                            <?php $column = 4;  ?>

                                <?php if (!$personalInfoShowed): ?>
                                <p><strong>Datos Personales: </strong></p>

                                <div class="col-xs-12">
                                    <ul class="list">
                                        <?php $details = explode('-|-', $reason);
                                        if (count($details) > 10){$column=6;}
                                         ?>
                                        <?php foreach ($details as $key => $detail): ?>
                                            <?php $extra = explode(' : ', $detail) ?>
                                            <?php if (!empty($extra[0]) && !empty($extra[1])): ?>
                                                <?php if (in_array(trim(strtoupper($extra[0])), array('PEDIDO','CODIGO','PRODUCTO','TALLE','COLOR','PRECIO_DESCUENTO','PRECIO_LISTA'))) continue; ?>
                                                <li><?php echo $extra[0] ?>: <?php echo $extra[1] ?></li>
                                            <?php endif ?>
                                        <?php endforeach; $personalInfoShowed=true; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <table border="1">
                        <?php foreach ($sale['collection']['sale_products'] as $indice => $reason): ?>



                                        <?php $details = explode('-|-', $reason);
                                        if (count($details) > 10){$column=6;}
                                        ?>
                                        <?php if (!$indice): ?>
                                            <tr>
                                        <?php foreach ($details as $key => $detail): ?>
                                            <?php $extra = explode(' : ', $detail) ?>
                                        <?php if (!empty($extra[0])): ?>
                                            <?php if (!in_array(trim(strtoupper($extra[0])), array('PEDIDO','CODIGO','PRODUCTO','TALLE','COLOR','PRECIO_DESCUENTO','PRECIO_LISTA'))) continue; ?>
                                                <td><?php echo $extra[0] ?></td>
                                        <?php endif ?>
                                        <?php endforeach ?>
                                        </tr>
                                        <?php endif; ?>
                                        <tr class="list">
                                        <?php foreach ($details as $key => $detail):
                                        ?>
                                            <?php $extra = explode(' : ', $detail) ?>
                                            <?php if (!empty($extra[1])): ?>
                                            <?php if (!in_array(trim(strtoupper($extra[0])), array('PEDIDO','CODIGO','PRODUCTO','TALLE','COLOR','PRECIO_DESCUENTO','PRECIO_LISTA'))) continue; ?>
                                                <td><?php echo $extra[1] ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        </tr>
                        <?php endforeach ?>
                         </table>
                     </td>
                    <td class="col-xs-1 text-center"><!--[[<?=@$sale['local_sale']['shipping_type']?>]]-->
                        <?php
                        if (!empty($sale['local_sale']['id']) && 
                            !empty($sale['local_sale']['apellido']) && 
                            !empty($sale['local_sale']['cargo']) && 
                            $sale['local_sale']['cargo'] == 'shipment') : ?>
                            <span class="text-info" id="shipping_title_<?= $sale['local_sale']['id'] ?>"><?= strtoupper($sale['local_sale']['shipping']) ?></span><br>
                            <?php if (empty($sale['local_sale']['def_orden_retiro'])):?>
                                <span class="btn btn-link" onclick="editLogistic(<?= $sale['local_sale']['id'] ?>, <?= $sale['local_sale']['logistic_id'] ?>)">
                                    <i class="gi gi-edit"></i> Cambiar logística
                                </span><br>
                            <?php endif ?>

                            <span class="btn btn-info" onclick="getTicket('<?php echo $sale['local_sale']['id'];?>', this)">TICKET</span>
                             <br />
                            <?= $sale['local_sale']['def_mail_sent'] ? '<p class="text-success">Notificación enviada</p>' : '<p class="text-danger">Notificación no enviada</p>';?>
                        <?php else: ?>
                            <p class="text-muted">(Sin Etiqueta)</p>
                        <?php endif ?>
                        <?php 
                        $defaultCost = 0;
                        if (date('Ymd',strtotime($sale['collection']['date_approved'])) > '20161108')
                            $defaultCost=0;
                        $state = empty($sale['collection']['free_shipping']) ? 'text-success' : 'text-danger';
                        echo '<p class="'.$state.'"> $';
                        echo (!empty($sale['collection']['deliver_cost']))?$sale['collection']['deliver_cost']:$defaultCost;
                        echo '</p>'?>
                        (<?php echo count($sale['collection']['sale_products']) ?> item)
                    </td>
                    <td class="col-xs-1 text-center">
                        $<?php echo $sale['collection']['transaction_amount'] ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>