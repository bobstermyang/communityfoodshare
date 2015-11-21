<div class="cfs_user_fields">
            <h3>Extra details for Commnunity Food Share</h3>
            <table class="form-table">
                  <tr>
                        <th>
                              <label for="donation_goal">Donataion Goal</label>
                        </th>
                        <td>
                              <input type="text" name="donation_goal" id="donation_goal" class="regular-text" value="<?php echo esc_attr(get_the_author_meta('donation_goal', $user->ID))?>" />$<br />
                              <span class="description">Please add your donation goal amount.</span>
                        </td>
                  </tr>
                  <tr>
                        <th scope="row">
                              Gift Verification
                        </th>
                        <td>
                              <label for="gift_verification">
                              <input type="checkbox" name="gift_verification" id="gift_verification" <?php echo esc_attr(get_the_author_meta('gift_verification', $user->ID)) ? 'checked' : ''?> />
                              Enable gift verification
                              </label>
                        </td>
                  </tr>
                  <tr>
                        <th scope="row">
                              Newsletter
                        </th>
                        <td>
                              <label for="newsletter">
                              <input type="checkbox" name="newsletter" id="newsletter" <?php echo esc_attr(get_the_author_meta('newsletter', $user->ID)) ? 'checked' : ''?> />
                              Enable newsletter
                              </label>
                        </td>
                  </tr>
                  <tr>
                        <th scope="row">
                              Postal Mail
                        </th>
                        <td>
                              <label for="postal_mail">
                              <input type="checkbox" name="postal_mail" id="postal_mail" <?php echo esc_attr(get_the_author_meta('postal_mail', $user->ID)) ? 'checked' : ''?> />
                              Enable postal mail
                              </label>
                        </td>
                  </tr>
            </table>
      </div>
      