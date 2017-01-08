<?php echo $header; 
$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config'); 
include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_top.tpl'); ?>
  <h2><?php echo $heading_title; ?></h2>
  <p><?php echo $text_payment_failed; ?></p>
  <?php include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_bottom.tpl'); ?>
</div>
<?php echo $footer; ?>