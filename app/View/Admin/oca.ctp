<?php echo $this->Html->css('oca',array( 'inline' => false )) ?>
<div class="row">
	<div class="col-xs-12">
		<!-- Default Table -->
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Cantidad Min.</th>
                    <th class="text-center">Cantidad Max.</th>
                    <th class="text-center">Peso (g)</th>
                    <th class="text-center">Alto (cm)</th>
                    <th class="text-center">Ancho (cm)</th>
                    <th class="text-center">Largo (cm)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $key => $package): ?>
                <tr>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['amount_min'] ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['amount_max'] ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['weight'].'g.' ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['height'].'cm.' ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['width'].'cm.' ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<?php echo $package['Package']['depth'].'cm.' ?>
                	</td>
                	<td class="text-center col-xs-1">
                		<button class="btn btn-danger" onClick="window.location.href='<?php echo $this->Html->url(array('action' => 'delete_package',$package['Package']['id'] )) ?>'">X</button>
                	</td>
                </tr>
                <?php endforeach ?>
                <tr class="package success">
                	<form action="" method="POST">
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="amount_min" required placeholder="Cantidad Minima" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="amount_max" required placeholder="Cantidad Maxima" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="weight" required placeholder="Peso" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="height" required placeholder="Alto" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="width" required placeholder="Ancho" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="number" name="depth" required placeholder="Largo" />
	                	</td>
	                	<td class="text-center col-xs-1">
	                		<input type="hidden" name="id" value="" required />
	                		<button class="btn btn-success btn-sm">Agregar</button>
	                	</td>
	                </form>
                </tr>
            </tbody>
        </table>
        <!-- END Default Table -->
	</div>
</div>