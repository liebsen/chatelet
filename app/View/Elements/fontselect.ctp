<?php 

if($this->Session->read('font') || isset($_REQUEST['font'])): 

    $selected = $this->Session->read('font') ? : urldecode($_REQUEST['font']);

    $fonts = ['Montserrat','Archivo Narrow','Roboto Condensed','Poppins','Sniglet','Open Sans', 'Lato', 'Oswald', 'Source Sans Pro', 'Raleway', 'PT Sans', 'Merriweather', 'Noto Sans', 'Nunito', 'Concert One', 'Prompt', 'Work Sans', 'Krona One', 'Syne', 'DM Sans', 'Harmond', 'Magilio', 'Harmony', 'Resist Sans', 'Rock Salt', 'Sacramento', 'Reenie Beanie'];
?>
    <div class="font-select">
      <select id="fontselector" onchange="setFont(this.value)">
      <?php foreach($fonts as $f => $font):?>
          <option index="<?= $f ?>" value="<?= $font ?>"<?= $font === $selected ? ' selected' : '' ?>><?= $font ?></option>
      <?php endforeach ?>
      </select>
      <a class="font-link" href="javascript:nextFont()">
        Siguiente
      </a>
      <a class="font-link" href="#">
        Autorefresh
        <input type="checkbox" id="autorefresh" onclick="autorefreshCheck(this.checked)" <?= isset($_REQUEST['autorefresh']) && $_REQUEST['autorefresh'] === 'true' ? ' checked' : '' ?>/>
      </a>
      <a class="font-link" href="?exitfont=1">
        Salir
      </a>
    </div>
    <style>
        .font-select{
          padding: 0.5rem;             
          position: fixed;
          z-index: 999;
          top: 0;
          left: 0;
          right: 0;
        }
        .font-select a {
          margin: 0 0.5rem;
        }
        .font-link {
          color: lightblue;
        }
        .font-link:hover {
          color: blue;
        }
    </style>
    <script>
      function setFont(e) {
        var url = `${window.location.pathname}?font=${encodeURI(e)}&autorefresh=${document.getElementById('autorefresh').checked}`
        window.location = url
      }
      function nextFont(){
        var e = document.getElementById('fontselector')
        var selected = e.options[e.selectedIndex+1].text
        setFont(selected)
      }
      function autorefreshCheck(e){
        if (e) {
            nextFont()
        }
      }
      setTimeout(() => {
        if (document.getElementById('autorefresh').checked) {
            nextFont()
        }
      }, 10000)
    </script>
<?php endif ?>