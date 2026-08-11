<style type="text/css">
	.filter-sales {
		padding: 1rem 1.5rem;
		background-color: whitesmoke;
		border-radius: 1rem;
	}
</style>
  <form class="filter-box filter-item filter-sales mb-4">
  	<h4><i class="gi gi-filter"></i> Filtro por periodo</h4>
    <p>Establece un rango de fechas para filtrar</p>
    <div class="control-group">
      <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
      <div class="controls d-flex flex-center gap-05">
        <input type="text" name="date_min" data-format="yyyy-mm-dd" class="form-control advanced-filter datepicker" placeholder="Fecha mínima" value="<?=$query['date_min']??$date_min?>"  autocomplete="off" />
        <input type="text" name="date_max" data-format="yyyy-mm-dd" class="form-control advanced-filter datepicker" placeholder="Fecha máxima" value="<?=$query['date_max']??$date_max?>"  autocomplete="off" />
      </div>
    </div>
    <div class="controls-group">
      <label class="control-label min-date-text" for="minSale">...</label>
      <!--span class="text-success">$ 
      	<span class="sale_min-value"><?=$query['sale_min']??'50000'?></span>
      </span>
      <input type="range" class="advanced-filter" name="sale_min" step="10000" min="10000" max="1000000" value="<?=$query['sale_min']??'50000'?>"-->
    </div>
  </form>