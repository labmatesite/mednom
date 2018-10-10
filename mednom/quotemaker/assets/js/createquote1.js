var cnt = 1;

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function AddRow(){
		
	cnt++;
    var newRow = jQuery('<tr id="addrowid' + cnt + '"></tr>'); // add new tr with dynamic id and then add new row with textfield.
    jQuery('table.authors-list').append(newRow);	
	var strURL="addnewrow.php?cnt="+cnt;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('addrowid' + cnt).innerHTML=req.responseText;	
						$("#product_name" + cnt).select2();	
										
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}	
	}
	
	function RemoveRow(rowno){
	document.getElementById("quantity"+rowno).value=1;
	var sp1=document.getElementById("selling_price"+rowno).value=(0).toFixed(2);
	 $("#product_name"+rowno).each(function() { this.selectedIndex = 0 });
	document.getElementById('product_desc'+rowno).innerHTML="";
	document.getElementById('tot'+rowno).innerHTML=(0).toFixed(2);
	document.getElementById('disc'+rowno).innerHTML=0;
	document.getElementById('tadisc'+rowno).innerHTML=(0).toFixed(2);
	document.getElementById('net'+rowno).innerHTML=(0).toFixed(2);
	sord('0',rowno);
	document.getElementById("addrowid"+rowno).style.display="none";
	
	/*var strURL="addnewrow.php?cnt="+cnt;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('addrowid' + cnt).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}	*/	
	}
	

function PrimaryEmail(eadd){
//alert("good");
		var strURL="viewsearchcontemail.php?eadd="+eadd;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('comp1_4').innerHTML=req.responseText;
						var g=document.getElementById('primaryemailid').value;
							if(g==2)
							{
								<!--alert(" User Already registered with this username");-->
									document.getElementById('cemail').value="";
							}
							else
							{
								
							}
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}
	
		function showcontdata(contid)
	{
		
			orgcontact = "<label for='textfield' class='control-label'>Contact Details</label><div class='controls'><select id='cont_sal' name='cont_sal' style='width:15%;' class='select2-me input-xlarge'><option value='' selected>None</option><option value='ms'>Ms.</option><option value='mrs'>Mrs.</option><option value='mr'>Mr.</option><option value='dr'>Dr.</option><option value='prof'>Prof.</option></select><input type='text'  data-rule-required='true'name='cfname' class='input-xlarge' placeholder='First Name' required><input type='text'  data-rule-required='true' name='clname' class='input-xlarge' placeholder='Last Name'><input type='text'  data-rule-required='true' name='cemail' id='cemail' class='input-xlarge' placeholder='Primary Email' required onblur='PrimaryEmail(this.value);'><span id='comp1_4' style='color:#FF0000;'></div>";
			
			if(contid==-1)
		{
			//alert(contid);
			document.getElementById('mycontdet').style.display='inline';
			document.getElementById('mycontdet').innerHTML=orgcontact;
		}
		else
		{
			document.getElementById('mycontdet').innerHTML='';
		document.getElementById('mycontdet').style.display='none';
			
		}
		
		
	}
	

function Organisationname(orgname){
//alert("hello");
		var strURL="viewsearchorg.php?orgname="+orgname;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('comp_1').innerHTML=req.responseText;
						var g=document.getElementById('orgnameid').value;
							if(g==2)
							{
								<!--alert(" User Already registered with this username");-->
									document.getElementById('myorgname').value="";
							}
							else
							{
								
							}
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}	


