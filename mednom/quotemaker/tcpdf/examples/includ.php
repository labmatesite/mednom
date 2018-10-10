<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>function getPageHTML() {
  var show1=$("html").html();
alert(show1);
   $.ajax({
                                    type: "GET",
                                    url: "div2.php",
                                    data: "show=" + show1+ "&refid=LABOT04159",
                                    cache: false,
                                  
                                    success: function(html) {
alert("saved");
                                       // $("#results").html(html);
                                        //$('.loader').html('');
                                    }
                                });
                            
}</script>