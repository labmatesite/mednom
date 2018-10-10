<?php
include_once 'lib/dbfunctionjugal.php';
$orgid=$_REQUEST['orgid'];
$qid = get_contactbyorgid($orgid)
?>
 <label for="textfield" class="control-label">Contacts</label>
                                                            <div class="controls">
                                                 <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="showcontdata(this.value)" >
                                              <option value="">-- Select Contacts --</option>     
                                                <option value="-1">-- Add New --</option>
                                                                                         <?php

foreach($qid as $values)
{
?>
 <option value="<?php echo $values['cont_id'] ?>">-- <?php echo $values['cont_firstname']." ".$values['cont_lastname'] ?> --</option>
<?php
}
	
												/* $sql_sec3="select * from quote_contacts where cont_orgid='$orgid' order by cont_firstname,cont_lastname";
												 $res_sec3=mysql_query($sql_sec3);
												 while($row_sec3=mysql_fetch_array($res_sec3))
												  {
												?>
                                                     <?php
													echo "<option value='".$row_sec3['cont_id']."'>".ucwords($row_sec3['cont_firstname']." ".$row_sec3['cont_lastname'])."</option>";
												  }*/
												  ?>
                                            </select> 
                                            </div>