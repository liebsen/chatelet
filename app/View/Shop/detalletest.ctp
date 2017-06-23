
 <section id="detalle"> 
            <div class="wrapper">
                 <div class="col-md-4">
                             
                            <div class="caract">
                            
                           
                           
                                <?php if($loggedIn){ ?>
                                    <a href="#" id="agregar-carro" class="add" disabled>Agregar a mi carro</a>
                                <?php }else{ echo $this->Form->end(); ?>
                                    
                                    <a href="#" id="register-agregar-carro" class="add" disabled>Agregar a mi carro</a>
                                <?php   }  ?>
                           </div> 
                        </div>
                    
                    </div>
                </div>
            </div>
        </section>
<!--