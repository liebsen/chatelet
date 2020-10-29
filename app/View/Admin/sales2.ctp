<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-sales', array('inline' => false)); ?>
<div class="row">
    <div class="col-xs-12">
        <a href="/admin/sales_export_mails" target="_blank">
            <button class="btn btn-success" type="button" style="margin-top: -2px;">Exportar Emails</button>
        </a>
        <select onchange="set_sales_date_range('begin_date', this)">
            <?php 
            for ($i = 0; $i < 12; $i++) {
                $date = strtotime($date . ' - ' . $i . ' month');
                ?><option value="<?php echo strtotime($date)?>"><?php echo $date;?></option><?php 
            } ?>
        </select>
        <select onchange="set_sales_date_range('end_date', this)">
            <?php 
            for ($i = 0; $i < 12; ) {
                $date = strtotime($date . ' - ' . $i . ' month');
                ?><option value="<?php echo strtotime($date)?>"><?php echo $date;?></option><?php 
            } ?>
        </select>
    </div>
</div>