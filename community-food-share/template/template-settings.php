
  <h2>Community Foor Share</h2>
  <?php if(isset($_POST['btnCFSettings'])){ ?>
      <div id="message" class="updated below-h2"><p>Setting updated.</p></div><br />
  <?php } ?>
<div class="wrap">
  <div class="postbox " style="padding: 10px">
      <div class="misc-pub-section ">
      <form action="" method="post">
            <fieldset>
                  <h3>Braintree Payment Details:</h3>
                  <table class="form-table">
                        <tr>
                              <th><label for="cfs_settings[braintree_environment]">Braintree Merchant Id</label></th>
                              <td>
                                    <select name="cfs_settings[braintree_environment]" id="cfs_settings[braintree_environment]">
                                          <option <?php echo ($braintree_environment == 'sandbox' ? 'selected' : '')?> value="sandbox">Sandbox</option>
                                          <option <?php echo ($braintree_environment == 'live' ? 'selected' : '')?> value="live">Live</option>
                                    </select>
                              </td>
                        </tr>
                        <tr>
                              <th><label for="cfs_settings[braintree_merchant_id]">Braintree Merchant Id</label></th>
                              <td><input name="cfs_settings[braintree_merchant_id]" id="cfs_settings[braintree_merchant_id]" value="<?php echo $braintree_merchant_id;?>" /></td>
                        </tr>
                        <tr>
                              <th><label for="cfs_settings[braintree_private_key]">Braintree Private Key</label></th>
                              <td><input name="cfs_settings[braintree_private_key]" id="cfs_settings[braintree_private_key]" value="<?php echo $braintree_private_key;?>" /></td>
                        </tr>
                        <tr>
                              <th><label for="cfs_settings[braintree_public_key]">Braintree Public Key</label></th>
                              <td><input name="cfs_settings[braintree_public_key]" id="cfs_settings[braintree_public_key]" value="<?php echo $braintree_public_key;?>" /></td>
                        </tr>
                  </table>
            </fieldset>
            <input type="submit" name="btnCFSettings" class="button button-primary button-large" value="Save Settings" />
      </form>
  </div>
      </div>
  </div>
  