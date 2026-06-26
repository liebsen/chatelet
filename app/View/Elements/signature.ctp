<div class="d-flex justify-content-center align-items-center  footer-signature text-center gap-05 w-100">
  <span class="text-sm text-muted is-clickable" title="Châtelet v<?=@$version['text'] ?>">
    Châtelet &copy; <?php echo date('Y'); ?> Todos los derechos reservados. <br>
    <a href="/shop/terminos">Términos y condiciones</a>
    <a href="/shop/politica">Política de privacidad</a>  
    <a href="/ayuda/como_comprar">Ayuda</a>
  </span>
</div>

<style>

  footer .footer-signature {
    padding: 1.25rem;
    padding-bottom: 4rem;
  }
  footer .footer-signature a:not(:last-child)::after {
    content: " \00B7 "; /* Unicode bullet */
    margin: 0 3px;
  }

</style>
