// �������� �����
$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});


/**
 * Notification
 * @param {string} message ����� ���������
 * @@param {string} danger ����� ������ ������
 * @param {bool} hide ��������� �������� ���������
 */
function showAlertMessage(message, danger, hide) {

    if (typeof danger != 'undefined') {
        if (danger === true)
            danger = 'danger';
        $('.success-notification').find('.alert').addClass('alert-' + danger);
    }
    else {
        $('.success-notification').find('.alert').removeClass('alert-danger');
        $('.success-notification').find('.alert').removeClass('alert-info');
    }

    var messageBox = '.success-notification';

    var innerBox = '#notification .notification-alert';

    if ($(messageBox).length > 0) {
        $(messageBox).removeClass('hide');
        $(innerBox).html(message);
        $(messageBox).fadeIn('slow');

        if (typeof hide == 'undefined') {
            setTimeout(function() {
                $(messageBox).delay(500).fadeOut(1000);
            }, 5000);
        }
    }
}


// �������������� ������� ��������
var trans = [];
for (var i = 0x410; i <= 0x44F; i++)
    trans[i] = i - 0x350; // �-��-�
trans[0x401] = 0xA8;    // �
trans[0x451] = 0xB8;    // �

// ������� �������� �� ����������/����������
trans[0x457] = 0xBF;    // �
trans[0x407] = 0xAF;    // �
trans[0x456] = 0xB3;    // �
trans[0x406] = 0xB2;    // �
trans[0x454] = 0xAA;    // �
trans[0x404] = 0xBA;    // �

// ��������� ����������� ������� escape()
var escapeOrig = window.escape;

// �������������� ������� escape()
window.escape = function(str)
{
    var str = String(str);
    var ret = [];
    // ���������� ������ ����� ��������, ������� ��������� ���������
    for (var i = 0; i < str.length; i++)
    {
        var n = str.charCodeAt(i);
        if (typeof trans[n] != 'undefined')
            n = trans[n];
        if (n <= 0xFF)
            ret.push(n);
    }
    return escapeOrig(String.fromCharCode.apply(null, ret));
};



