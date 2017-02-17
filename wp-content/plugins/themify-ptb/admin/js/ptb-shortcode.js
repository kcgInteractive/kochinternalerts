(function () {
    if (shortcodes_button && shortcodes_button.length > 0) {

        tinymce.PluginManager.add('ptb', function (editor, url) {
            var $items = [];
            for (var k in shortcodes_button) {

                var $item = {
                    'text': shortcodes_button[k].name,
                    'body': {
                        'type': shortcodes_button[k].type,
                        //   'style':$arhive.ptb_ptt_layout_post
                    },
                    onclick: function (e) {
                        var $settings = this.settings.body;

                        jQuery.ajax({
                            url: $_url,
                            type: 'POST',
                            dataType: 'json',
                            data: {'post_type': $settings.type},
                            success: function (resp) {
                                if (resp) {
                                    var post_data = [];
                                    var $data = resp.data;
                                    for (var $key in $data) {

                                        var $form_items  = {
                                            'label': $data[$key].label,
                                            'name': $key,
                                            'values': $data[$key].values ? $data[$key].values : '',
                                            'value': $data[$key].value,
                                            'type': $data[$key].type
                                      
                                        };
                                        post_data.push($form_items);
                                    }
                                    if (resp.taxes) {
                                        for (var i in resp.taxes) {
                                            var $list,
                                                $values = {};
                                            $list = {
                                                'label': resp.taxes[i].label,
                                                'values': [],
                                                'type': 'listbox',
                                                'name': 'ptb_tax_' + resp.taxes[i].name
                                            };
                                            $list.values.push({
                                                'text': '---',
                                                'value': false
                                            });
                                            for (var $i in resp.taxes[i].values) {
                                                $list.values.push({
                                                    'text': resp.taxes[i].values[$i].name,
                                                    'value': resp.taxes[i].values[$i].slug
                                                });
                                            }
                                            post_data.push($list);
                                        }
                                    }
                                    editor.windowManager.open({
                                        'body': post_data,
                                        //'title':resp.title,
                                        onsubmit: function (e) {
                                            var $short = '[ptb type="' + $settings.type + '"';
                                            for (var $k in e.data) {
                                                if (e.data[$k]) {
                                                    $short += ' ' + $k + '="' + e.data[$k] + '"';
                                                }
                                            }
                                            $short += ']';
                                            editor.insertContent($short);
                                        }
                                    });
                                }
                            },
                        });
                    },
                    /*
                     onclick: function(e) {
                     var $settings = this.settings.body;
                     var $short = '[ptb ';
                     for(var $k in $settings){
                     $short+=' '+$k+'="'+$settings[$k]+'"';
                     }
                     $short+=']';
                     editor.insertContent($short);
                     }
                     */
                }
                $items.push($item);
            }
            editor.addButton('ptb', {
                icon: 'ptb-favicon',
                type: 'menubutton',
                title: 'PTB Shortcodes',
                menu: $items
            });
        });
    }
})();