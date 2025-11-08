
  <div class="wrapper container is-flex-end animated fadeIn slow delay5">
    <div class="col-md-6">
      <h2 class="h2 mt-0 mb-4">Estemos <strong>conectad@s</strong></h2>
      <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
    </div>
    <div class="col-md-6">
      <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
        <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
        <input type="submit" id="enviar" value="ok">
      <?php echo $this->Form->end(); ?>
    </div>
  </div>

  <style>
    #suscribe { 
      position: fixed;
      left: 0;
      bottom: 0;
      background: #e6e6e6; 
      color: #333; 
      font-size: 0.75rem;
      font-weight: 400; 
      overflow: hidden; 
      padding: 2.5rem 0; 
    }
  #suscribe .col-md-6:last-child:before { display: none; }

    #suscribe .col-md-6:first-child { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    #suscribe .h3 { margin-top: 0; }
    #suscribe strong { font-weight: 900; }
    #suscribe form input[type="email"] { min-width: 14rem; margin: 0; }

/* #suscribe .col-md-6:last-child:before { background: url(../images/sprite.png) no-repeat -82px -171px; content: ""; display: block; float: left; height: 47px; margin-right: 20px; width: 62px; } */

/*#suscribe form {  overflow: hidden; display: flex;
justify-content: space-between;
opacity: 0.7;
transition: all 0.2s ease-out;}
#suscribe form:hover {
  opacity: 1;
}
#suscribe form:after { 
  position: absolute;
  top: calc(100% - 0.1rem);
  background: #cdc8c8;
  content: "";
  display: block;
  height: 4px;
  width: 100%;
  border-radius: 4px;
}

#suscribe form input { background: transparent; border: none; color: rgb(51, 51, 51); font-weight: 400;}
#suscribe form input:placeholder { color: rgb(70, 70, 70); }
#suscribe form input[type="submit"] { color: black; font-weight: 600; padding: 1rem; font-weight: 800;}*/    
</style>