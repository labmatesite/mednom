<?php
if($_SESSION['user_type'] == "Superadmin") {
    ?>
    <ul class='main-nav'><li>
            <a href="home.php">
                <i class="icon-home"></i>
                <!--<span><img src="images/ISlogo.jpg"  /></span>-->
                <span><img src="../images/admin/laboconlogo.jpg"  /></span>
            </a>
        </li><li><a href="organisation.php" >
                <i class="icon-edit"></i>
                <span>Organisation</span>  </a>   </li>
        <li><a href="contacts.php" >
                <i class="icon-edit"></i>
                <span>Contacts</span> </a> </li>
        <li>
            <a href="view_quote.php">
                <i class="icon-edit"></i>
                <span>Quote</span>  </a>
        </li>
        <li>
            <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                <i class="icon-edit"></i>
                <span>Logistics</span>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="view_logistics.php">Logistics</a>
                </li> <li>
                    <a href="view_shipper.php">Shipper</a> 
                </li>
                <li>
                    <a href="view_pod.php">POD</a> 
                </li>
                <li>
                    <a href="view_clearagents.php">Clearing Agent</a> 
                </li>
                <li>
                    <a href="view_forwarder.php">Forwarder</a>
                </li>
            </ul>
        </li>
        <li><a href="view_admin.php">
                <i class="icon-edit"></i>
                <span>AdminRights</span>
            </a>
        </li>
        <li>
            <a href="changepswd.php">
                <i class="icon-edit"></i>
                <span>Change Password</span>
            </a>
        </li> <li>
            <a href="view_shared.php">
                <i class="icon-edit"></i>
                <span>Share</span>
            </a>
        </li>    
        <li><a href="report.php">
                <i class="icon-edit"></i>
                <span>Report</span>
            </a>   
        </li>
        <li>
            <a href="/pricemaster/admin">
                <i class="icon-edit"></i>
                <span>Pricemaster</span>
            </a>   
        </li></ul>
<?php
} elseif ($_SESSION['user_type'] == "users") {
    ?>
    <ul class='main-nav'>
        <li>
            <a href="home.php">
                <i class="icon-home"></i>
                <span><img src="images/ISlogo.jpg"  /></span>
                <span><img src="images/laboconlogo.jpg"  /></span>
            </a>
        </li>
        <li>
            <a href="organisation.php" >
                <i class="icon-edit"></i>
                <span>Organisation</span>
 </a> </li>
        <li>
            <a href="contacts.php" >
                <i class="icon-edit"></i>
                <span>Contacts</span></a>
</li>
        <li>
            <a href="view_quote.php">
                <i class="icon-edit"></i>
                <span>Quote</span>   </a>
        </li>
        <li>
            <a href="view_shared.php">
                <i class="icon-edit"></i>
                <span>Share</span>
            </a>
        </li>
        <li>
            <a href="changepswd.php">
                <i class="icon-edit"></i>
                <span>Change Password</span>
            </a>
        </li>
    </ul>  
    <?php
} elseif ($_SESSION['user_type'] == "admin") {
    ?>
    <ul class='main-nav'>
        <li>
            <a href="home.php">
                <i class="icon-home"></i>
                <span><img src="images/ISlogo.jpg"  /></span>
                <span><img src="images/laboconlogo.jpg"  /></span>
            </a>
        </li>
        <li>
            <a href="organisation.php" >
                <i class="icon-edit"></i>
                <span>Organisation</span></a> </li>
        <li>
            <a href="contacts.php" >
                <i class="icon-edit"></i>
                <span>Contacts</span></a> </li>
        <li>
            <a href="view_quote.php">
                <i class="icon-edit"></i>
                <span>Quote</span> </a>
        </li>
        <li>
            <a href="view_shared.php">
                <i class="icon-edit"></i>
                <span>Share</span>
            </a>
        </li> 
        <li>
            <a href="changepswd.php">
                <i class="icon-edit"></i>
                <span>Change Password</span>
            </a>
        </li>
    </ul>  
    <?php
} elseif ($_SESSION['user_type'] == "logistics") {
    ?>
    <ul class='main-nav'>
        <li>
            <a href="home.php">
                <i class="icon-home"></i>
                <span><img src="images/ISlogo.jpg"  /></span>
                <span><img src="images/laboconlogo.jpg"  /></span>
            </a>
        </li>
        <li>
            <a href="view_logistics.php" >
                <i class="icon-edit"></i>
                <span>Logistics</span> </a>
    </li>
        <li>
            <a href="view_shipper.php" >
                <i class="icon-edit"></i>
                <span>Shipper</span>
   </a>
  </li>
        <li>
            <a href="view_pod.php">
                <i class="icon-edit"></i>
                <span>POD</span>
 </a>
        </li>
        <li>
            <a href="view_forwarder.php">
                <i class="icon-edit"></i>
                <span>Forwarder</span>
  </a>
        </li>
        <li>
            <a href="view_clearagents.php">
                <i class="icon-edit"></i>
                <span>Clearing Agent</span>
</a>
        </li>
        <li>
            <a href="changepswd.php">
                <i class="icon-edit"></i>
                <span>Change Password</span>
            </a>
        </li>
    </ul> 
    <?php
}
?>    