
  <section id="optionsHelp" class="desktop animation-fadeIn animation-both delay">
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
    text-align: center; 
    font-weight: 800;
    overflow-x: auto;
    width: 100%;
  }

  #optionsHelp.desktop {
    white-space: nowrap;
  }

  #optionsHelp.mobile {
    background-color: #e7e7e7;
    width: 100%;  
  }

  #optionsHelp.mobile a {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: nowrap;
    border:none;
    padding: 1rem;
    margin: 0;
  }

  #optionsHelp > a { 
    font-size: 0.9rem;
    color: #888;
    border-bottom: 2px solid #c5c5c5;
    background-color: #ffffff;
    display: inline-block; 
    margin: 0 0.5rem;
    font-weight: 300;
    text-transform: uppercase;
    transition: all 1s ease-in-out;
  }

  #optionsHelp > a.active {
    color: #404040;
    border-color: #363636;
  }
  #optionsHelp.mobile > a.active {
    position: relative;
    background-color: white;
    transition: background 1s ease-out;
  }

  #optionsHelp.mobile > a.active:before {
    content: "\f0a4";
    position: absolute;
    font-family: 'FontAwesome';
    top: 0.5rem;
    left: 1rem;
    font-size: 1.5rem;
  }

  @media(min-width: 992px){
    #optionsHelp {
      position: absolute; 
      left:0; 
      right: 0; 
      top: 0;
      padding: 1rem;
    }
    #optionsHelp.top-fixed { 
      top: 4rem; 
      z-index: 100;
      background: linear-gradient(hsla(0,0%,100%,0),hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0));
    }
    #optionsHelp > a { 
      padding: 0.5rem 0.75rem;
      border-radius: 0.5rem;
      background-color: rgba(255,255,255,0.5);
      box-shadow: inset 0 8px 8px #ffffff;
    }
    #optionsHelp > a:hover { 
      text-decoration: none;
      color: #363636;
      border-bottom: 2px solid #363636;
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
