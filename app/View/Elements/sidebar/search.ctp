<form name="search" action="/shop/buscar">
  <nav class="sidebar sidebar-search  d-flex flex-column justify-content-center align-items-start gap-05">
    <button type="button" class="corner-pin btn-close-sidebar">
      <i class="ico-times" role="img" aria-label="Cerrar"></i>
    </button>
    <div class="sidebar-top">
      <h5>BUSCAR</h5>
      <div class="content pt-4">
        <div class="form-group">
          <input class="form-control textbig search-input" name="q" placeholder="Buscar..." required>
          <p class="animation-fadeIn slow"><span class="text-muted">Busca en todo nuestro catálogo. Ej: malla, blusa, pantalon, saco, etc</span></p>
        </div>
      </div>
    </div>
    <div class="sidebar-bottom">
      <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
        <button class="btn btn-chatelet dark w-100" type="submit">Buscar</button>
      </div>
    </div>
  </nav>
</form>
