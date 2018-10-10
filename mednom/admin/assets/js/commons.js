// commons.js v1.0


function encode_html_special_chars(s) {  // to encode a string to use as text inside an html tag / can aslo be used to put a string inside an attribute
    //preserveCR = preserveCR ? '&#13;' : '\n';
    return ('' + s) /* Forces the conversion to string. */
        .replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
        .replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        /*
        You may add other replacements here for HTML only 
        (but it's not necessary).
        Or for XML, only if the named entities are defined in its DTD.
        */ 
        .replace(/\r\n/g, '&#13;') /* Must be before the next replacement. */
        .replace(/[\r\n]/g, '&#13;')
    ;
}


function decode_html_special_chars(s) {
    s = ('' + s); /* Forces the conversion to string type. */
    s = s
        .replace(/\r\n/g, '\n') /* To do before the next replacement. */ 
        .replace(/[\r\n]/, '\n')
        .replace(/&#13;&#10;/g, '\n') /* These 3 replacements keep whitespaces. */
        .replace(/&#1[03];/g, '\n')
        .replace(/&#9;/g, '\t')
        .replace(/&gt;/g, '>') /* The 4 other predefined entities required. */
        .replace(/&lt;/g, '<')
        .replace(/&quot;/g, '"')
        .replace(/&apos;/g, "'")
    ;
    
    /* This MUST be the last replacement. */
    s = s.replace(/&amp;/g, '&');
    return s;
}


function escape_quotes_and_backslash(str) { // escapes ["] ['] [\]
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function unescape_quotes_and_backslash(str) { // escapes ["] ['] [\]
    return eval('"' + str + '"'); // for double quoted escaped string
}

function escape_double_quotes_with_repetition(str){
    return (str + '').replace('"', '""')
}

function unescape_double_quotes_with_repetition(str){
    return (str + '').replace('""', '"')
}

function add_param_to_url(key, value) { // insert a query string to current url

    key = encodeURI(key);
    value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i = kvp.length;
    var x;
    while (i--) {
	x = kvp[i].split('=');
	
	if (x[0] == key) {
	    x[1] = value;
	    kvp[i] = x.join('=');
	    break;
	}
    }

    if (i < 0) {
	kvp[kvp.length] = [key, value].join('=');
    }

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&');
}

function getQueryVariable(url, variable) { // returns value without url decoding
  var query = url.substring( url.indexOf('?') + 1 );
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
}

function urldecode(str) {  // php equivalent
   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}