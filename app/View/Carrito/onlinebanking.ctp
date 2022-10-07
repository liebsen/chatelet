   <div id="headhelp">
          <div class="wrapper">
              <div class="row">
                  <div class="col-md-6">
                      <h1>Transferencia<br>bancaria</h1>
                  </div>
                  <pre>
                    <?php 
                    var_dump($data);
                    die();

                    ?>
                  <div class="col-md-6">
                      <div class="box">
                          <h3><?= $data['onlinebanking_explain_title'] ?></h3>
                          <div class="pre" style="white-space: pre"><?= $data['onlinebanking_explain_text'] ?></div>
                          <br><br>
                          <h3 class="mt-4"><?= $data['onlinebanking_instructions_title'] ?></h3>
                          <div class="pre" style="white-space: pre"><?= $data['onlinebanking_instructions_text'] ?></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