function PrimaryEmailorg(eadd){
		var strURL="viewsearchemail.php?eadd="+eadd;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('comp_2').innerHTML=req.responseText;
						var g=document.getElementById('primaryemailid').value;
							if(g==2)
							{
								<!--alert(" User Already registered with this username");-->
									document.getElementById('orgemail').value="";
							}
							else
							{
								
							}
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}	





	function Organisation(orgid){
//alert("hello");
 orginfo = "<label for='textfield' class='control-label'>Organisation Details</label><div class='controls'><input type='text'  class='input-xlarge' placeholder='Organisation Name' style='width: 274px;margin-left: 23px;' id='myorgname' name='myorgname' required onblur='Organisationname(this.value);'><span id='comp_1' style='color:#FF0000;'></span><input type='text' data-rule-required='true' class='input-xlarge' placeholder='Organisation Email' style='width: 274px;margin-left: 23px;' id='orgemail' name='orgemail' required onblur='PrimaryEmailorg(this.value);'><span style='color:#FF0000;' id='comp_2'></span><textarea  data-rule-required='true' class='input-xlarge' placeholder='Organisation billing Address' style='width: 274px;margin-left: 23px;' id='orgbill' name='orgbill' required></textarea><input type='text'  data-rule-required='true'  class='input-xlarge' placeholder='Organisation City' style='width: 274px;margin-left: 23px;' id='orgcity' name='orgcity' required><input type='text'  data-rule-required='true'  class='input-xlarge' placeholder='Organisation State' style='width: 274px;margin-left: 23px;' id='orgstate' name='orgstate' required>";
		if(orgid==-1)
		{
			//alert(orgid);
			document.getElementById('myorgdetails').style.display='inline';
			document.getElementById('myorgdetails').innerHTML=orginfo;
		}
		else
		{
				//document.getElementById('myorgdetails').style.display='inline';
			document.getElementById('myorgdetails').innerHTML='';
			
			document.getElementById('myorgdetails').style.display='none';
		}
		if(orgid!="")
		{
			
			
		var strURL="vieworgcontacts.php?orgid="+orgid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('contactsid').innerHTML=req.responseText;
						$("#qt_contacts").select2();
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}	
		}
		else
		{
			
			document.getElementById('contactsid').disabled;
			$("#qt_contacts").each(function() { this.selectedIndex = 0 });
			$("#qt_contacts").select2();
		}
		
	}
	
	
	function Contacts(contid){
		

		var strURL="viewcontorganisation.php?contid="+contid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('organisationid').innerHTML=req.responseText;
						$("#qt_organisationid").select2();
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}

				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}
	
	
	function product_Desc(val1,cnt) {
		if(val1!="other/other")
		{
//alert(val1);
			document.getElementById('prod_fullname' + cnt).style.display="none";
			val2 = val1.substring(0, val1.indexOf('/'));
			val3 = val1.substring(val1.indexOf('/')+1);
			document.getElementById('prod_fullname' + cnt).value=val3;
			var strURL="viewproduct.php?val1="+val2;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
//alert(req.responseText);

							document.getElementById('product_desc' + cnt).value=req.responseText;
							document.getElementById('prod_sku' + cnt).value=val2;
							document.getElementById('product_catalog' + cnt).style.display="block";
													
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("REQUEST", strURL, true);
				req.send(null);
			}	
		}
		else
		{
		document.getElementById('prod_fullname' + cnt).style.display="block";
		document.getElementById('prod_fullname' + cnt).value="";
		document.getElementById('product_desc' + cnt).value="";
		}
	}
	
	function product_Catalog(val1,cnt) {
		
		
				val2 = val1.substring(0, val1.indexOf('/'));
				val3 = val1.substring(val1.indexOf('/')+1);
				var strURL="viewproductCatalog.php?val1="+val2+"&cnt1="+cnt;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById('product_catalog' + cnt).innerHTML=req.responseText;
									if(val1=="other/other")
									{
										
									document.getElementById('prod_sku' + cnt).value="other";	
									}
									document.getElementById('selling_price' + cnt).focus();
									
								} else {
								alert("There was a problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("REQUEST", strURL, true);
					req.send(null);
				}
		
			
	}
	
	 function product_Price(val1, cnt) {


                    val2 = val1.substring(0, val1.indexOf('/'));
                    val3 = val1.substring(val1.indexOf('/') + 1);
                    var val5 = document.getElementById('qt_cur').value;
                    var strURL = "viewproductPrice.php?val1=" + val2 + "&cnt1=" + cnt + "&money=" + val5;
                    var req = getXMLHTTP();

                    if (req) {

                        req.onreadystatechange = function () {
                            if (req.readyState == 4) {
                                // only if "OK"
                                if (req.status == 200) {

                                
                                    document.getElementById('selling_price' + cnt).value = req.responseText;

                                    if (val1 == "other/other")
                                    {
                                        document.getElementById('prod_sku' + cnt).value = "other";
                                    }

                                    document.getElementById('selling_price' + cnt).focus();

                                } else {
                                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                                }
                            }
                        }
                        req.open("REQUEST", strURL, true);
                        req.send(null);
                    }


                }
	function sord(sp,cnt) // Selling Price field
	{
		// $('.currency').formatCurrency();
		var taxes=document.getElementById('hid_tx').value;
		var qty = document.getElementById('quantity'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		
		var tot = qty * Number(sp);
		var temp_tax = taxes/100;
		
		document.getElementById('tot'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));		
		document.getElementById('tadisc'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));	
		document.getElementById('net'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));
		
		
		
             
		
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		var i=1;x="";
		while(i<=numItems)	
		{
		 var netpricetemp=	document.getElementById('net'+i).innerHTML;
		 var netprice = Number(netpricetemp.replace(/[^0-9\.]+/g,""));
		 x=+x+ +netprice;
		 
		
		 
		 var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
		}	
		 document.getElementById('ittot1').innerHTML=ReplaceNumberWithCommas(x.toFixed(2));
		 document.getElementById('ittot2').innerHTML=ReplaceNumberWithCommas(x2.toFixed(2));
		 document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
		 document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		 
		document.getElementById('qt_itemtotal').value=ReplaceNumberWithCommas(x.toFixed(2));
		document.getElementById('qt_discount').value=ReplaceNumberWithCommas(x2.toFixed(2));
		document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
		document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
		 i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
		document.getElementById('DiscPrice').innerHTML=ReplaceNumberWithCommas(x.toFixed(2));
	
	}
	
