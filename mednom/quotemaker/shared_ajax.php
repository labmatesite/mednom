<?php
include 'lib/database.php';
include 'lib/function.php';

if (isset($_REQUEST['orgid'])) {
    $orgid = $_REQUEST['orgid'];
    ?>
    <label for="textfield" class="control-label">Contacts</label>
    <div class="controls">
        <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" >
            <option value="">-- Select Contacts --</option>
            <?php
            $where = array('cont_orgid' => $orgid);
            $res_sec3 = selectAndOrderby('quote_contacts', $where, 'cont_firstname,cont_lastname');

            foreach ($res_sec3 as $row_sec3) {
                ?>
                <?php
                echo "<option value='" . $row_sec3['cont_id'] . "'>" . ucwords($row_sec3['cont_firstname'] . " " . $row_sec3['cont_lastname']) . "</option>";
            }
            ?>
        </select> 
    </div>
    <?php
}

if (isset($_REQUEST['contid'])) {
    $contid = $_REQUEST['contid'];
    ?>
    <label for="textfield" class="control-label">Organisation</label>
    <div class="controls">
        <select id="qt_organisationid" data-rule-required="true" name="qt_organisationid" class="select2-me input-xlarge" data-placeholder="Organisation Name" onChange="Organisation(this.value);">>
            <option value="">-- Select Organisation --</option>
            <?php
               $res_sec3 = select_table_orderby('quote_organisation', 'org_name');
                foreach($res_sec3 as $row_sec3){
                ?>
                <option <?php if ($contid == $row_sec3['org_id']) { ?> selected="selected" <?php } ?> value=<?php echo $row_sec3['org_id'] ?>><?php echo ucwords($row_sec3['org_name']) ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
}
?>