<h2>Add New Donator</h2>
<div class="wrap">
  <?php if(isset($_POST['btnCFSDonator'])){
        $objDonator = new tblDonator();
        $result = $objDonator->insert($_POST['cfs_donator']);
        $message = '';
        if($result){
          $message = 'Add new donator successfully. <a href="admin.php?page=cfs_donator">view all donators</a></a>';  
        }else{
          $message = 'There is some error. Please try it again!';
        }
        echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div><br />';
  } ?>
  <div class="postbox " style="padding: 10px">
      <div class="misc-pub-section ">
      <form action="" method="post">
          <table class="form-table">
                <tr>
                      <th><label for="cfs_donator[transaction_id]">Transaction ID</label></th>
                      <td><input name="cfs_donator[transaction_id]" id="cfs_donator[transaction_id]" value="" /></td>
                </tr>
                <tr>
                      <th><label for="cfs_donator[payment_type]">Payment Method</label></th>
                      <td>
                            <select name="cfs_donator[payment_type]" id="cfs_donator[payment_type]">
                                  <option value="cash">Cash</option>
                                  <option value="check">Check</option>
                            </select>
                      </td>
                </tr>
                <tr>
                      <th><label for="cfs_donator[donar_name]">Payer Name</label></th>
                      <td><input name="cfs_donator[donar_name]" id="cfs_donator[donar_name]" value="" /></td>
                </tr>
                <tr>
                      <th><label for="cfs_donator[user_role]">Payer Role</label></th>
                      <td>
                      <select name="cfs_donator[user_role]" id="cfs_donator[user_role]">
                                  <option value="business">Business</option>
                                  <option value="team">Team</option>
                                  <option value="individual">Individual</option>
                            </select>
                      </td>
                </tr>
                <tr>
                      <th><label for="cfs_donator[amount]">Amount</label></th>
                      <td><input name="cfs_donator[amount]" id="cfs_donator[amount]" value="" />$</td>
                </tr>
                <tr>
                      <th><label for="cfs_donator[show_amount]">Hide Amount?	</label></th>
                      <td><input type="checkbox" value="1" name="cfs_donator[show_amount]" id="cfs_donator[show_amount]"/></td>
                </tr>
          </table>
          <input type="submit" name="btnCFSDonator" class="button button-primary button-large" value="Save Donator" />
      </form>
  </div>
      </div>
  </div>
  