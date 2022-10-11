<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->css('/css/admin-sales.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-sales', array('inline' => false)); ?>
<?php 

$list_payments = [
    '' => "Transferencia",
    'credit_card' => "Tarjeta de Crédito",
    'ticket' => "Ticket",
    'account_money' => "Efectivo",
];
$list_status = [
    '' => "Pendiente",
    'approved' => "Aprobado",
    'processing' => "Procesando...",
    'rejected' => "Rechazado",
];
?>
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
        <button class="btn btn-success" type="button" id="expandall" style="margin-top: -2px;">
            <i class="gi gi-expand"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table id="example-datatables2" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center toggle-table toggle-table-hidden">Detalles</th>
                    <th class="text-center">Envío</th>
                    <th class="text-center">Método de pago</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array) $sales as $sale):

                $personalInfoShowed=false;
                ?>
                <tr class="is-clickable">
                    <td class="col-xs-1" data-sort="<?php echo date('Y-m-d',strtotime($sale['collection']['date_approved'])) ?>">
                        <strong><?php echo date('d/m/Y',strtotime($sale['collection']['date_approved'])) ?></strong><br />
                        <small><?php echo date('H:i:s',strtotime($sale['collection']['date_approved'])) ?></small><br />
                    </td>
                    <td class="col-xs-3">
                        <strong><?php echo @$sale['collection']['cardholder']['name'] ?: @$sale['local_sale']['nombre'] . ' ' . @$sale['local_sale']['apellido'] ?></strong><br>
                        <small><?php echo @$sale['collection']['cardholder']['identification']['type'] ?: @$sale['local_sale']['dni'] ?> <?php echo @$sale['collection']['cardholder']['identification']['number'] ?></small>
                    </td>
                    <td class="col-xs-6 toggle-table toggle-table-hidden">
                        <?php
                        foreach ((array) @$sale['collection']['sale_products'] as $reason): ?>
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
                        <?php foreach ((array) @$sale['collection']['sale_products'] as $indice => $reason): ?>



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
                    <td class="col-xs-1"><!--[[<?=@$sale['local_sale']['shipping_type']?>]]-->
                    <?php 
                    $defaultCost = 0; ?>
                    <strong id="shipping_title_<?= $sale['local_sale']['id'] ?>" onclick="getTicket('<?= @$sale['local_sale']['id'] ?>', this)">
                        <?= @strtoupper($sale['local_sale']['shipping']) ?> <?= !empty($sale['collection']['free_shipping']) ? '<i class="gi gi-gift text-success"' : '' ?>
                    </strong><br>
                    <small>$<?= !empty($sale['collection']['deliver_cost']) ? $sale['collection']['deliver_cost'] : $defaultCost ?></small>
                    <?php
                    if (!empty($sale['local_sale']['id']) && !empty($sale['local_sale']['apellido']) && !empty($sale['local_sale']['cargo']) && $sale['local_sale']['cargo'] == 'shipment'): ?>
                        <?php if (empty($sale['local_sale']['def_orden_retiro'])):?>
                            <span class="btn btn-link" onclick="editLogistic(event,<?= $sale['local_sale']['id'] ?>, <?= $sale['local_sale']['logistic_id'] ?>)">
                                <i class="gi gi-edit"></i>
                            </span>
                        <?php endif ?>
                        <!--span class="btn btn-info" onclick="getTicket('<?php echo $sale['local_sale']['id'];?>', this)">TICKET</span-->
                        <?= $sale['local_sale']['def_mail_sent'] ? '<i class="fa fa-check-square-o text-success" title="Notificación enviada"></i>' : '<i class="fa fa-times text-danger" title="Notificación no enviada"></i>' ?>
                    <?php else: ?>
                        <?php if(@$sale['local_sale']['cargo'] === 'takeaway'): ?>
                            <i class="fa building-o text-muted" title="Takeaway"></i>
                        <?php endif ?>
                    <?php endif ?>
                    </td>
                    <td class="col-xs-3">
                        <strong><?php echo @$list_payments[$sale['collection']['payment_type']] ?></strong><br>
                        <small><?= @$sale['collection']['payment_type'] === 'credit_card' ? @$sale['collection']['last_four_digits'] : @$sale['collection']['merchant_order_id'] ?></small>
                    </td>                    
                    <td class="col-xs-3">
                        <strong><?php echo @$list_status[$sale['collection']['status']] ?></strong><br>
                        <small><?php echo @$sale['collection']['date_approved'] ?></small>
                    </td>                    
                    <td class="col-xs-1 text-center">
                        <strong>$<?= @$sale['collection']['transaction_amount'] ?: @$sale['local_sale']['value'] ?> </strong><br>
                        <small>(<?= count(@$sale['collection']['sale_products']) ?> items)</small>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>