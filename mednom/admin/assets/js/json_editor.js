

$(function(){
    
    
    je_init();
    
});


function je_init(){
    $('.je_main_container').each(function(){
        var self = $(this);
        je_load(self);
    });
    
    je_init_sortable();
    
    $(document).click(function(event){
        if(!$(event.target).parents().andSelf().hasClass('je_option_button')){
            $('.je_option_menu').remove();
        }
    });
    
    $("form").submit(function (e) {
        je_update_all();
    });
    
    $('.ckeditor').each(function(){
        CKEDITOR.replace(this);
    });
    
    // dosent work
    //for (var i in CKEDITOR.instances) {
    //    CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
    //    console.log('hello');
    //}
    
    // before submit works
    //for(var instanceName in CKEDITOR.instances) {
    //    CKEDITOR.instances[instanceName].updateElement();
    //}
    
}

function je_replace_ckeditor(){
    $('.ckeditor').each(function(){
        CKEDITOR.replace(this);
    });
}

function je_init_sortable(){
    //$('.je_list_container').sortable('destroy');
    //$('.je_list_container').sortable({
    //    forcePlaceholderSize: true,
    //    handle: '.je_option_button_draggable'
    //});
}

function je_update_all(){
    $('.je_main_container').each(function(){
        var self = $(this);
        je_update_data(self);
    });
}

function je_load(container){
    var json_data = JSON.parse(container.find('.je_json_data').val());
    var json_schema_str = container.find('.je_json_schema').val();
    if (json_schema_str && json_schema_str.trim()) {
        var json_schema = JSON.parse(json_schema_str);
    }
    container.append(''
        + '<table class="je_panel_container">'
            + '<tr>'
                + '<td class="je_panel_left">'
                    + '<div class="je_option_button je_option_button_main" onclick="je_option_click(this)"></div>'
                + '</td>'
            + '</tr>'
        + '</table>'
    );
    container.append(je_get_html(json_data, json_schema, json_schema));
}

function je_update_data(container){
    for(var instanceName in CKEDITOR.instances) {
        CKEDITOR.instances[instanceName].updateElement();
    }
    var json_data = je_get_json(container.find('> .je_list_container_wrap'));
    var json_data_container = container.find('.je_json_data');
    json_data_container.val(JSON.stringify(json_data));
    field_onchange_update(json_data_container[0], json_data_container.attr('data-onchange-update-field'));
}

