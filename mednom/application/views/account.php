<style>
@import url('https://fonts.googleapis.com/css?family=Do+Hyeon');
* {
  box-sizing: border-box;
  color: #333;
}
body {
  font: 16px Arial;  
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}
.error_cl{
  font-size: 13px;
  color: red;
font-family: 'Do Hyeon', sans-serif;
margin-bottom: 2px;
font-weight: 600;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
<style>

/* Full-width input fields */
.input[type=text], .input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

.input[type=text]:focus, .input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

button:hover {
    opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container1 {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>
<body>
<div id="account" style="margin-top:30px; margin-bottom:30px;" class="container container1 account_page">
<div class="row">
<div class="col-md-6">
<div id="sign_in_div" style="margin-top: 148px; margin-left: 192px;">
    <h5 style="padding-left: 8px; font-weight: 600; color: teal;"> Have An Account </h5>
    <button style="background:#09275b" type="submit" id="sign_in_btn" class="signupbtn">Sign In</button>
</div>
<form id="sign_in_form" method="post" action=<?php echo base_url().'check-login';?>>
<h1>Sign In</h1>
    <p>Please fill Details in this form to Sign Your account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input class="input" type="text" placeholder="Enter Email" name="email" required>
    <label for="psw"><b>Password</b></label>
    <input class="input" type="password" placeholder="Enter Password" name="password" required>
    <p><a href="<?= base_url().'forgot-password'; ?>" style="font-weight:600"> Forgot Password</a> </p>
    <div class="clearfix">
      <button type="submit" style="background:#09275b" class="signupbtn">Sign In</button>
    </div>
</form>
</div>
<div class="col-md-6">
<div id="sign_up_btn" style="margin-top: 148px; margin-left: 192px;">
    <h5 style="padding-left: 8px; font-weight: 600; color: #ff1332;"> Don't Have An Account </h5>
    <button style="background:#09275b" type="submit" id="sign_up_btn" class="signupbtn">Create An Account</button>
</div>
<form id="sign_up_form" method="POST" action="<?= base_url().'insert-user-data'; ?>">
  
<h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Contact Person <span style="color:red">*</span></b></label>
    <p class="error_cl" id="name_err"></p>
    <input class="input" id="name" type="text" placeholder="Enter Your Name" name="name" required>


    <label for="email"><b>Company Name <span style="color:red">*</span></b></label>
    <p class="error_cl" id="c_name_err"></p>
    <input class="input" id="c_name" type="text" placeholder="Enter Company Name" name="company_name" required>


    <label for="email"><b>Email <span style="color:red">*</span></b></label>
    <p class="error_cl" id="email_error"></p>
    <input style="margin-bottom: 9px;" class="input" id="email" type="text" placeholder="Enter Your Email" name="email" required>


<div class="autocomplete" style="width: 568px;
    margin-bottom: 20px;">

    <label for="email"><b>Country <span style="color:red">*</span></b></label>
    <p class="error_cl" id="myInput_err"></p>
    <input id="myInput" type="text" name="myCountry" value="<?php 
$ip_address = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR'); 
$jsondata = file_get_contents("http://timezoneapi.io/api/ip/?" . $ip_address); 
$data = json_decode($jsondata, true); 
if($data['meta']['code'] == '200'){  
  echo $data['data']['country'];
} ?>">
</div>

    <label for="psw-repeat"><b>Address </b><span>(optional)</span></label>
    <textarea class="input" type="text" name="address" placeholder="Your Current Address"></textarea>

    <label for="psw"><b>Phone</b> <span>(optional)</span></label>
    <input class="input" type="text" name="phone" placeholder="Enter Your Phone Number">


    <label for="psw"><b>Password <span style="color:red">*</span></b></label>
    <p class="error_cl" id="password_err"></p>
    <input class="input" type="password" id="password" placeholder="Enter Password" name="password" required>


      <label for="psw"><b>Confirm Password <span style="color:red">*</span></b></label>
      <p class="error_cl" id="c_password_err"></p>
    <input class="input" type="password" id="c_password" placeholder="Enter Password" name="password" required>

    
    <label>
      <input required type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>
    
    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

    <div class="clearfix">
       <button style="background:#09275b" type="submit" id="sub_btn" class="signupbtn">Sign Up</button>
    </div>
</form>
</div>
</div>
</div>
      <footer id="footer" class="footer-simple footer-dark">  
<script>
$('#sign_in_div').hide();
$('#sign_up_form').hide();
$('#sign_up_btn').click(function(){
    $('#sign_up_form').show(200);
    $('#sign_up_btn').hide();
    $('#sign_in_div').show();
    $('#sign_in_form').hide(300);
});
$('#sign_in_btn').click(function(){
    $('#sign_up_div').show();
    $('#sign_up_btn').show();
    $('#sign_in_div').hide();
    $('#sign_up_form').hide();
    $('#sign_in_form').show(300);
   // alert('hello');
});
$(document).ready(function() {
  // $("#sub_btn").click(function() {
  //   var email = $('#email').val();
  //   $.ajax({
  //     url: "<?php echo base_url().'email-check'; ?>",
  //     type: 'POST',
  //     data: {email:email},
  //     dataType: 'HTML',
  //     success: function(response) {
  //       if(response == 1){
  //       // $( "div.demo" ).scrollTop( 300 );
  //         $('#email_error').html('Email-Id Already Exist');
  //       }
  //       else{
  //         // $("#sign_up_form").submit();
  //       }
  //      }
  //   })
  // })


$('#sub_btn').click(function(){
  var name = $('#name').val();
  var email = $('#email').val();
  var password = $('#password').val();
  var c_name = $('#c_name').val();
  var c_password = $('#c_password').val();
  var myInput = $('#myInput').val();

  var flag = true;
  var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
  if(name == ""){
    $('#name_err').html('Enter Name');
    var flag = false;
  }
  else{
    $('#name_err').html('');
  }
  if(c_name == ""){
    $('#c_name_err').html('Enter Company Name');
    var flag = false;
  }
  else{
    $('#c_name_err').html('');
  }

  if(myInput == ""){
    $('#myInput_err').html('Enter Country Name');
    var flag = false;
  }
  else{
    $('#myInput_err').html('');
  }

  if(email == ""){
    $('#email_error').html('Enter Email');
    var flag = false;
  }
  else if(!pattern.test(email)){
    $('#email_error').html('');
    $('#email_error').append('Enter Correct Email Like- <span style="color:green; font-style:italic; font-weight:400; font-size:15px; text-decoration:underline">jsmith@example.com </span> ');
    var flag = false;
  }
  else{
    // $('#email_error').html('');
 $.ajax({
      async: false,
      url: "<?php echo base_url().'email-check'; ?>",
      type: 'POST',
      data: {email:email},
      dataType: 'HTML',
      success: function(response) {
        if(response == 1){
        // $( "div.demo" ).scrollTop( 300 );
          $('#email_error').html('Email-Id Already Exist');
          var flag = false;
          return false;
        }
        else{
          $('#email_error').html('');
          return true;
        }
       }
    })
  }
  if(password == ""){
    $('#password_err').html('Enter Password');
    var flag = false;
  }
  else{
    $('#password_err').html('');
  }
  if(c_password == ""){
    $('#c_password_err').html('Enter Confirm Password');
    var flag = false;
  }
  else if(c_password !== password){
    $('#c_password_err').html("Those passwords didn't match. Try again...");
    var flag = false;
  }
  else{
    $('#c_password_err').html('');
  }

  if(flag == true){
    return true;
  }
  else{
    window.scrollTo(165,165);
    return false;
  }
});
$('#sign_in_ch').click(function(){
  var email = $('#s_email').val();
  var password = $('#s_password').val();
  var flag = true;
  var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
  if(email == ""){
    $('#s_email_err').html('Enter Email');
    var flag = false;
  }
  else if(!pattern.test(email)){
    $('#s_email_err').html('');
    $('#s_email_err').append('Enter Correct Email Like- <span style="color:green; font-style:italic; font-weight:400; font-size:15px; text-decoration:underline">jsmith@example.com </span> ');
    flag = false;
  }
  else{
    $('#s_email_err').html('');
  }
  if(password == ""){
    $('#s_password_err').html('Enter Password');
    flag = false;
  }
  else{
    $('#s_password_err').html('');
  }
  if(flag == true){
    return true;
  }
  else{
    return false;
  }
});








})
</script>
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
      });
}

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);
</script>