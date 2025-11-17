<script type="text/javascript">
const settings = <?php echo json_encode($settings, JSON_PRETTY_PRINT);?>;
let freeShipping = <?php echo (int)@$freeShipping?>;
let cart_totals = <?php echo json_encode($cart_totals, JSON_PRETTY_PRINT);?>;
let cart_items = <?php echo json_encode($cart, JSON_PRETTY_PRINT);?>;
</script>