function je_get_html(data, schema, list_attr, create_new){
    
    var list_items = '';
    var list_type = 'array';
    if (Object.getPrototypeOf( data ) === Object.prototype) {
        list_type = 'object';
    }
    var last_button_hidden = true;

    
    if (create_new) {
        
        if (list_attr && list_attr.structure_nodes.length) { // else do nothing, keep a blank list
            for(var i = 0; i < list_attr.structure_nodes.length; i++) {
                if(list_attr.structure_nodes[i].min_instances > 0) {
                    var value = '';
                    var value_attr = '';
                    
                    if (schema && list_attr.structure_nodes[i].value_attribute) {
                        value_attr = schema.structure_attributes[list_attr.structure_nodes[i].value_attribute];
                    }
                    
                    if (list_attr.structure_nodes[i].type == 'object' || (value_attr && value_attr.data_type_details.type == 'json_object')) {
                        value = {};
                    } else if (list_attr.structure_nodes[i].type == 'array' || (value_attr && value_attr.data_type_details.type == 'json_array')) {
                        value = [];
                    }
                    
                    var list_item_value_list_item = je_get_node_html(list_attr.structure_nodes[i].key_name, value, schema, list_attr.structure_nodes[i], list_type, create_new);//je_get_new_node_html(value_attr.structure_nodes[i], schema, value_type, value_attr);
                    for(var j = 0; j < list_attr.structure_nodes[i].min_instances; j++) {
                        list_items += list_item_value_list_item;
                    }
                }
                
                // decide on last option button
                if(list_attr.structure_nodes[i].max_instances == 0 || list_attr.structure_nodes[i].min_instances < list_attr.structure_nodes[i].max_instances ) {
                    last_button_hidden = false;
                }
            }
        } else {
            last_button_hidden = false;
        }
        
    } else {
        
        if (list_type == 'object') {
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var node_type = '';
                    if (list_attr) {
                        for(var i = 0; i < list_attr.structure_nodes.length; i++) {
                            if (list_attr.structure_nodes[i].key_name == key) {
                                var node_type = list_attr.structure_nodes[i];
                                break;
                            }
                        }
                        if (!node_type) {
                            for(var i = 0; i < list_attr.structure_nodes.length; i++) {
                                if (!list_attr.structure_nodes[i].key_name) {
                                    var node_type = list_attr.structure_nodes[i]; // objects can have only one node type with undefined key
                                    break;
                                }
                            }
                        }
                    }
                    
                    list_items += je_get_node_html(key, data[key], schema, node_type, 'object', create_new);
                }
            }
        } else {
            for(var i = 0; i < data.length; i++){
                var node_type = '';
                if (list_attr) {
                    if (list_attr.structure_nodes[0]) {
                        var node_type = list_attr.structure_nodes[0]; // arrays have only one node type
                    }
                }
                
                list_items += je_get_node_html('', data[i], schema, node_type, 'array', create_new);
            }
        }
        
        
        var left_node_types = je_get_left_node_types(data, list_attr);
        if (left_node_types && left_node_types.length) {
            last_button_hidden = false;
        }
    }
    
    
    
    
    
    
    var list_attr_name = '';
    if (list_attr) {
        if (schema && schema == list_attr) {
            list_attr_name = 'main_attr';
        } else {
            list_attr_name = list_attr.name;
        }
    }

    return ''
        + '<div class="je_list_container_wrap" data-je-list-type="' + list_type + '"' + ((list_attr_name)? ' data-je-attr-name="' + list_attr_name + '"' : '') + '>'
            + '<div class="je_list_container">'
                + list_items
            + '</div>'
            + '<table class="je_panel_container"' + ((last_button_hidden)? ' style="display:none"' : '') + '>'
                + '<tr>'
                    + '<td class="je_panel_left">'
                        + '<div class="je_option_button je_option_button_last"  onclick="je_option_click(this)"></div>'
                    + '</td>'
                + '</tr>'
            + '</table>'
        + '</div>'
    ;
}


function je_get_node_html(key, value, schema, node_type, list_type, create_new) {
    
    if (list_type == 'object') {

        var item = '<div class="je_list_item">';
        
        if (typeof value === 'object' || value.constructor === Array) {
            item += ''
                + '<table class="je_panel_container">'
                    + '<tr>'
                        + '<td class="je_panel_left">'
                            + '<div class="je_option_button je_option_button_draggable" onclick="je_option_click(this)"></div>'
                            + '<textarea class="je_key" placeholder="key">' + key + '</textarea>'
                        + '</td>'
                    + '</tr>'
                + '</table>'
            ;
            item += je_get_html(value, schema, ((node_type && node_type.value_attribute)? schema.structure_attributes[node_type.value_attribute] : ''), create_new);
        } else {
            item += ''
            + '<table class="je_panel_container">'
                + '<tr>'
                    + '<td class="je_panel_left">'
                        + '<div class="je_option_button je_option_button_draggable" onclick="je_option_click(this)"></div>'
                        + '<textarea class="je_key" placeholder="key">' + key + '</textarea>'
                        + '<div class="je_key_colon"></div>'
                    + '</td>'
                    + '<td class="je_panel_right">'
                        + je_get_value_field(value, ((node_type && node_type.value_attribute)? schema.structure_attributes[node_type.value_attribute] : ''))
                    + '</td>'
                + '</tr>'
            + '</table>'
            ;
        }
        
        item += '</div>'
    
    } else { // array

        var item = '<div class="je_list_item">';
        
        if (typeof value === 'object' || value.constructor === Array) {
            item += ''
                + '<table class="je_panel_container">'
                    + '<tr>'
                        + '<td class="je_panel_left">'
                            + '<div class="je_option_button je_option_button_draggable" onclick="je_option_click(this)"></div>'
                        + '</td>'
                    + '</tr>'
                + '</table>'
            ;
            item += je_get_html(value, schema, ((node_type && node_type.value_attribute)? schema.structure_attributes[node_type.value_attribute] : ''), create_new);
        } else {
            item += ''
                + '<table class="je_panel_container">'
                    + '<tr>'
                        + '<td class="je_panel_right">'
                            + '<div class="je_option_button je_option_button_draggable" onclick="je_option_click(this)"></div>'
                                + je_get_value_field(value, ((node_type && node_type.value_attribute)? schema.structure_attributes[node_type.value_attribute] : ''))
                        + '</td>'
                    + '</tr>'
                + '</table>'
            ;
        }
        
        item += '</div>';
        
    }
    
    return item;
}


