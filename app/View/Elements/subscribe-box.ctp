  <div class="wrapper container">
    <span class="corner-pin">
      <i class="ico-times" role="img" aria-label="Cerrar"></i>
    </span>
    <div class="is-flex-center flex-column gap-1">
      <span>
        <h2>Estemos <strong>conectad@s</strong></h2>
        <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </span>
      <span>
      <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
        <div class="is-flex-center gap-05">
          <input class="form-control" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          <input type="submit" class="btn btn-chatelet dark" id="enviar" value="Confirmar">
        </div>
      <?php echo $this->Form->end(); ?>
      </span>
    </div>
  </div>

  <style>
    #suscribe { 
      position: fixed;
      left: 0;
      bottom: 0;
      background: #e6e6e6; 
      color: #333; 
      font-weight: 300; 
      overflow: hidden; 
      padding: 1rem; 
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