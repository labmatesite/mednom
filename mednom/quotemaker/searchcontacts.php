<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'lib/database.php';
include 'lib/function.php';
if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
    $email = $_REQUEST['email'];

    $where = array('cont_primaryemail' => $email, 'cont_secondaryemail' => $email);
    $total = selectOr('quote_contacts', $where);
    if ($total == 0) {
        ?>			
        <span style="color:#063">Available</span>			
        <?php
    } else {
        ?>
        <span> Not Avaliable</span>
        <?php
    }
}
if (isset($_REQUEST['orgid'])) {
    $orgid = $_REQUEST['orgid'];
    $where = array('org_id' => $orgid);
    $row_org = selectAnd('quote_organisation', $where);
    ?>
    <div class = "control-group divhalf">
        <label for = "textfield" class = "control-label">Mailing Address</label>
        <div class = "controls">
            <textarea id = "cont_mailingadd" name = "cont_mailingadd"><?php echo $row_org['org_billingadd'];
    ?></textarea>
            <a href="javascript: void(0);" onClick="copyotheraddress();" >Copy Other Address</a>
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other Address</label>
        <div class="controls">
            <textarea id="cont_otheradd" name="cont_otheradd"><?php echo $row_org['org_shippingadd']; ?></textarea>
            <a href="javascript: void(0);" onClick="copymailingaddress();">Copy Mailing Address</a>
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Mailing PO Box</label>
        <div class="controls">
            <input type="text" name="cont_mailingpob" id="cont_mailingpob" value="<?php echo $row_org['org_billingpob']; ?>" placeholder="Mailing PO Box" class="input-xlarge" >
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other PO Box</label>
        <div class="controls">
            <input type="text" name="cont_otherpob" id="cont_otherpob" value="<?php echo $row_org['org_shippingpob']; ?>" placeholder="Other PO Box" class="input-xlarge" >

        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Mailing City</label>
        <div class="controls">
            <input type="text" name="cont_mailingcity" id="cont_mailingcity" value="<?php echo $row_org['org_billingcity']; ?>" placeholder="Mailing City" class="input-xlarge" > 
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other City</label>
        <div class="controls">
            <input type="text" name="cont_othercity" id="cont_othercity" value="<?php echo $row_org['org_shippingcity']; ?>" placeholder="Other City" class="input-xlarge" >
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Mailing State</label>
        <div class="controls">
            <input type="text" name="cont_mailingstate" id="cont_mailingstate" value="<?php echo $row_org['org_billingstate']; ?>" placeholder="Mailing State" class="input-xlarge" >  
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other State	
        </label>
        <div class="controls">
            <input type="text" name="cont_otherstate" id="cont_otherstate" value="<?php echo $row_org['org_shippingstate']; ?>" placeholder="Other  State" class="input-xlarge" >  
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Mailing Postal Code</label>
        <div class="controls">
            <input type="text"   id="cont_mailingpoc" name="cont_mailingpoc" value="<?php echo $row_org['org_billingpoc']; ?>" 	 placeholder="Only numbers"> 
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other Postal Code</label>
        <div class="controls">
            <input type="text"   id="cont_otherpoc" name="cont_otherpoc" value="<?php echo $row_org['org_shippingpoc']; ?>" placeholder="Only numbers"> 
        </div>
    </div>
    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Mailing Country</label>
        <div class="controls">
            <input type="text" name="cont_mailingcountry" id="cont_mailingcountry" value="<?php echo $row_org['org_billingcountry']; ?>" placeholder="Mailing Country" class="input-xlarge" >  	
        </div>
    </div>

    <div class="control-group divhalf">
        <label for="textfield" class="control-label">Other Country</label>
        <div class="controls">
            <input type="text" name="cont_othercountry" id="cont_othercountry" value="<?php echo $row_org['org_shippingcountry']; ?>" placeholder="Other Country" class="input-xlarge" >   
        </div>
    </div>

<?php
}
