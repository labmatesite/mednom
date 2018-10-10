<?php
include('../connection2.php');
$contid=$_REQUEST['contid'];
?>
 <label for="textfield" class="control-label">Organisation</label>
                                                            <div class="controls">
                                                 <select id="qt_organisationid" data-rule-required="true" name="qt_organisationid" class="select2-me input-xlarge" data-placeholder="Organisation Name" onChange="Organisation(this.value);">>
                                              <option value="">-- Select Organisation --</option>
                                                 <?php
												 $sql_sec3="select * from quote_organisation order by org_name";
												 $res_sec3=mysql_query($sql_sec3);
												 while($row_sec3=mysql_fetch_array($res_sec3))
												  {
												?>
                                                    <option <?php if($contid==$row_sec3['org_id']){ ?> selected="selected" <?php }?> value=<?php echo $row_sec3['org_id'] ?>><?php echo ucwords($row_sec3['org_name']) ?></option>
												  <?php
												  }
												  ?>
                                             </select>
                                                 
                                                 
                                                 </div>