
// page load
$(function(){
    $('.ckeditor').each(function(){
        CKEDITOR.replace(this);
    });
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
    }
});

function encrypted_password_change(ele) {
    
    var main_container = $(ele).parent();
    var field_parent = main_container.attr('data-field-parent');
    var field_name = main_container.attr('data-field-name');
    var password_name = field_parent + '[' + field_name + ']';
    var password_encrypted_name = field_parent + '[' + field_name + '_encrypted' + ']';
   // var password_salt_name = field_parent + '[' + field_name + '_salt' + ']';
    var password_alias_name = field_parent + '[' + field_name + '_alias' + ']';
    if (!parent) {
        password_name = field_name;
        password_encrypted_name = field_name + '_encrypted';
        //password_salt_name = field_name + '_salt';
        password_alias_name = field_name + '_alias';
    }
    var password = $('[name="' + password_name + '"]');
    var password_encrypted = $('[name="' + password_encrypted_name + '"]');
    //var password_salt = $('[name="' + password_salt_name + '"]');
    var password_alias = $('[name="' + password_alias_name + '"]');
    var ep_password = main_container.find('.encrypted_password_password');
    var ep_master_password = main_container.find('.encrypted_password_master_password');
    ep_password_aliases_data = JSON.parse(main_container.find('.encrypted_password_password_aliases_data').val());
    
    
    
    password.val('');
    password_encrypted.val('');
    //password_salt.val('');
    ep_password.css('border-color', '');
    ep_master_password.css('border-color', '');
    if (ep_password.val() != ''){
        ep_password.css('border-color', 'green');
        if(ep_master_password.val() != '' && /^[a-f0-9]{128}$/.test(slowaes_decrypt(ep_password_aliases_data[password_alias.val()].check_hash, ep_master_password.val()))){
            ep_master_password.css('border-color', 'green');
            var salt = encrypted_password_gen_salt();
            //password_salt.val(salt);
            password_encrypted.val(slowaes_encrypt('' + salt + ep_password.val(), ep_master_password.val()));
        } else {
            ep_master_password.css('border-color', 'red');
        }
    } else {
        ep_password.css('border-color', 'red');
    }
}

function encrypted_password_show_toggle(checkbox){
    checkbox = $(checkbox);
    var main_container = checkbox.parent().parent();
    var field_parent = main_container.attr('data-field-parent');
    var field_name = main_container.attr('data-field-name');
    var password_name = field_parent + '[' + field_name + ']';
    if (!parent) {
        password_name = field_name;
    }
    var type = 'password';
    if (checkbox.is(":checked")) {
        type = 'text';
    }
    
    $('[name="' + password_name + '"]').attr('type', type);
    main_container.find('.encrypted_password_password').attr('type', type);
    //main_container.find('.encrypted_password_master_password').attr('type', type);
}



function encrypted_password_gen_salt(){
    return CryptoJS.lib.WordArray.random(128/2).toString(); // for 128 chars hex string
}

function password_check_hash_change(ele) {
    
    var main_container = $(ele).parent();
    
    var password = main_container.find('.password_check_hash_password');
    var password_confirm = main_container.find('.password_check_hash_password_confirm');
    var check_hash = $('[name="' + main_container.attr('data-onchange-update-field') + '"]');
    
    check_hash.val('');
    password.css('border-color', '');
    password_confirm.css('border-color', '');
    if (password.val() != ''){
        password.css('border-color', 'green');
        if (password.val() == password_confirm.val()) {
            check_hash.val(slowaes_encrypt(encrypted_password_gen_salt(), password.val()));
        } else {
            password_confirm.css('border-color', 'red');
        }
    } else {
        password.css('border-color', 'red');
    }
    
}

function password_check_hash_show_toggle(checkbox){
    checkbox = $(checkbox);
    var main_container = checkbox.parent().parent();
    var type = 'password';
    if (checkbox.is(":checked")) {
        type = 'text';
    }
    main_container.find('.password_check_hash_password').attr('type', type);
    main_container.find('.password_check_hash_password_confirm').attr('type', type);
}

function password_hash_check_change(ele, target_field_name, check_hash){
    var password = $(ele);
    var master_password = $('[name="' + target_field_name + '"]');
    master_password.val('');
    password.css('border-color', 'red');
    if (password.val()) {
        if (/^[a-f0-9]{128}$/.test(slowaes_decrypt(check_hash, password.val()))) {
            master_password.val(password.val());
            password.css('border-color', 'green');
        }
    }
}


function field_onchange_update(ele, target_field_name){
    var src = $(ele);
    var dest = $('[name="' + target_field_name + '"]');
    if (src.is(':checkbox')) {
        if(src.is(":checked")){
            dest.val('1');
        } else {
            dest.val('0');
        }
    } else {
        dest.val(src.val());
    }
}

function xls_file_onchange() {
    xls_file_id = $("select[name='xls_file_id']").val();
    insertParam('xls_file_id', xls_file_id);
}

function insertParam(key, value) // insert a query string to url
{
    key = encodeURI(key);
    value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i = kvp.length;
    var x;
    while (i--)
    {
        x = kvp[i].split('=');

        if (x[0] == key)
        {
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

function update_attr_list() {
    str = '';
    for (i = 0; i < attrs.length; i++) {
        is_fixed_key = ($.inArray(attrs[i][0], fixed_keys) != -1);
        str += '<li class="attribute-list"><span class="attribute-list-drag handle"><img src="assets/images/drag-icon.png" ></span><div class="td-ul-text"><input class="input_keys"  type="text" name="attrs[' + i + '][0]" value="' + attrs[i][0] + '" onchange="onchange_attr(' + i + ',0)" ' + (is_fixed_key ? "readonly" : "") + '></div><div class="td-ul-cross">:</div><div class="td-ul-text"><input class="input_values" type="text" name="attrs[' + i + '][1]" value="' + attrs[i][1] + '" onchange="onchange_attr(' + i + ',1)" ></div>' + (is_fixed_key ? '<div class="td-ul-cross"></div>' : '<div class="td-ul-cross" onclick="remove_attr(' + i + ')" > x </div>') + '</li>';
    }
    $('#attr_container').html(str);
    $('#attr_container').unbind('sortupdate').sortable({
        handle: '.handle'
    }).bind('sortupdate', function() {
    console.log('sortupdate');
        all_inputs = $("#attr_container :input");
        for (i = 0, j = 0; i < all_inputs.length; i++) {
            if ($(all_inputs[i]).hasClass("input_keys")) {
                attrs[j][0] = $(all_inputs[i]).val();
            } else if ($(all_inputs[i]).hasClass("input_values")) {
                attrs[j][1] = $(all_inputs[i]).val();
                j++;
            }
        }
        update_attr_list();
    });
}

function onchange_attr(i, j) {
    value = $("input[name='attrs[" + i + "][" + j + "]']").val();
    exists = false;
    for (k = 0; k < attrs.length; k++) {
        if (attrs[k][0] == value) {
            exists = true;
            break;
        }
    }
    if (exists) {
        $("input[name='attrs[" + i + "][" + j + "]']").val("");
        alert("Duplicate Key, Attribte Keys should be unique.");
    } else {
        attrs[i][j] = value;
    }

    console.log("change", value, i, j);

}

function add_attr() {
    //attrs.splice(index, 0, ["", ""]);
    attrs.push(["", ""]);
    update_attr_list();
}

function remove_attr(index) {
    attrs.splice(index, 1);
    update_attr_list();
}