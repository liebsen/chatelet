
  <section id="optionsHelp" class="desktop animated fadeIn delay">
      <a href="/ayuda/como_comprar">¿Cómo comprar?</a>
      <a href="/ayuda/envios">Envíos</a>
      <a href="/ayuda/metodos_de_pago">Formas de pago</a>
      <a href="/ayuda/politicas_de_cambio">Cambios y devoluciones</a>
      <a href="/ayuda/faq">Preguntas frecuentes</a>
  </section>            
  <section id="optionsHelp" class="mobile">
      <a href="/ayuda/como_comprar" class="active">¿Cómo comprar?</a>
      <a href="/ayuda/envios">Envíos</a>
      <a href="/ayuda/metodos_de_pago">Formas de pago</a>
      <a href="/ayuda/politicas_de_cambio">Cambios y devoluciones</a>
      <a href="/ayuda/faq">Preguntas frecuentes</a>
  </section>
  <script>
    $(function () {
      document.querySelectorAll("#optionsHelp a").forEach((e) => {
        e.classList.remove('active')
      })
      document.querySelectorAll("#optionsHelp a[href='<?php echo $this->request->here() ?>']").forEach((e) => {
        e.classList.add('active')
      })
    })
  </script>     
