<?php echo $header; 
$theme_options = $this->registry->get('theme_options');
$config = $this->registry->get('config'); 
include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_top.tpl'); ?>

<?php if ($returns) { ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <td class="text-right"><?php echo $column_return_id; ?></td>
      <td class="text-left"><?php echo $column_status; ?></td>
      <td class="text-left"><?php echo $column_date_added; ?></td>
      <td class="text-right"><?php echo $column_order_id; ?></td>
      <td class="text-left"><?php echo $column_customer; ?></td>
      <td></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($returns as $return) { ?>
    <tr>
      <td class="text-right">#<?php echo $return['return_id']; ?></td>
      <td class="text-left"><?php echo $return['status']; ?></td>
      <td class="text-left"><?php echo $return['date_added']; ?></td>
      <td class="text-right"><?php echo $return['order_id']; ?></td>
      <td class="text-left"><?php echo $return['name']; ?></td>
      <td><a href="<?php echo $return['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="button"><i class="fa fa-eye"></i></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_empty; ?></p>
<?php } ?>
<div class="buttons clearfix">
  <div class="pull-right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
</div>
  
<?php include('catalog/view/theme/'.$config->get('config_template').'/template/themeglobal/themeglobal_bottom.tpl'); ?>
<?php echo $footer; ?>