function je_get_json(container, no_recursion){
    if (container.attr('data-je-list-type') == 'object') {
        var data = {};
        container.find(' > .je_list_container > .je_list_item').each(function(){
            var list_item = $(this);
            var key = list_item.find('> .je_panel_container .je_key').val();
            if (key) {
                key = key.trim();
                if (key) {
                    var list_container_wrap = list_item.find('> .je_list_container_wrap');
                    var value = '';
                    if (list_container_wrap && list_container_wrap.length) {
                        if (!no_recursion) {
                            value = je_get_json(list_container_wrap);
                        }
                    } else {
                        var value_node = list_item.find('> .je_panel_container .je_value');
                        if (value_node.hasClass('je_value_checkbox')) {
                            if (value_node.is(":checked")) {
                                value = '1'
                            } else {
                                value = '0';
                            }
                        } else {
                            value = value_node.val();
                        }
                    }
                    data[key] = value;
                }
            }
        });
        
    } else {
        var data = [];
        container.find('> .je_list_container > .je_list_item').each(function(){
            var list_item = $(this);
            var list_container_wrap = list_item.find('> .je_list_container_wrap');
            var value = '';
            if (list_container_wrap.length) {
                if (!no_recursion) {
                    value = je_get_json(list_container_wrap);
                }
            } else {
                var value_node = list_item.find('> .je_panel_container .je_value');
                if (value_node.hasClass('je_value_checkbox')) {
                    if (value_node.is(":checked")) {
                        value = '1';
                    } else {
                        value = '0';
                    }
                } else {
                    value = value_node.val();
                }
            }
            data.push(value);
        });
        
    }
    
    return data;
}


function je_get_value_field(value, attr){
    var field = '';
    if (attr) {
        if(attr.data_type == 'boolean'){
            var checked = false;
            if (typeof value != 'undefined') {
                if(parseInt(value)) {
                    checked = true;
                }
            } else if (attr.default_value) {
                checked = true;
            }
            field = '<input type="checkbox" class="je_value je_value_checkbox"' + ((checked)? ' checked' : '') + '>';
            
        } else if (attr.validation == 'html') {
            var field_value = '';
            if (typeof value != 'undefined') {
                field_value = value;
            } else  if (attr.default_value) {
                field_value = attr.default_value;
            }
            field = '<textarea class="je_value ckeditor" placeholder="value">' + field_value + '</textarea>';
            
        } else if (attr.data_type.substr(0,4) == 'text') {
            var field_value = '';
            if (typeof value != 'undefined') {
                field_value = value;
            } else  if (attr.default_value) {
                field_value = attr.default_value;
            }
            field = '<textarea class="je_value je_value_big" placeholder="value">' + field_value + '</textarea>';
            
        } else {
            var field_value = '';
            if (typeof value != 'undefined') {
                field_value = value;
            } else  if (attr.default_value) {
                field_value = attr.default_value;
            }
            field = '<textarea class="je_value je_value_small" placeholder="value">' + field_value + '</textarea>';
        }
    } else if (typeof value != 'undefined') {
        if (('' + value).toString().length > 100) {
            field = '<textarea class="je_value je_value_big" placeholder="value">' + value + '</textarea>';
        } else {
            field = '<textarea class="je_value je_value_small" placeholder="value">' + value + '</textarea>';
        }
    } else {
        field = '<textarea class="je_value je_value_small" placeholder="value"></textarea>';
    }
    return field;
}

