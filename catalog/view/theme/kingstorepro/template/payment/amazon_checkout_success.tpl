<?php echo $header; 
$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config'); 
include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_top.tpl'); ?>
  <div style="text-align:center;">
    <h2><?php echo $text_success_title; ?></h2>
    <p><?php echo $text_payment_success; ?></p>
    <div style="margin: 0 auto; width: 392px;" id="AmazonOrderDetail"></div>
  </div>
  <?php include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_bottom.tpl'); ?>
</div>
<script type="text/javascript"><!--
  new CBA.Widgets.OrderDetailsWidget ({
    merchantId: "<?php echo $merchant_id; ?>",
    orderID: "<?php echo $amazon_order_id; ?>"
  }).render ("AmazonOrderDetail");
//--></script>
<?php echo $footer; ?>