function ReplaceNumberWithCommas(yourNumber) {
    //Seperates the components of the number
    var n= yourNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
}

	
	function sqty(qt,cnt) // Quantity Field
	{
		var sp=document.getElementById('selling_price'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot= qt * Number(sp.replace(/[^0-9\.]+/g,""));
		var temp_tax = taxes/100;

		
		document.getElementById('tot'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));		
		document.getElementById('tadisc'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));	
		document.getElementById('net'+cnt).innerHTML=ReplaceNumberWithCommas(tot.toFixed(2));
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		
		var i=1;x="";
		while(i<=numItems)	
		{
		 var netpricetemp=	document.getElementById('net'+i).innerHTML;
		 var netprice = Number(netpricetemp.replace(/[^0-9\.]+/g,""));
		 x=+x+ +netprice;
		 var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
		 
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
		}

		
		document.getElementById('ittot1').innerHTML=ReplaceNumberWithCommas(x.toFixed(2));
		document.getElementById('ittot2').innerHTML=ReplaceNumberWithCommas(x2.toFixed(2));
		document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
		document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
		document.getElementById('qt_itemtotal').value=ReplaceNumberWithCommas(x.toFixed(2));
		document.getElementById('qt_discount').value=ReplaceNumberWithCommas(x2.toFixed(2));
		document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
		document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
		i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
		document.getElementById('DiscPrice').innerHTML=ReplaceNumberWithCommas(x.toFixed(2));
		
			
	}
	
	function scharge(sc) // Shipping and Handling Charges field
	{
		//$('.currency').formatCurrency();
		var tottem=document.getElementById('ittot1').innerHTML;
		var x = Number(tottem.replace(/[^0-9\.]+/g,""));
		
		var adj1=document.getElementById('adjustment').value;
		var adj=Number(adj1.replace(/[^0-9\.]+/g,""));
		var taxes=document.getElementById('hid_tx').value;
		
		var temp_tax = taxes/100;
		var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
		
		
		
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}		
		
		document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
		document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
		document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
	}
	
	function sadjust(adj) // Adjustment Textfield
	{
		//$('.currency').formatCurrency();
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot1=document.getElementById('ittot1').innerHTML;
		var x = Number(tot1.replace(/[^0-9\.]+/g,""));
		
		
		var temp_tax = taxes/100;
				
		 var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
		
		var gttot=taxes_tot + pre_tax;
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
			
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
			
		}
		
		document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
	}
	
	function sadjust1() // Adjustment Checkboxes (Add or Subtract)
	{
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot1=document.getElementById('ittot1').innerHTML;
		var x = Number(tot1.replace(/[^0-9\.]+/g,""));
		
		var temp_tax = taxes/100;
		
		
		 var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
		
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
		}
		else if(document.getElementById("subtract").checked)
		{
			
			var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
		}
		
		document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
	}
	
	function taxval() // taxes1 count active no of taxes and store in hidden txtfield
							{
								var strURL="counttxvalue.php";
								var req = getXMLHTTP();
								if (req) {
									req.onreadystatechange = function() {
										if (req.readyState == 4) {
											// only if "OK"
											if (req.status == 200) {
												document.getElementById('hid_tx').value =req.responseText;
											} else {
												alert("There was a problem while using XMLHTTP:\n" + req.statusText);
											}
										}				
									}			
									req.open("REQUEST", strURL, true);
									req.send(null);
								}	
							}
							
	function tnc(tnc_orgid) //  updating the terms and conditions textarea
	 {		
		var strURL="updatetnc.php?tnc_orgid="+tnc_orgid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						tinyMCE.activeEditor.setContent(req.responseText);						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
		}		
	}						
	
	function DiscFinal(frm){ // Discount Module Calculation
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		var sc=document.getElementById('shippin_charges').value;
		var tot1=document.getElementById('ittot1').innerHTML;
		var tot = Number(tot1.replace(/[^0-9\.]+/g,""));

   if (frm == "zero")
	{
		document.getElementById('per_price').value=0;
		document.getElementById('dpr').value=0;
		
		var temp_tax = taxes/100;
			var taxes_tot=temp_tax * tot;
			var pre_tax= +tot+ +Number(sc.replace(/[^0-9\.]+/g,""));
			
			var gttot=taxes_tot + pre_tax;
		
				if(document.getElementById("add").checked)
				{
					var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
				}
				else if(document.getElementById("subtract").checked)
				{
					var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
				}
			document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
			document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
			document.getElementById('ittot2').innerHTML="0.00";
		    document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
			document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
			document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
			document.getElementById('qt_discount').value="0.00";
			document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
	  return true
	}
   else if(frm == "r_perprice"){
	   document.getElementById('per_price').style.display="block";
	   document.getElementById('dpr').value=0;
	   document.getElementById('dpr').style.display="none";
      
	  var val_perprice = document.getElementById('per_price').value;
	  	
		if(val_perprice=="")
	  	{
			
	  	}
		else
		{
			var t_perprice = val_perprice/100;
			var tot2 = tot * t_perprice;
			var f_tot=tot-tot2;
			
			var temp_tax = taxes/100;
			var taxes_tot=temp_tax * f_tot;
			var pre_tax= +f_tot+ +Number(sc.replace(/[^0-9\.]+/g,""));
			
			var gttot=taxes_tot + pre_tax;
		
				if(document.getElementById("add").checked)
				{
					var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
				}
				else if(document.getElementById("subtract").checked)
				{
					var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
				}
				document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
			document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
			document.getElementById('ittot2').innerHTML=ReplaceNumberWithCommas(tot2.toFixed(2));
		    document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
			document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
			document.getElementById('qt_discount').value=ReplaceNumberWithCommas(tot2.toFixed(2));
			document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
			document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
			
		}
      return true
   }
   else if(frm == "r_dpr")
   {
	   document.getElementById('dpr').style.display="block";
	   document.getElementById('per_price').value=0;
	   document.getElementById('per_price').style.display="none";   
	    var val_dpr1 = document.getElementById('dpr').value;
	  	var val_dpr=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		if(val_dpr=="")
	  	{
			
		}
		else
		{
			var f_tot=tot-val_dpr;
			var temp_tax = taxes/100;
			var taxes_tot=temp_tax * f_tot;
			var pre_tax= +f_tot+ +Number(sc.replace(/[^0-9\.]+/g,""));
			
			var gttot=taxes_tot + pre_tax;
		
				if(document.getElementById("add").checked)
				{
					var gttot1=+gttot+ +Number(adj.replace(/[^0-9\.]+/g,""));
				}
				else if(document.getElementById("subtract").checked)
				{
					var gttot1=gttot-Number(adj.replace(/[^0-9\.]+/g,""));
				}
				document.getElementById('ittot2').innerHTML=ReplaceNumberWithCommas(val_dpr.toFixed(2));
				document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
				document.getElementById('ittot3').innerHTML=ReplaceNumberWithCommas(pre_tax.toFixed(2));
				document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));
		
				document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
				document.getElementById('qt_discount').value=ReplaceNumberWithCommas(val_dpr.toFixed(2));
				document.getElementById('pretaxtotal').value=ReplaceNumberWithCommas(pre_tax.toFixed(2));
				document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
		}
      return true 
   }
   
   			
}
	
	
	function tax(txid,txvalue,txstatus,txname) // taxes 
	 {
			
						var sc=document.getElementById('shippin_charges').value;
						var adj1=document.getElementById('adjustment').value;
						var taxes1=document.getElementById('hid_tx').value; // finding the total taxes
						var tot1=document.getElementById('ittot1').innerHTML;
						var x=Number(tot1.replace(/[^0-9\.]+/g,""));
						
						if(txstatus=="active")
						{
							taxes2=taxes1-txvalue;
							document.getElementById('st'+txid).onclick=function(){ tax(txid,txvalue,"deactive",txname); } ;
						}
						else if(txstatus=="deactive")
						{
							taxes2=+taxes1+ +txvalue;
							document.getElementById('st'+txid).onclick=function(){ tax(txid,txvalue,"active",txname); } ;
						}
						document.getElementById('hid_tx').value=taxes2; // updating the taxes
						
						var temp_tax = taxes2/100;
						
						
						 var discount_final = $("input:radio[name=discount_final]:checked").val();
             		if(discount_final=="zero")
					{
					 var pre_tax=+x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * x;
					 var x2=0.00;
                    }
					else if(discount_final=="r_perprice")
					{
                     var val_perprice = document.getElementById('per_price').value;
					 //divide by 100;
					 var t_perprice = val_perprice/100;      
					 // multiple with total price;
					 var x2 = x * t_perprice;
					 // Discount is subtract from
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
					else if(discount_final=="r_dpr")
					{
					
					var val_dpr1 = document.getElementById('dpr').value;
	  				var x2=Number(val_dpr1.replace(/[^0-9\.]+/g,""));
		
					 var f_x=x-x2;
					 var pre_tax=+f_x+ +Number(sc.replace(/[^0-9\.]+/g,""));
					 var taxes_tot=temp_tax * f_x;
					}
						
						var gttot=taxes_tot + pre_tax;
						if(document.getElementById("add").checked)
						{
							var gttot1=+gttot+ +Number(adj1.replace(/[^0-9\.]+/g,""));
						}
						else if(document.getElementById("subtract").checked)
						{
							var gttot1=gttot-Number(adj1.replace(/[^0-9\.]+/g,""));
						}
					
					
		
					document.getElementById('ittot4').innerHTML=ReplaceNumberWithCommas(taxes_tot.toFixed(2)); // updating the taxes
					document.getElementById('ittot6').innerHTML=ReplaceNumberWithCommas(gttot1.toFixed(2));// updating the grandtotal
					
					document.getElementById('tax_total').value=ReplaceNumberWithCommas(taxes_tot.toFixed(2));
					document.getElementById('grandtotal').value=ReplaceNumberWithCommas(gttot1.toFixed(2));
					
								
		var strURL="updatetx.php?txid="+txid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {	
						document.getElementById('mainform').innerHTML=req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
		}		
	}
	
	