$().ready(function() {

    // ����� � FAQ
    $("#search").on('input', function() {
        var words = $(this).val();

        if (words.length > 2) {
            $.ajax({
                type: "POST",
                url: "./search/search.php",
                data: {
                    words: escape(words)
                },
                success: function(data)
                {
                    // ��������� ������
                    if (data != 'false') {

                        if (data != $("#search").attr('data-content')) {
                            $("#search").attr('data-content', data);

                            $("#search").popover('show');
                        }
                    } else
                        $("#search").popover('hide');
                }
            });
        }
        else {
            $("#search").popover('hide');
        }
    });

    // ���������� ��������� ������
    $('body').on('change', '#presentation-check', function() {
        $.cookie('presentation', this.checked, {
            path: '/',
            expires: 365
        });
    });

    // ����� ��������� ������
    $('#presentation-select').on('click', function(event) {
        event.preventDefault();
        $('#selectModal .modal-dialog').removeClass('modal-lg');
        $('#selectModal .modal-title').html(locale.presentation_title);
        $('#selectModal .modal-footer .btn-delete').addClass('hidden');
        $('#selectModal .modal-footer .btn-primary').addClass('hidden');
        $('#selectModal .modal-footer [data-dismiss="modal"]').text(locale.close);
        $('#selectModal .modal-body').html($('#presentation').html());
        $('#selectModal').modal('show');
    });

    // �����
    $('.back').on('click', function(event) {
        event.preventDefault();

        if ($.getUrlVar('frame') !== undefined) {
            parent.window.$('#adminModal').modal('hide');
        } else
            history.back(1);
    });

    // �������� ������
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        }

        var id = $(this).attr('data-target');

        $('[data-icon="' + id + '"]').html(log);
        $("input[name='" + id + "']").val('/UserFiles/Image/' + log);
        $('[data-icon="' + id + '"]').prev('.glyphicon').removeClass('hide');
        showAlertMessage(locale.icon_load, 'info');
    });

    // ���� URL ������
    $('body').on('click', '#promtUrl', function() {
        var file = prompt('URL');
        var id = $(this).attr('data-target');

        if (file.length > 0) {
            $('[data-icon="' + id + '"]').html(file);
            $('[data-icon="' + id + '"]').prev('.glyphicon').removeClass('hide');
            $("input[name='" + id + "']").val(file);
            $('[data-thumbnail="' + id + '"]').attr('src', file);
            $("input[name=img_new]").val(file);
            $("input[name=furl]").val(1);
        }
    });

    // �������� ������
    $('body').on('click', '.remove', function() {
        $(this).next('span').html(locale.select_file);
        $(this).toggleClass('hide');
        $(this).closest('.form-group').find(".img-thumbnail").attr('src', './images/no_photo.gif');
        $("input[name=" + $(this).attr('data-return') + "]").val('');
    });

    // ������ �� ������
    $(".link-thumbnail").on('click', function(event) {
        event.preventDefault();
        var src = $(this).find('.img-thumbnail').attr('src');
        if (src != 'images/no_photo.gif')
            window.open(src);
    });

    // ����-�������� elfinder
    $('#elfinderModal').on('show.bs.modal', function(event) {
        $('.elfinder-modal-content').attr('data-option', $(event.relatedTarget).attr('data-return'));
        var path = $(event.relatedTarget).attr('data-path');

        if (typeof path == 'undefined')
            path = $('.elfinder-modal-content').attr('data-path');

        var option = $('.elfinder-modal-content').attr('data-option');
        $('.elfinder-modal-content').attr('src', './editors/default/elfinder/elfinder.php?path=' + path + '&' + option);
    });

    // ������������� ���� ��������
    $('.collapse').on('hidden.bs.collapse', function() {
        $(this).prev('h4').find('span').removeClass('glyphicon-triangle-bottom');
        $(this).prev('h4').find('span').addClass('glyphicon-triangle-right');
    });
    $('.collapse').on('show.bs.collapse', function() {
        $(this).prev('h4').find('span').removeClass('glyphicon-triangle-right');
        $(this).prev('h4').find('span').addClass('glyphicon-triangle-bottom');
    });

    $('#rules-message>a[href="#"]').on('click', function(event) {
        event.preventDefault();
        history.back(1);
    });

    // ������� � ����������
    $("body").on('click', ".select-action .select", function(event) {
        event.preventDefault();

        var chk = $('input:checkbox:checked').length;
        var i = 0;

        if (chk > 0) {

            $.MessageBox({
                buttonDone: "OK",
                buttonFail: locale.cancel,
                message: locale.confirm_delete
            }).done(function() {

                $('input:checkbox:checked').each(function() {
                    var id = $(this).closest('.data-row');
                    $('.list_edit_' + $(this).attr('data-id')).ajaxSubmit({
                        dataType: "json",
                        success: function(json) {
                            if (json['success'] == 1) {
                                //table.fnDeleteRow(id.attr('data-row'));
                                id.remove();
                                showAlertMessage(locale.save_done);
                                i++;
                                if (chk == i)
                                    window.location.reload();

                            } else
                                showAlertMessage(locale.save_false, true);
                        }
                    });
                });
            })
        }
        else
            alert(locale.select_no);
    });

    // ������� �� ������
    $("button[name=addNew]").on('click', function() {
        if (typeof action == 'undefined')
            window.location.href += '&action=new';
    });

    // ������� ����� �� ��������
    $(".new").on('click', function(event) {
        event.preventDefault();
        cat = $('[name="addNew"]').attr('data-cat') || $.getUrlVar('id');
        if (cat > 0)
            window.location.href += '&action=new&cat=' + cat;
        else
            window.location.href += '&action=new';
    });

    // ������� ��������� �������
    $("body").on('click', ".data-row .status", function(event) {
        event.preventDefault();

        // �������� �� ��������������� �������
        if (typeof(STATUS_EVENT) == 'undefined') {

            var id = $(this).attr('data-id');
            var caption = $(this).html();

            // ��������� ���������� ��������
            $(this).closest('ul').find('li').removeClass('disabled');
            $(this).closest('.dropdown').find('a.dropdown-toggle').toggleClass('text-muted');
            $(this).parent('li').addClass('disabled');

            // ��������� �������� ��������������
            $('.status_edit_' + id + ' input[name=enabled_new]').val($(this).attr('data-val'));
            $('.status_edit_' + id + ' input[name=flag_new]').val($(this).attr('data-val'));
            $('.status_edit_' + id + ' input[name=statusi_new]').val($(this).attr('data-val'));
            $('.status_edit_' + id).ajaxSubmit({
                dataType: "json",
                success: function(json) {
                    if (json['success'] == 1) {
                        $("#dropdown_status_" + id).html(caption);
                        showAlertMessage(locale.save_done);
                    } else
                        showAlertMessage(locale.save_false, true);
                }
            });
        }
    });

    // ��������� ����������
    if (typeof(VALIDATOR_LOAD) != 'undefined')
        $('#product_edit').validator().on('submit', function(event) {
            if (event.isDefaultPrevented()) {
                showAlertMessage(locale.validator_false);
            }
        });

    // ��������� �� ��������
    $("button[name=editID]").on('click', function(event) {
        event.preventDefault();

        var data = [];
        data.push({name: 'editID', value: 1});
        $('#product_edit .form-control, #product_edit .hidden-edit, #product_edit input:radio:checked, #product_edit input:checkbox:checked').each(function() {
            if ($(this).attr('name') !== undefined) {
                data.push({name: $(this).attr('name'), value: escape($(this).val())});
            }
        });
        //data.push({name: 'ajax', value: 1});

        $('#product_edit').ajaxSubmit({
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(json) {

                if (json['success'] == 1) {
                    showAlertMessage(locale.save_done);

                    if ($.getUrlVar('frame') !== undefined) {
                        parent.window.$('#adminModal').modal('hide');
                        parent.window.location.reload();
                    }

                }
                else
                    showAlertMessage(locale.save_false, true);
            }

        });
    });

    // ������ ���������� ����
    $(".deleteone, .delete, .value-delete").append(' <span class="glyphicon glyphicon-trash"></span>');

    // �������� �� ��������
    $(".deleteone").on('click', function(event) {
        event.preventDefault();

        $.MessageBox({
            buttonDone: "OK",
            buttonFail: locale.cancel,
            message: locale.confirm_delete
        }).done(function() {

            $('#product_edit').append('<input type="hidden" name="delID" value="1">');
            $('#product_edit').append('<input type="hidden" name="ajax" value="1">');
            $('#product_edit').ajaxSubmit({
                dataType: "json",
                success: function(json) {

                    if (json['success'] == 1) {

                        if ($.getUrlVar('frame') !== undefined) {
                            parent.window.$('#adminModal').modal('hide');
                            parent.window.location.reload();
                        }
                        else
                            window.location.href = '?path=' + $('#path').val();
                    }
                    else
                        showAlertMessage(locale.save_false, true);
                }
            });
        })
    });

    // �������� �� ������
    $("body").on('click', ".data-row .delete", function(event) {
        event.preventDefault();
        var id = $(this).closest('.data-row');
        var data_id = $(this).attr('data-id');

        $.MessageBox({
            buttonDone: "OK",
            buttonFail: locale.cancel,
            message: locale.confirm_delete
        }).done(function() {

            $('.list_edit_' + data_id).ajaxSubmit({
                dataType: "json",
                success: function(json) {
                    if (json['success'] == 1) {
                        if (typeof(table) != 'undefined')
                            table.fnDeleteRow(id.attr('data-row'));
                        else
                            id.remove();
                        showAlertMessage(locale.save_done);
                    } else
                        showAlertMessage(locale.save_false, true);
                }
            });
        })
    });

    // ������������� �� ������
    $("body").on('click', ".data-row .edit", function(event) {
        event.preventDefault();
        window.location.href = $(this).closest('.data-row').find('.list_edit_' + $(this).attr('data-id')).attr('action');
    });

    // ������������� �� ������ dropdown
    $("body").on('mouse', "#dropdown_action", function() {
        $("input:checkbox[name=items]").each(function() {
            this.checked = !this.checked && !this.disabled;
        });
    });

    // ��������� �� ������ dropdown
    $('.data-row').hover(
            function() {
                $(this).find('#dropdown_action').show();
            },
            function() {
                $(this).find('#dropdown_action').hide();
            });

    // ����� ���� ��������� ����� checkbox
    $('body').on('click', "#select_all", function() {
        $('ul.select-action > li').toggleClass('disabled');

        // ���������� ����
        $('ul.select-action > li > a.enabled').parent('li').removeClass('disabled');

        $("body input:checkbox[name=items]").each(function() {
            this.checked = !this.checked && !this.disabled;
        });
    });

    // ����� �������� ����� checkbox
    $("body").on('click', "input[name=items]", function() {
        $('ul.select-action > li').removeClass('disabled');
    });

    // ������ � Action Panel
    $(".btn-action-panel").on('click', function() {
        window.location.href = '?path=' + $(this).attr('name');
    });

    // ������� � Action Panel
    $(".btn-action-back").on('click', function() {
        history.back(1);
    });

    // ������������ �� �������� ����
    $(".go2front").on('click', function() {
        if ($('.front').length) {
            $(this).attr('href', $('.front').attr('href'));
        }
        else if ($.cookie('cat')) {
            $(this).attr('href', '../../shop/CID_' + $.cookie('cat') + '.html');
        }
    });

    // �������� �������� � Action Panel
    $(".btn-action-panel-blank").on('click', function(event) {
        event.preventDefault();
        window.open($(this).attr('name'));
    });

    // ������� ����������
    if (typeof(TABLE_EVENT) == 'undefined') {

        if (typeof($.cookie('data_length')) == 'undefined')
            var data_length = [10, 25, 50, 75, 100, 500, 1000];
        else
            var data_length = [parseInt($.cookie('data_length')), 10, 25, 50, 75, 100, 500, 1000];

        var table = $('#data').dataTable({
            "lengthMenu": data_length,
            "paging": true,
            "ordering": true,
            "info": false,
            "language": locale.dataTable,
            "aaSorting": [],
            "columnDefs": [
                {"orderable": false, "targets": 0}
            ]

        });

        // �������� checked � ���������
        $('#data').on('draw.dt', function() {
            if ($('#select_all').prop("checked")) {
                $("input:checkbox[name=items]").each(function() {
                    this.checked = 'checked';
                });
            }
        });

    }

    // ���������� ��������� ����������
    $('select[name="data_length"]').on('change', function() {
        if (this.value > 10)
            $.cookie('data_length', this.value, {
                path: '/phpshop/admpanel/',
                expires: 365
            });
        else
            $.removeCookie('data_length', {path: '/phpshop/admpanel/'});
    });

    // ��������� 
    $('[data-toggle="tooltip"]').tooltip({container: 'body'});

    // �olorpicker
    if ($('.color').length)
        $('.color').colorpicker({format: 'hex'});

    // ����� ������
    if ($('#orders-check').html() > 0) {
        $('#orders-check').parent('.navbar-btn').removeClass('hide');
        $('#orders-mobile-check').removeClass('hide');
    }

    // �����
    if (typeof presentation_start != 'undefined') {
        $('#presentation-select').click();
    }

    // �������� � �������� �� ����
    if (window.location.hash != '') {
        var el = $("a[name='set" + window.location.hash.split('#').join('') + "']");
        if (typeof el.offset() != 'undefined') {
            $('html, body').animate({scrollTop: el.offset().top - 100}, 500);
            el.next('.collapse-block').addClass('alert alert-info');
        }
    }

    // Filemanager � ��������� ����
    $('#filemanagerwindow').on('click', function() {
        var w = '1240';
        var h = '550';
        var url = $('.elfinder-modal-content').attr('src');
        filemanager = window.open(url + '&resizable=1', "chat", "dependent=1,left=100,top=100,width=" + w + ",height=" + h + ",location=0,menubar=0,resizable=1,scrollbars=0,status=0,titlebar=0,toolbar=0");
        filemanager.focus();
        $('#elfinderModal').modal('hide');
    });

    // Progress
    if (parent.window.$('#adminModal') && $.getUrlVar('frame') !== undefined) {
        parent.window.$('.progress-bar').css('width', '90%');
        setTimeout(function() {
            parent.window.$('.progress').toggleClass('hide');
        }, 500);
    }

    // ����� ������
    setInterval(function() {
        var data = [];
        data.push({name: 'selectID', value: 1});
        data.push({name: 'actionList[selectID]', value: 'actionGetNew'});

        $.ajax({
            mimeType: 'text/html; charset=windows-1251',
            url: '?path=order',
            type: 'post',
            data: data,
            dataType: "json",
            async: false,
            success: function(json) {
                var old_num = (Number($('#orders-check').text()) || 0);
                $('#orders-check').text(json['num']);
                if (old_num < json['num']) {
                    $('#play').trigger("play");
                }
            }
        });

    }, 30000);

});

// GET ���������� �� URL ��������
$.extend({
    getUrlVars: function() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    getUrlVar: function(name) {
        return $.getUrlVars()[name];
    }
});

function imgerror(obj) {
    obj.src = './images/no_photo.gif';
}