function je_get_left_node_types(data, attr) {
    var nodes = [];
    if (attr && attr.structure_nodes.length) {
        if (Object.getPrototypeOf( data ) === Object.prototype) {
            var data_keys = Object.keys(data);
            for(var i = 0; i < attr.structure_nodes.length; i++) {
                if (attr.structure_nodes[i].key_name && data_keys.indexOf(attr.structure_nodes[i].key_name) == -1) {
                    nodes.push(attr.structure_nodes[i]);
                }
            }
            // checking keyless node type
            for(var i = 0; i < attr.structure_nodes.length; i++) {
                if (!attr.structure_nodes[i].key_name && (attr.structure_nodes[i].max_instances == 0 || attr.structure_nodes[i].max_instances > (data_keys.length - nodes))) {
                    nodes.push(attr.structure_nodes[i]);
                }
            }
            
        } else  {
            if(attr.structure_nodes[0].max_instances == 0 || attr.structure_nodes[0].max_instances > data.length ) {
                nodes.push(attr.structure_nodes[0]);
            }
        }
    } else {
        nodes = [
            {
                key_name: '',
                value_attribute: '',
                type: 'value',
                min_instances: '0',
                max_instances: '0',
                relative_position: ''
            },
            {
                key_name: '',
                value_attribute: '',
                type: 'array',
                min_instances: '0',
                max_instances: '0',
                relative_position: ''
            },
            {
                key_name: '',
                value_attribute: '',
                type: 'object',
                min_instances: '0',
                max_instances: '0',
                relative_position: ''
            }
        ];
    }
    return nodes;
}

function je_option_click(ele) {
    var self = $(ele);
    var option_menu = self.find('.je_option_menu');
    if (option_menu.length) {
        option_menu.remove();
    } else {
        if (self.hasClass('je_option_button_main')) {
            
        } else {
            var list_container_wrap = self.parents('.je_list_container_wrap').first();
            var json = je_get_json(list_container_wrap);
            var schema_str = self.parents('.je_main_container').first().find('.je_json_schema').val();
            if (schema_str.trim()) {
                var schema = JSON.parse(schema_str);
            }
            var attr_name = list_container_wrap.attr('data-je-attr-name');
            if (schema && attr_name) {
                if (attr_name == 'main_attr') {
                    var attr = schema;
                } else {
                    var attr = schema.structure_attributes[attr_name];
                }
            }
            var node_types = je_get_left_node_types(json,attr);
            
            var menu_html = '<div class="je_option_menu"><ul>';
            
            for(var i = 0; i < node_types.length; i++) {
                if (node_types[i].key_name) {
                    menu_html += '<li onclick="' + encode_html_special_chars('je_option_item_click(this, \'insert\',' + JSON.stringify(node_types[i]) + ')') + '">' + node_types[i].key_name + '</li>';
                } else if (node_types[i].value_attribute) {
                    menu_html += '<li onclick="' + encode_html_special_chars('je_option_item_click(this, \'insert\',' + JSON.stringify(node_types[i]) + ')') + '">' + node_types[i].value_attribute + '</li>';
                } else if (node_types[i].type) {
                    menu_html += '<li onclick="' + encode_html_special_chars('je_option_item_click(this, \'insert\',' + JSON.stringify(node_types[i]) + ')') + '">' + node_types[i].type + '</li>';
                }
            }
            
            if (!self.hasClass('je_option_button_last')) {
                menu_html += '<li onclick="' + encode_html_special_chars('je_option_item_click(this, \'remove\')') + '">' + 'remove' + '</li>';
            }
            
            menu_html += '</ul></div>';
            self.append(menu_html);
            
        }
    }
}

