<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include 'lib/header.php';

$id = $_REQUEST['id'];

?>

<script type="text/javascript">
    function loadingImg() {
        jquery("#loadingImg").show();
    }
</script>

<script src="tinymce/tinymce.min.js" type="text/javascript"></script>

<script>
    tinymce.init({


        selector: "textarea#elm1,textarea#elm2",
        theme: "modern",
        width: "100%",
        height: 300,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
    });
</script>


<script language="javascript">
    function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp = false;
        try {
            xmlhttp = new XMLHttpRequest();
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e1) {
                    xmlhttp = false;
                }
            }
        }

        return xmlhttp;
    }


    //This code is used For selection of State Using Ajax
    function selectCat(id) {
        if (id != 0) {
            document.getElementById("cat_type").disabled = false;

            if (window.XMLHttpRequest) {
                //// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                //code for IE5, IE6
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("cat_type").innerHTML = "";
                    document.getElementById("cat_type").innerHTML += xmlhttp.responseText;
                    document.getElementById("sub_cat_type").value = "0";
                    document.getElementById("sub_cat_type").disabled = true;

                }
            }
            xmlhttp.open("GET", "selectCategory.php?id=" + id + "&location=cat_type", true);
            xmlhttp.send();
        }
        else {
            document.getElementById("cat_type").disabled = true;
            document.getElementById("sub_cat_type").disabled = true;
        }
    }


    /**    //This code is used For selection of city Using Ajax    */
    function selectSubCat(id) {
        var sec = document.getElementById("sec_name").value;
        if (id != 0) {
            document.getElementById("sub_cat_type").disabled = false;
            if (window.XMLHttpRequest) {
                //// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                //code for IE5, IE6
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("sub_cat_type").innerHTML = "";
                    document.getElementById("sub_cat_type").innerHTML += xmlhttp.responseText;
                }
            }

            xmlhttp.open("GET", "selectCategory.php?id=" + id + "&sec=" + sec + "&location=sub_cat_type", true);
            xmlhttp.send();
        }
        else {
            document.getElementById("sub_cat_type").disabled = true;
        }
    }


</script>

