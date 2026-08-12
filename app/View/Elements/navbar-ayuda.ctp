
  <section id="optionsHelp" class="desktop animation-fadeIn animation-both delay">
      <a href="/ayuda/como_comprar">¿Cómo comprar?</a>
      <a href="/ayuda/envios">Envíos</a>
      <a href="/ayuda/metodos_de_pago">Formas de pago</a>
      <a href="/ayuda/politicas_de_cambio">Devolución de compra</a>
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
    width: 100%;  
    background-color: papayawhip;
  }

  #optionsHelp.mobile a {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: nowrap;
    border:none;
    padding: 1rem;
    margin: 0;
    color: peru;
  }

  #optionsHelp > a { 
    display: inline-block; 
    padding: 0.35rem 0.75rem;
    font-weight: 300;
    text-transform: uppercase;
    transition: all 1s ease-in-out;
  }

  #optionsHelp > a.active {
	  border-bottom: 4px solid hotpink;
	  border-radius: 10px;
	  font-weight: 700;
	  color: hotpink;    
  }
  #optionsHelp.mobile > a.active {
    position: relative;
    transition: background 1s ease-out;
    border-bottom: 2px solid coral;
    background-color: peachpuff;
    color: peru;    
  }

  @media(min-width: 992px){
    #optionsHelp {
      position: absolute; 
      left:0; 
      right: 0; 
      top: 8rem;
      padding: 1.5rem;
      z-index: 9;
    }
    #optionsHelp.top-fixed { 
      top: 4rem; 
      z-index: 100;
      background: linear-gradient(hsla(0,0%,100%,0),hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0.9) 50%, hsla(0,0%,100%,0));
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
