;
var PTB;
(function ($, window, document, undefined) {

    'use strict';

    // Builder Function
    PTB = {
        prefix: 'ptb_',
        ptb_cmb_image_file_frame: false,
        init: function () {
            this.Undelegate();
            this.bindEvents();
        },
        Undelegate: function () {
            $(document).off('*','.'
                + PTB.prefix + 'column_select, .'
                + PTB.prefix + 'toggle_row, .'
                + PTB.prefix + 'toggle_module, .'
                + PTB.prefix + 'delete_module, .'
                + PTB.prefix + 'back_text input:radio, .'
                + PTB.prefix +  'grid_list_wrapper, .'
                + PTB.prefix + 'add_row').unbind();
        },
        bindEvents: function () {
            this.SelectGrid();
            this.InitDraggable();
            this.InitSortable();
            this.DisableSort();;
            this.Open();
            this.AddRow();
            this.Delete();
            this.Save();
            this.Validate();
            this.ShowHideSeperator();
            this.InitTMCE();
            this.InitDefaultContent();
            InitLanguageTabs();
        },
        SelectGrid: function () {

            $(document).on('click', '.' + PTB.prefix + 'column_select', function (e) {
                e.preventDefault();
                $(this).closest('.' + PTB.prefix + 'grid_list_wrapper')
                    .find('li.selected')
                    .removeClass('selected');
                $(this).closest('li').addClass('selected');
                var $grid = '"' + $(this).data('grid') + '"';
                $grid = JSON.parse($grid).split(',');
                var $row = $(this).closest('.' + PTB.prefix + 'back_row');
                var $col = $row.find('.' + PTB.prefix + 'back_col');
                $col.removeAttr('class').addClass(PTB.prefix + 'back_col').hide();
                var $module = $row.find('.' + PTB.prefix + 'back_module');
                var length = $grid.length;
                var $module_length = $module.length;
                var $block_length = $module_length > length ? Math.ceil($module_length / length) : 1;
                var editors = [];
                if ($module.length > 0) {
                    var $editors = $module.find('.wp-editor-area');
                    if ($editors.length > 0) {
                        $editors.each(function () {
                            var edit_id = $(this).attr('id');
                            if (tinyMCEPreInit.mceInit[edit_id]) {
                                editors[edit_id] = PTB.GetEditorContent(edit_id);
                            }
                        });
                    }
                }
                for (var i = 0; i < length; i++) {
                    var item = $($col[i]);
                    var classes = PTB.prefix + 'col' + $grid[i];
                    item.attr('data-grid', $grid[i]);
                    if (i == 0) {
                        classes += ' first';
                    }

                    if ($module.length > 0) {
                        var $holder = item.find('.' + PTB.prefix + 'module_holder').first();
                        $holder.find('.' + PTB.prefix + 'back_module').remove();
                        for (var j = 0; j < $block_length; j++) {
                            if (!$module[j]) {
                                break;
                            }
                            $holder.append($module[j]);
                        }

                        $module.splice(0, $block_length);
                    }
                    item.addClass(classes).show();
                }
                for (var $id in editors) {

                    if (tinyMCEPreInit.mceInit[$id]) {
                        tinymce.execCommand('mceRemoveEditor', false, $id);
                        $('#' + $id).ptb_wp_editor();
                        tinymce.execCommand('mceAddEditor', false, $id);
                        PTB.SetEditorContent($id, editors[$id]);
                    }
                }

            });
            if ($('.' + PTB.prefix + 'grid_list li.selected').length == 0) {
                $('.' + PTB.prefix + 'column_select').first().trigger('click');
            }
            else {
                $('.' + PTB.prefix + 'back_row_content .' + PTB.prefix + 'back_col[data-grid]').show();
                this.PlaceHoldDragger();
                PTB.Unique($('#' + PTB.prefix + 'row_wrapper .' + PTB.prefix + 'active_module'));
                var $editor = $('#' + PTB.prefix + 'row_wrapper .' + PTB.prefix + 'wp_editor');
                $editor.each(function () {
                    var $id = PTB.GenerateUnique();
                    $(this).attr('id', $id).ptb_wp_editor();
                    if (tinyMCEPreInit.mceInit[$id]) {//tinemcse hack for dom change
                        tinymce.execCommand('mceAddEditor', false, $id);
                    }
                });

            }
        },
        PlaceHoldDragger: function () {
            $('.' + PTB.prefix + 'module_holder').each(function () {
                var $empty = $(this).find('.' + PTB.prefix + 'empty_holder_text');
                if ($(this).find('.' + PTB.prefix + 'active_module').length == 0) {
                    $empty.show();
                }
                else {
                    $empty.hide();
                }
            });
        },
        equalHeight: function ($row) {
            var $col = $row.find('.' + PTB.prefix + 'back_col:visible');
            if ($col.length > 1) {
                $col.css('min-height', 'initial');
                var height = $($col[0]).height();
                $col.each(function () {
                    if ($(this).height() > height) {
                        height = $(this).height()
                    }
                });
                $col.css('min-height', height);
            }
        },
        InitDraggable: function () {
            $('.' + PTB.prefix + 'back_module_panel .' + PTB.prefix + "back_module").draggable({
                appendTo: "body",
                helper: "clone",
                revert: 'invalid',
                snapMode: "inner",
                connectToSortable: '.' + PTB.prefix + "module_holder",
                stop: function (event, ui) {
                    var $item = $(ui.helper[0]);
                    PTB.Unique($item);
                    if ($item.data('type') == 'custom_text') {
                        var $wp_editors = $item.find('textarea.' + PTB.prefix + 'wp_editor');
                        $wp_editors.each(function () {
                            var $id = PTB.GenerateUnique();
                            $(this).attr('id', $id);
                            $('#' + $id).ptb_wp_editor();
                             setTimeout(function(){
                                $('#wp-' + $id + '-wrap').find('.switch-html').trigger('click');
                                },1200);
                           
                        });
                    }
                    $item.find('.'+PTB.prefix+'toggle_module').trigger('click');
                }
            });
        },
        InitSortable: function () {
            $('.' + PTB.prefix + "module_holder").sortable({
                placeholder: PTB.prefix + 'ui_state_highlight',
                items: '.' + PTB.prefix + 'back_module',
                connectWith: '.' + PTB.prefix + "module_holder",
                cursor: 'move',
                revert: 100,
                sort: function (event, ui) {
                    var placeholder_h = ui.item.outerHeight();
                    $('.' + PTB.prefix + 'module_holder ' + '.' + PTB.prefix + 'ui_state_highlight').height(placeholder_h);
                },
                receive: function (event, ui) {
                    PTB.PlaceHoldDragger();
                    $(this).parent().find('.' + PTB.prefix + 'empty_holder_text').hide();
                },
                start: function (event, ui) {
                    var $item = $(ui.item);
                    var $wp_editors = $item.removeClass(PTB.prefix + 'dragged').find('textarea.' + PTB.prefix + 'wp_editor');
                    $wp_editors.each(function () {
                        var $id = $(this).attr('id');
                        if (tinyMCEPreInit.mceInit[$id]) { //tinemcse hack for dom change
                            tinymce.execCommand('mceRemoveEditor', false, $id);
                        }
                    });

                },
                stop: function (event, ui) {
                    var $item = $(ui.item);
                    $item.addClass(PTB.prefix + 'dragged');
                    PTB.equalHeight($item.closest('.' + PTB.prefix + 'back_row'));
                    var $wp_editors = $item.find('textarea.' + PTB.prefix + 'wp_editor');
                    $wp_editors.each(function () {
                        var $id = $(this).attr('id');
                        if (tinyMCEPreInit.mceInit[$id]) { //tinemcse hack for dom change
                            tinymce.execCommand('mceAddEditor', false, $id);
                            PTB.ActiveEdiror($id);
                        }
                    });


                }
            });

            $('#' + PTB.prefix + 'row_wrapper').sortable({
                items: '.' + PTB.prefix + 'back_row',
                handle: '.' + PTB.prefix + 'back_row_top',
                axis: 'y',
                placeholder: PTB.prefix + 'ui_state_highlight',
                sort: function (event, ui) {
                    var placeholder_h = ui.item.height();
                    $('#' + PTB.prefix + 'row_wrapper .' + PTB.prefix + 'ui_state_highlight').height(placeholder_h);
                }
            });

        },
        Open: function () {
            $(document).on('click', '.' + PTB.prefix + 'toggle_module,.' + PTB.prefix + 'toggle_row', function (e) {
                var $container = $(this).closest('.' + PTB.prefix + 'active_module').length == 0 ?
                    $(this).closest('.' + PTB.prefix + 'back_row').find('.' + PTB.prefix + 'back_row_content')
                    : $(this).closest('.' + PTB.prefix + 'active_module').find('.' + PTB.prefix + 'back_active_module_content');

                var $col = $container.closest('.' + PTB.prefix + 'back_col');
                var activeColSelector = '.' + PTB.prefix + 'back_col[data-grid][class~="' + PTB.prefix + 'back_col"][class*="' + PTB.prefix + 'col"]';

                if ($(this).hasClass(PTB.prefix + 'opened') || $container.is(':visible')) {
                    $(this).removeClass(PTB.prefix + 'opened');

                    if ($col.length>0 && $col.find('.' + PTB.prefix + 'opened').length == 0) {
                        $col.removeClass('shadow', 400, function () {
                            $container.slideUp(400, function () {
                                $col.removeClass('fill', 400, 'swing', function () {
                                    $col.removeClass('fill');
                                    $col.siblings(activeColSelector).show(400);
                                    $col.find('.' + PTB.prefix + 'delete_module').show();
                                    $('.' + PTB.prefix + "module_holder").sortable('enable');
                                });
                            });
                        });
                    } else {;
                        $container.slideUp();
                    }
                }
                else {
                    $(this).addClass(PTB.prefix + 'opened');
                    if ($col.length>0 && $col.siblings(activeColSelector).length != 0) {
                        $col.siblings(activeColSelector).hide(400, function () {
                            $col.addClass('fill');
                            $col.find('.' + PTB.prefix + 'delete_module').hide();
                            $container.slideDown(400, function () {
                                $col.addClass('shadow');
                                $('.' + PTB.prefix + "module_holder").sortable('disable');
                            });
                        });
                    } else {
                        $container.slideDown();
                    }
                }
                e.preventDefault();
            });
        },
        Delete: function () {
            $(document).on('click', '.' + PTB.prefix + 'delete_module', function (e) {

                var $container = $(this).closest('.' + PTB.prefix + 'active_module').length == 0 ?
                    $(this).closest('.' + PTB.prefix + 'back_row')
                    : $(this).closest('.' + PTB.prefix + 'back_module');
                var $row = $container.closest('.' + PTB.prefix + 'back_row');
                $container.remove();
                if ($row.length > 0) {

                    PTB.PlaceHoldDragger();
                    PTB.equalHeight($row);
                }
                e.preventDefault();
            });
        },
        AddRow: function () {
            $(document).on('click', '.' + PTB.prefix + 'add_row', function (e) {
                var $row = $('.' + PTB.prefix + 'first_row').first().clone();
                $row.removeClass(PTB.prefix + 'first_row').find('.' + PTB.prefix + 'back_module').remove();
                $row.find('.' + PTB.prefix + 'empty_holder_text').show();
                $row.find('.' + PTB.prefix + 'back_col').css('min-height', 'initial');
                $('.' + PTB.prefix + 'back_row').last().after($row);
                $row.find('.' + PTB.prefix + 'column_select').first().trigger('click');
                e.preventDefault();
                PTB.InitSortable();
            });
        },
        Save: function () {
            $('#' + PTB.prefix + 'lightbox_container form').submit(function (event) {
                var $openedCols = $('.ptb_toggle_module.ptb_opened');
                var interval = 0;
                if ($openedCols.length > 0) {
                    $openedCols.click();
                    interval = 1500;
                }

                var $form = $(this);
                var $inputs = $('.' + PTB.prefix + 'back_builder').find('input,select,textarea');
                $inputs.attr('disabled', 'disabled');//this data no need

                setTimeout(function () {
                    var $data = JSON.stringify(PTB.ParseData());
                    $('#' + PTB.prefix + 'layout').val($data);
                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        dataType: 'json',
                        data: $form.serialize(),
                        beforeSend: function () {
                            $form.addClass(PTB.prefix + 'wait');
                        },
                        complete: function () {
                            $inputs.removeAttr('disabled');
                            $form.removeClass(PTB.prefix + 'wait');
                        },
                        success: function (res) {
                            if (res && res.status == '1') {
                                $('#' + PTB.prefix + 'success_text').html('<p><strong>' + res.text + '</strong></p>').show();
                                setTimeout(function () {
                                  //  $('.' + PTB.prefix + 'close_lightbox').trigger('click');
                                    $('#' + PTB.prefix + 'success_text').html('').hide();
                                }, 2000);
                            }
                        }
                    });
                }, interval);
                event.preventDefault();
            });
        },
        Validate: function () {
            var $ppp = $('input[name="ptb_ptt_offset_post"]');

            $ppp.keypress(function (event) {
                if ($(this).val().length > 0) {
                    return /^[0-9]*$/.test(String.fromCharCode(event.keyCode));
                } else {
                    return /^[1-9]*$/.test(String.fromCharCode(event.keyCode));
                }
            });

            $('input[name="' + PTB.prefix + 'ptt_pagination_post"]').change(function (e) {
                if ($(this).val() == 0) {
                    $ppp.attr('disabled', 'disabled');
                } else {
                    $ppp.removeAttr('disabled');
                }
            });
        },
        ParseData: function () {
            var $wrapper = $('#' + PTB.prefix + 'row_wrapper');
            var $rows = $wrapper.find('.' + PTB.prefix + 'back_row');
            var $data = {};
            $rows.each(function (i) {//each rows
                $data[i] = {};
                var $col = $(this).find('.' + PTB.prefix + 'back_col:visible');
                $col.each(function (k) {//each column in row
                    var $grid = $(this).attr('data-grid');//because $(this).data is caching
                    var $key = $grid + '-' + k;//because key can match e.g 1-2,3-1,3-1
                    $data[i][$key] = {};
                    var $modules = $(this).find('.' + PTB.prefix + 'back_active_module_content');
                    $modules.each(function (j) {//each module in colum
                        var $type = $(this).data('type');
                        $data[i][$key][j] = {};
                        $data[i][$key][j]['type'] = $type;
                        var $inputs = $(this).find('input:checked,input[type="text"],input[type="hidden"],textarea,select');
                        $inputs.each(function () {//all input in module
                            var $name = $(this).attr('name');
                            if ($name) {
                                var $tmp_match = $name.split(']');
                                if ($tmp_match) {
                                    $tmp_match.pop();
                                    var $match = [];
                                    for (var $m in $tmp_match) {
                                        var $vals = $tmp_match[$m].split('[');
                                        if ($vals[1]) {
                                            $match[$m] = $vals[1];
                                        }
                                    }
                                    $data[i][$key][j]['key'] = $match[0];
                                    if (!$data[i][$key][j][$match[1]] || $match[2]) {//for multiple items e.g checkboxes
                                        if ($match[2]) {
                                            var $lng = $match[2];
                                            if (typeof $data[i][$key][j][$match[1]] != 'object') {
                                                $data[i][$key][j][$match[1]] = {};
                                            }
                                            $data[i][$key][j][$match[1]][$lng] = $type != 'custom_text' ? $(this).val() : PTB.GetEditorContent($(this).attr('id'));
                                        }
                                        else {
                                            $data[i][$key][j][$match[1]] = $(this).val() == 'on' ? true : $(this).val();
                                        }
                                    }
                                    else {
                                        if (typeof $data[i][$key][j][$match[0]] != 'object') {
                                            var $first_val = $data[i][$key][j][$match[1]];
                                            $data[i][$key][j][$match[1]] = {};
                                            $data[i][$key][j][$match[1]][0] = $first_val;
                                        }
                                        $data[i][$key][j][$match[1]].push($(this).val());
                                    }
                                }
                            }
                        });
                    });

                });
            });
            
            return $data;
        },
        Unique: function ($module) {
            $module.each(function () {
                var $m = $(this);
                var $labels = $m.find('label');
                $labels.each(function () {
                    var $id = $(this).attr('for');
                    if ($id) {
                        $id = PTB.Escape($(this).attr('for'));
                        if ($('#' + $id).length > 0) {
                            var $uniqud = PTB.GenerateUnique();
                            $m.find('#' + $id).attr('id', $uniqud);
                            $(this).attr('for', $uniqud);
                        }
                    }
                });
                var $reg = /.*?\[(.+?)\]/ig;
                var $input = $m.find('input[type="radio"]');

                $input.each(function () {
                    var $name = $(this).attr('name');
                    if ($name) {
                        var $match = $name.match($reg);
                        if ($match) {
                            var $uniqeuname = PTB.GenerateUnique();
                            var $radio = $m.find('input:radio[name="' + $name + '"]');//if there are several groups radio
                            var $new_name = $uniqeuname + $match[0] + $match[1];
                            $radio.attr('name', $new_name);
                            if ($m.find('input:radio[name!="' + $name + '"]')) {//if empty
                                $m.find('input:radio[name="' + $new_name + '"][checked]').prop('checked', true);//to display checked;
                                return false;
                            }
                        }
                    }
                });
            });
        },
        GenerateUnique: function () {
            return PTB.prefix + Math.random().toString(36).substr(2, 9);
        },
        Escape: function ($selector) {
            return $selector.replace(/(:|\.|\[|\]|,)/g, "\\$1");
        },
        GetEditorContent: function ($id) {
            return $('#wp-' + $id + '-wrap').hasClass('tmce-active') ? tinyMCE.get($id).getContent() : $('#' + $id).val();
        },
        SetEditorContent: function ($id, $content) {
            if (!$content) {
                $content = '';
            }
            tinymce.get($id).setContent($content);
            $('#' + $id).val($content);
        },
        ActiveEdiror: function ($id) {

            var $wrap = $('#wp-' + $id + '-wrap');
            if ($wrap.hasClass('html-active')) {
                $wrap.find('.switch-html').trigger('click');
            }
            else {

                $wrap.find('.switch-tmce').trigger('click');
            }
        },
        ImageUpload: function (e) {

            // If the media frame already exists, reopen it.
            if (PTB.ptb_cmb_image_file_frame) {
                PTB.ptb_cmb_image_file_frame.open();
                return;
            }

            PTB.ptb_cmb_image_file_frame = wp.media.frames.file_frame = wp.media({
                title: $(this).data('uploader_title'),
                button: {
                    text: $(this).data('uploader_button_text')
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            PTB.ptb_cmb_image_file_frame.on('select', function () {
                var attachment = PTB.ptb_cmb_image_file_frame.state().get('selection').first().toJSON();
                $(e).prev().val(attachment.url);
                $('.ptb_post_image_thumb').css('background-image', 'url(' + attachment.url + ')');
            });

            // Finally, open the modal
            PTB.ptb_cmb_image_file_frame.open();
        },
        DisableSort:function(){
           $(document).on("mouseenter",'.'+PTB.prefix+'grid_list_wrapper',function(){
                $('#' + PTB.prefix + 'row_wrapper').sortable( "disable" );
             
            }).on("mouseleave", '.'+PTB.prefix+'grid_list_wrapper', function(){
                $('#' + PTB.prefix + 'row_wrapper').sortable( "enable" );
           });
        },
        ShowHideSeperator:function(){
            $(document).on('change','.'+PTB.prefix+'back_text input:radio',function(){
                var $seperator = $(this).closest('.'+PTB.prefix+'back_active_module_row').next('div');
                if($(this).val()=='one_line'){
                    $seperator.slideDown();
                }
                else{
                    $seperator.slideUp();
                }
            });
            $('.'+PTB.prefix+'back_text input:radio:checked').trigger('change');
        },
        InitTMCE:function(){
            setTimeout(function(){
                    $('.switch-html').trigger('click');
            },1200);
        },
        InitDefaultContent:function(){
            if($('.'+PTB.prefix+'new-themplate').length>0){
                var title = jQuery('#'+PTB.prefix+'cmb_title').clone();
                var content = jQuery('#'+PTB.prefix+'cmb_editor').clone();
                $('.'+PTB.prefix+'back_col.first .'+PTB.prefix+'module_holder')
                .append(title)
                .append(content).find('.'+PTB.prefix+'empty_holder_text').hide();
            }
        }


    };

}(jQuery, window, document));
