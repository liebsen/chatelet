<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->css('/css/admin-sales.css?v=' . Configure::read('DIST_VERSION'), array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-sales.js?v=' . Configure::read('DIST_VERSION'), array('inline' => false)); ?>

<!-- bank layer -->

<div class="fullhd-layer bank-layer">
    <span class="close is-clickable" onclick="layerClose()">
        <i class="gi gi-remove_2"></i>
    </span>
    <div class="row">
        <div class="col-xs-12">
            <form id="update_logistic">
                <h3>Marcar como completada venta <span class="sale_id"></span></h3>
                <div class="form-group">
                    <input class="form-input" type="checkbox" id="generate_ticket_from_bank" value="1" checked/>
                  <label for="generate_ticket_from_bank">
                    Generar ticket
                  </label>
                </div>                
                <div class="form-group">
                    <button type="button" id="ticket_gen_btn" class="btn btn-primary" onclick="setComplete()">Completada</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- logistic layer -->

<!-- ticket layer -->

<div class="fullhd-layer ticket-layer">
    <span class="close is-clickable" onclick="layerClose()">
        <i class="gi gi-remove_2"></i>
    </span>
    <div class="row">
        <div class="col-xs-12">
            <form id="update_logistic">
                <h3>Generar etiqueta para venta <span class="sale_id"></span></h3>
                <div class="form-group">
                    <button type="button" id="ticket_gen_btn" class="btn btn-primary" onclick="getTicket()">Generar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- logistic layer -->

<div class="fullhd-layer logistic-layer">
    <span class="close is-clickable" onclick="layerClose()">
        <i class="gi gi-remove_2"></i>
    </span>
    <div class="row">
        <div class="col-xs-12">
            <form id="update_logistic">
                <h3>Cambiar logística de venta <span class="sale_id"></span></h3>
                <div class="form-group">
                <?php foreach($logistics as $logistic): ?>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="logistic_option" id="logistic_option_<?= $logistic['Logistics']['id'] ?>" value="<?= $logistic['Logistics']['id'] ?>" data-name="<?= $logistic['Logistics']['code'] ?>" data-image="<?= $logistic['Logistics']['image'] ?>">
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

<div class="row hide-print">
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
            Expandir todo
        </button>
        <button class="btn btn-muted" type="button" id="printbtn" style="margin-top: -2px;">
            <i class="fa fa-print fa-lg"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table id="example-datatables2" class="table table-striped table-bordered table-hover print-friendly">
            <thead>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Envío</th>
                    <th class="text-center">Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array) $sales as $sale):

                $personalInfoShowed=false;
                $paybank = @$sale['local_sale']['payment_method']==='bank' && empty(@$sale['local_sale']['completed']);
                if (!count(@$sale['collection']['sale_products'])) {
                    continue;
                }
                ?>
                <tr class="is-clickable<?= $paybank ? ' bg-warning-i' : '' ?>">
                    <td class="col-xs-1" data-sort="<?php echo date('Y-m-d',strtotime($sale['collection']['date_approved'])) ?>">
                        <strong><?php echo date('d/m/Y',strtotime($sale['collection']['date_approved'])) ?></strong><br />
                        <small><?php echo date('H:i:s',strtotime($sale['collection']['date_approved'])) ?></small><br />
                    </td>
                    <td class="col-xs-3">
                        <strong><?php echo @$sale['collection']['cardholder']['name'] ?: @$sale['local_sale']['nombre'] . ' ' . @$sale['local_sale']['apellido'] ?></strong><br>
                        <small><?php echo @$sale['collection']['cardholder']['identification']['type'] ?: @$sale['local_sale']['dni'] ?> <?php echo @$sale['collection']['cardholder']['identification']['number'] ?></small>
                        <div class="toggle-table toggle-table-hidden">
                            <?php
                            foreach ((array) @$sale['collection']['sale_products'] as $reason): ?>
                                <div class="row">
                                <?php $column = 4;  ?>
                                    <?php if (!$personalInfoShowed): ?>
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
                        </div>
                    </td>


                    <td class="col-xs-1 text-center">
                        <strong>$<?= @$sale['collection']['transaction_amount'] ?: @$sale['local_sale']['value'] ?> </strong><br>
                        <small>(<?= count(@$sale['collection']['sale_products']) ?> items)</small>
                    </td>


                    <td class="col-xs-1 text-center"><!--[[<?=@$sale['local_sale']['shipping_type']?>]]-->
                    <?php 
                    $defaultCost = 0; ?>
                    <?php if (isset($sale['local_sale']['cargo']) && $sale['local_sale']['cargo'] === 'takeaway'):?>
                        <strong>Takeaway</strong>
                    <?php else: ?>
                        <strong>$<?= !empty(@$sale['collection']['deliver_cost']) ? $sale['collection']['deliver_cost'] : $defaultCost ?></strong>

                        <?php
                        if (!empty(@$sale['local_sale']['id']) && !empty(@$sale['local_sale']['apellido']) && !empty(@$sale['local_sale']['cargo']) && @$sale['local_sale']['cargo'] == 'shipment'): ?>
                            <!--span class="btn btn-info" onclick="getTicket('<?php echo $sale['local_sale']['id'];?>', this)">TICKET</span-->
                            <?= @$sale['local_sale']['def_mail_sent'] ? '' : '<i class="fa fa-pencil text-success" onclick="editLogistic(event,' . @$sale['local_sale']['id'] . ',' . @$sale['local_sale']['logistic_id'] . ')" title="Notificación pendiente"></i>' ?>
                        <?php endif ?>
                    <?php if (empty(@$sale['local_sale']['def_orden_retiro'])):?>
                        <div id="shipping_title_<?= @$sale['local_sale']['id'] ?>" class="text-info text-center">
                            <img class="shipping-logo" id="shipping_image_<?= @$sale['local_sale']['id'] ?>" src="<?= @$logistics_images[$sale['local_sale']['shipping']] ?>" onclick="showLayer(event,'ticket',<?= @$sale['local_sale']['id'] ?>)">
                            </div>
                            <!-- <?= @strtoupper($sale['local_sale']['shipping']) ?> --> <?= !empty(@$sale['collection']['free_shipping']) ? '<i class="gi gi-gift text-success"' : '' ?>
                        </div>
                    <?php else: ?>
                        <div id="shipping_title_<?= $sale['local_sale']['id'] ?>" class="text-success text-center">
                            <div class="shipping-logo" src="<?= @$logistics_images[$sale['local_sale']['shipping']] ?>">
                            </div>
                            <!-- <?= strtoupper(@$sale['local_sale']['shipping']) ?> --> <?= !empty(@$sale['collection']['free_shipping']) ? '<i class="fa fa-gift text-success"' : '' ?>
                        </div>
                    <?php endif ?>
                    <?php endif ?>                    
                    </td>

                    <td class="col-xs-1">
                        <strong><?php echo @$list_payments[$sale['collection']['payment_type']] ?></strong><br>
                    <?php if(@$sale['local_sale']['payment_method']==='bank'): ?>
                        <?php if($sale['local_sale']['completed']): ?>
                        <strong class="text-success"><?php echo @$list_status[$sale['collection']['status']] ?></strong>
                        <?php else: ?>
                        <strong class="text-info" id="bank_title_<?= $sale['local_sale']['id'] ?>" onclick="showLayer(event,'bank',<?= $sale['local_sale']['id'] ?>)"><?php echo @$list_status[$sale['collection']['status']] ?></strong>
                        <?php endif ?><br>
                        <small><?php echo @$sale['local_sale']['modified'] ?></small>
                    <?php else: ?>
                        <strong class="<?= @$sale['collection']['status'] === 'approved' ? 'text-success' : 'text-info' ?>"><?php echo @$list_status[$sale['collection']['status']] ?></strong><br>
                        <small><?php echo @$sale['collection']['date_approved'] ?></small>
                    <?php endif ?>                        
                        <!--small><?= @$sale['collection']['payment_type'] === 'credit_card' ? @$sale['collection']['last_four_digits'] : @$sale['collection']['merchant_order_id'] ?></small-->
                    </td>


                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>