function je_option_item_click(ele, operation, node_type){
    var self = $(ele);
    if (operation == 'remove') {
        
        self.parents('.je_list_item').first().remove();
        
        
        var list_container_wrap = self.parents('.je_list_container_wrap').first();
        
        var schema = '';
        var list_attr = '';
        var schema_str = list_container_wrap.parents('.je_main_container').first().find('.je_json_schema').val();
        if (schema_str && schema_str.trim()) {
            schema = JSON.parse(schema_str);
            var list_attr_name = list_container_wrap.attr('data-je-attr-name');
            if (schema && list_attr_name) {
                if (list_attr_name == 'main_attr') {
                    list_attr = schema;
                } else {
                    list_attr = schema.structure_attributes[list_attr_name];
                }
            }
        }
        
        var list_data = je_get_json(list_container_wrap, true);
        
        var left_nodes = je_get_left_node_types(list_data, list_attr)
        
        if (left_nodes.length == 0) {
            list_container_wrap.find('> .je_panel_container').hide();
        } else {
            list_container_wrap.find('> .je_panel_container').show();
        }
        
    } else if (operation == 'insert') {
        var list_container_wrap = self.parents('.je_list_container_wrap').first();
        
        
        
        if (!self.parents('.je_option_button').first().hasClass('je_option_button_last')) {
            var list_item = self.parents('.je_list_item').first();
            var list_item_node = list_item[0];
            var list_container_wrap_node = list_container_wrap.find('> .je_list_container')[0];
            var node_list = Array.prototype.slice.call( list_container_wrap_node.children );
            var index = node_list.indexOf(list_item_node);
        } else {
            var index = 'last';
        }
        
        je_create_new_node(list_container_wrap, node_type, index);
        
        je_replace_ckeditor();
    }
    
    je_init_sortable();
}

function je_create_new_node(container, node_type, index) {
    var list_type = container.attr('data-je-list-type');
    var schema = '';
    var list_attr = '';
    var schema_str = container.parents('.je_main_container').first().find('.je_json_schema').val();
    if (schema_str && schema_str.trim()) {
        schema = JSON.parse(schema_str);
        var list_attr_name = container.attr('data-je-attr-name');
        if (schema && list_attr_name) {
            if (list_attr_name == 'main_attr') {
                list_attr = schema;
            } else {
                list_attr = schema.structure_attributes[list_attr_name];
            }
        }
    }
    
    var value = '';
    var value_attr = '';
    
    if (schema && node_type.value_attribute) {
        value_attr = schema.structure_attributes[node_type.value_attribute];
    }
    
    if (node_type.type == 'object' || (value_attr && value_attr.data_type_details.type == 'json_object')) {
        value = {};
    } else if (node_type.type == 'array' || (value_attr && value_attr.data_type_details.type == 'json_array')) {
        value = [];
    }
    
    
    
    var node_html = je_get_node_html(node_type.key_name, value, schema, node_type, list_type, true)
    
    
    if (index == 'last') {
        container.find('> .je_list_container').append(node_html);
    } else {
        container.find('> .je_list_container > .je_list_item').eq(index).before(node_html);
    }
    
    
    var list_data = je_get_json(container, true);
    
    var left_nodes = je_get_left_node_types(list_data, list_attr)
    
    if (left_nodes.length == 0) {
        container.find('> .je_panel_container').hide();
    } else {
        container.find('> .je_panel_container').show();
    }
    
}