<div class="container-fluid" id="content">

    <div id="main">
        <?php
        date_default_timezone_set("Asia/Calcutta");
        $dt = date('F d, Y');
        $week = date('l');
        ?>
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Admin Rights</h1>
                </div>
                <div class="pull-right">
                    <ul class="stats">
                        <li class='lightred'>
                            <i class="icon-calendar"></i>
                            <div class="details">
                                <span class="big"><?php echo $dt; ?></span>
                                <span><?php echo $week; ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Admin Rights</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Edit Admin</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>

            <!-- Main content start -->
            <?php
            //$sql_a1="select * from admin where id='$id'";
            //$res_a1=mysql_query($sql_a1);
            $row_a1 = find_admin_usersbyuserid($id);
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3><i class="icon-th-list"></i>Edit Admin</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form action="editadminaction.php?id=<?php echo $id ?>" enctype="multipart/form-data"
                                  method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                                <div class="control-group">
                                    <label for="textfield" class="control-label">Rights</label>
                                    <div class="controls">
                                        <select name="rights" id="rights" data-rule-required="true">
                                            <option value="">-- Select Rights --</option>
                                            <option <?php if ($row_a1['userType'] == "Superadmin") { ?> selected <?php } ?>
                                                value="Superadmin">Superadmin
                                            </option>
                                            <option <?php if ($row_a1['userType'] == "admin") { ?> selected <?php } ?>
                                                value="admin">Admin
                                            </option>
                                            <option <?php if ($row_a1['userType'] == "users") { ?> selected <?php } ?>
                                                value="users">Users
                                            </option>
                                            <option <?php if ($row_a1['userType'] == "logistics") { ?> selected <?php } ?>
                                                value="logistics">Logistics
                                            </option>
                                        </select>
                                    </div>
                                </div>    <!-- Section Type -->

                                <div class="control-group">
                                    <label for="full_name" class="control-label">Full Name <span
                                            style="color:#FF0000">*</span>
                                    </label>
                                    <div class="controls">
                                        <input type="text" name="full_name" id="full_name" placeholder="Full Name"
                                               value="<?php echo $row_a1['full_name'] ?>"
                                               class="input-xlarge" data-rule-required="true" data-rule-minlength="3">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label for="textfield" class="control-label">Username <span
                                            style="color:#FF0000">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="username" id="username" placeholder="Username"
                                               class="input-xlarge" readonly data-rule-required="true"
                                               value="<?php echo $row_a1['username']; ?>" data-rule-minlength="3">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="textarea" class="control-label">Password <span
                                            style="color:#FF0000">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="password" id="password" placeholder="Password"
                                               class="input-xlarge" data-rule-required="true"
                                               value="<?php echo $row_a1['password']; ?>" data-rule-minlength="5">

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="textfield">Email Address </label>
                                    <div class="controls">
                                        <input type="text" data-rule-email="true" class="input-xlarge"
                                               placeholder="Email Address" value="<?php echo $row_a1['emailid']; ?>"
                                               id="emailid" name="emailid">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="textarea" class="control-label">Email Password </label>
                                    <div class="controls">
                                        <input type="password" name="epassword" id="epassword" placeholder="Password"
                                               class="input-xlarge" data-rule-minlength="5"
                                               value="<?php echo $row_a1['emailpwd']; ?>">

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label for="textarea" class="control-label">Terms &amp; Conditions</label>
                                    <div class="controls">
                                        <textarea name="tnc" id="elm1" rows="5"
                                                  class="input-block-level"><?php echo $row_a1['tnc']; ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label for="textfield" class="control-label">Currency<span
                                            style="color:#FF0000">*</span></label>
                                    <div class="controls">
                                        <select id="qt_cur" name="qt_cur">
                                            <option <?php if ($row_a1['currency'] == " ") { ?> selected <?php } ?>
                                                value="">Select Type
                                            </option>
                                            <option <?php if ($row_a1['currency'] == "inr") { ?> selected <?php } ?>
                                                value="inr" selected>India, Rupees (₹)
                                            </option>
                                            <option <?php if ($row_a1['currency'] == "dollar") { ?> selected <?php } ?>
                                                value="dollar">USA, Dollar ($)
                                            </option>
                                            <option <?php if ($row_a1['currency'] == "pounds") { ?> selected <?php } ?>
                                                value="pounds">UK, Pounds (£)
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php
                                    $tabs = show_table_column();
                                    //var_dump($tabs);
                                    ?>
                                    <label for="textfield" class="control-label">Select Price List<span
                                            style="color:#FF0000">*</span></label>
                                    <div class="controls">

                                        <select id="qt_price" name="qt_price" class="select2-me input-xsmall" required>
                                            <?php

                                            foreach ($tabs as $key => $value) {

                                                ?>
                                                <option
                                                    value="<?php echo $value['Field']; ?>" <?php if ($value['Field'] == $row_a1['price']) {
                                                    echo "selected";
                                                } ?>><?php echo $value['Field']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="textfield">Host </label>
                                    <div class="controls">
                                        <input type="text" class="input-xlarge" placeholder="Host" id="host" name="host"
                                               value="<?php echo $row_a1['host']; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="textfield">Port </label>
                                    <div class="controls">
                                        <input type="text" data-rule-maxlength="2" data-rule-minlength="2"
                                               class="input-xlarge" placeholder="Port" id="portno" name="portno"
                                               value="<?php echo $row_a1['port']; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="textfield">Ip Address </label>
                                    <div class="controls">
                                        <input type="text" class="input-xlarge" placeholder="IP Address"
                                               id="a_ipaddress" name="a_ipaddress"
                                               value="<?php echo $row_a1['a_ipaddress'] ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="textfield" class="control-label">Outside Access <span
                                            style="color:#FF0000">*</span></label>
                                    <div class="controls">
                                        <select name="outside" id="outside" data-rule-required="true">
                                            <option value="">-- Select Outside Access --</option>
                                            <option <?php if ($row_a1['outside'] == "yes") { ?> selected <?php } ?>
                                                value="yes">Yes
                                            </option>
                                            <option <?php if ($row_a1['outside'] == "no") { ?> selected <?php } ?>
                                                value="no">No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn" onclick="window.history.back()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content end -->


        </div>
    </div>
</div>
<?php
echo $row_a1['userType'];
?>
</body>


</html>

