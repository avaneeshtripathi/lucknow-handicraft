<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>

<div class="clearfix">
  <?php foreach ($payment_methods as $payment_method) { ?>
  <div class="customRadio">
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" id="<?php echo $payment_method['code']; ?>" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
    <div class="check"></div>
    <?php } else { ?>
    <input type="radio" id="<?php echo $payment_method['code']; ?>" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
    <div class="check"></div>
    <?php } ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </div>
  <?php } ?>
  <?php } ?>
</div>

<p class="hide"><strong><?php echo $text_comments; ?></strong></p>
<p class="hide">
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right"><?php echo $text_agree; ?>
    <div class="customCheckbox">
      <?php if ($agree) { ?>
        <input type="checkbox" id="acceptTermsOfService" name="agree" value="1" checked="checked" />
        <label for="acceptTermsOfService"></label>
      <?php } else { ?>
      <input type="checkbox" id="acceptTermsOfService" name="agree" value="1" />
      <label for="acceptTermsOfService"></label>
      <?php } ?>
    </div>
    &nbsp;
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="button" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="button" />
  </div>
</div>
<?php } ?>
