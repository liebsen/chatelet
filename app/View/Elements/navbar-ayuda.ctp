
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

  <style type="text/css">

#optionsHelp {     
  padding: 0.75rem 0;
  padding-bottom: 2rem;
  text-align: center; 
  font-weight: 800;
  min-height: 92px;
  overflow-x: auto;
  width: 100%;
}

#optionsHelp.desktop {
  white-space: nowrap;
}

#optionsHelp.mobile {
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
}

#optionsHelp.mobile a {
  font-size: 0.75rem;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: nowrap;
  padding: 0 1rem;
}

#optionsHelp.mobile a.active {
  background-color: #e7e7e7;
  border-color: #e7e7e7;
  transition: background 1s ease-out;
}

#optionsHelp a { 
  /* color: #404040; */
  color: #808080;
  display: inline-block; 
  min-height: 2rem;
  padding: 0 1.5rem;
  font-weight: 300;
  text-transform: uppercase;
  border-bottom: 1px solid #b0b0b0;
  transition: all 100ms linear;
}

#optionsHelp.desktop a.active {
  color: #404040;
  border-color: #404040;
}


@media(min-width: 769px){
  #optionsHelp {
    position: absolute; 
    left:0; 
    right: 0; 
    top: 0;
  }
  #optionsHelp.top-fixed { 
    top: 4rem; 
    z-index: 100;
    background: linear-gradient(hsla(0,0%,100%,0),hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0));
  }
}

@media (max-width: 768px) {
  #optionsHelp {padding: 0;}
  #optionsHelp a { 
    padding: 30px 10px;
    min-height: 92px; 
    width: 100%; 
    background: white;
    border-color: #f8f8f8;
    /* border-bottom: 2px solid #f6f6f5;*/
  }
}


  </style>

  <script type="text/javascript">
    $(function () {
      document.querySelectorAll("#optionsHelp a").forEach((e) => {
        e.classList.remove('active')
      })
      document.querySelectorAll("#optionsHelp a[href='<?php echo $this->request->here() ?>']").forEach((e) => {
        e.classList.add('active')
      })
    })
  </script>
