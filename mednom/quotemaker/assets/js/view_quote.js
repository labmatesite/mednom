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
						document.getElementById('product_desc' + cnt).innerHTML=req.responseText;						
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
		var taxes=document.getElementById('hid_tx').value;
		var qty = document.getElementById('quantity'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		
		var tot = qty * sp;
		var temp_tax = taxes/100;
		
		document.getElementById('tot'+cnt).innerHTML=tot.toFixed(2);		
		document.getElementById('tadisc'+cnt).innerHTML=tot.toFixed(2);	
		document.getElementById('net'+cnt).innerHTML=tot.toFixed(2);
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		var i=1;x="";
		while(i<=numItems)	
		{
		 x=+x+ +document.getElementById('net'+i).innerHTML;
		 var taxes_tot=temp_tax * x;
		 var pre_tax=+x+ +sc;
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}	
		 document.getElementById('ittot1').innerHTML=x.toFixed(2);
		 document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		 document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2);
		 document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		 
		document.getElementById('qt_itemtotal').value=x.toFixed(2);
		document.getElementById('tax_total').value=taxes_tot.toFixed(2);
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		 i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
	
	}
	
	

	
	function sqty(qt,cnt) // Quantity Field
	{
		var sp=document.getElementById('selling_price'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot= qt * sp;
		var temp_tax = taxes/100;
		
		document.getElementById('tot'+cnt).innerHTML=tot.toFixed(2);		
		document.getElementById('tadisc'+cnt).innerHTML=tot.toFixed(2);	
		document.getElementById('net'+cnt).innerHTML=tot.toFixed(2);
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		
		var i=1;x="";
		while(i<=numItems)	
		{
		 x=+x+ +document.getElementById('net'+i).innerHTML;
		 var taxes_tot=temp_tax * x;
		 var pre_tax=+x+ +sc;
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}
		document.getElementById('ittot1').innerHTML=x.toFixed(2);
		document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2);
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		
		document.getElementById('qt_itemtotal').value=x.toFixed(2); 
		document.getElementById('tax_total').value=taxes_tot.toFixed(2);
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		 i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
		
			
	}
	
	function scharge(sc) // Shipping and Handling Charges field
	{
		var tot=document.getElementById('ittot1').innerHTML;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}		
		
		document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		
	}
	
	function sadjust(adj) // Adjustment Textfield
	{
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot=document.getElementById('ittot1').innerHTML;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}
		
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
	}
	
	function sadjust1() // Adjustment Checkboxes (Add or Subtract)
	{
		var sc=document.getElementById('shippin_charges').value;
		var adj1=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot=document.getElementById('ittot1').innerHTML;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj1;
		}
		else if(document.getElementById("subtract").checked)
		{
			
			var gttot1=gttot-adj1;
		}
		
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
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
	
	function tax(txid,txvalue,txstatus) // taxes 
	 {
						
						var sc=document.getElementById('shippin_charges').value;
						var adj1=document.getElementById('adjustment').value;
						var taxes1=document.getElementById('hid_tx').value; // finding the total taxes
						var tot=document.getElementById('ittot1').innerHTML;
						
						if(txstatus=="active")
						{
							taxes2=taxes1-txvalue;
						}
						else if(txstatus=="deactive")
						{
							taxes2=+taxes1+ +txvalue;
						}
						document.getElementById('hid_tx').value=taxes2; // updating the taxes
						
						var temp_tax = taxes2/100;
						var taxes_tot=temp_tax * tot;
						var pre_tax= +tot+ +sc;
						var gttot=taxes_tot + pre_tax;
						if(document.getElementById("add").checked)
						{
							var gttot1=+gttot+ +adj1;
						}
						else if(document.getElementById("subtract").checked)
						{
							var gttot1=gttot-adj1;
						}
		
					document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2); // updating the taxes
					document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);// updating the grandtotal
					
					document.getElementById('tax_total').value=taxes_tot.toFixed(2);
					document.getElementById('grandtotal').value=gttot1.toFixed(2);
					
								
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
