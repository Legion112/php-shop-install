(function($) {
    $.fn.datetimepicker.dates['ru'] = {
        days: ["�����������", "�����������", "�������", "�����", "�������", "�������", "�������", "�����������"],
        daysShort: ["���", "���", "���", "���", "���", "���", "���", "���"],
        daysMin: ["��", "��", "��", "��", "��", "��", "��", "��"],
        months: ["������", "�������", "����", "������", "���", "����", "����", "������", "��������", "�������", "������", "�������"],
        monthsShort: ["���", "���", "���", "���", "���", "���", "���", "���", "���", "���", "���", "���"],
        today: "�������",
        suffix: [],
        meridiem: []
    };
}(jQuery));

$().ready(function() {

    // datetimepicker
    $(".date").datetimepicker({
        format: 'dd-mm-yyyy',
        language: 'ru',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    // ������� ID ������ � ���� ���� - �����
    $("body").on('click', "#selectModal .search-action", function(event) {
        event.preventDefault();

        var data = [];
        data.push({name: 'selectID', value: 2});
        data.push({name: 'ajax', value: 1});
        data.push({name: 'actionList[selectID]', value: 'actionSearch'});

        $.ajax({
            mimeType: 'text/html; charset=windows-1251',
            url: '?path=catalog.search&words=' + escape($('input:text[name=search_name]').val()) + '&cat=' + $('select[name=search_category]').val() + '&price_start=' + $('input:text[name=search_price_start]').val() + '&price_end=' + $('input:text[name=search_price_end]').val(),
            type: 'post',
            data: data,
            dataType: "html",
            async: false,
            success: function(data) {
                $('#selectModal .modal-body').html(data);

            }

        });
    });

    // ������� ID ������ � ���� ����  -  2 ���
    $("body").on('click', "#selectModal .modal-footer .id-add-send", function(event) {
        event.preventDefault();

        $('.search-list input:checkbox:checked').each(function() {
            var id = $(this).attr('data-id');
            if ($('#odnotip_new').tagExist(id))
            {
                this.disabled;
            }
            else
                $(selectTarget).addTag(id);
        });

        $('#selectModal').modal('hide');
    });


    // ����� �������� �� ����� � ��������� ���� ������� ������
    $('body').on('click', ".search-list  td", function() {
        $(this).parent('tr').find('input:checkbox[name=items]').each(function() {
            this.checked = !this.checked && !this.disabled;
        });
    });



    // ������� ID ������ � ���� ����  - 1 ���
    $(".tag-search").on('click', function(event) {
        event.preventDefault();

        selectTarget = $(this).attr('data-target');

        var data = [];
        data.push({name: 'selectID', value: 2});
        data.push({name: 'ajax', value: 1});
        data.push({name: 'currentID', value: $(selectTarget).val()});
        data.push({name: 'actionList[selectID]', value: 'actionSearch'});

        $.ajax({
            mimeType: 'text/html; charset=windows-1251',
            url: '?path=catalog.search',
            type: 'post',
            data: data,
            dataType: "html",
            async: false,
            success: function(data) {
                //$('#selectModal .modal-dialog').removeClass('modal-lg');
                $('#selectModal .modal-title').html(locale.add_cart_value);
                $('#selectModal .modal-footer .btn-primary').removeClass('edit-select-send');
                $('#selectModal .modal-footer .btn-primary').addClass('id-add-send');
                $('#selectModal .modal-footer .btn-delete').addClass('hidden');
                $('#selectModal .modal-body').css('max-height', ($(window).height() - 200) + 'px');
                $('#selectModal .modal-body').css('overflow-y', 'auto');
                $('#selectModal .modal-body').html(data);

                $(".search-list td input:checkbox").each(function() {
                    this.checked = true;
                });

                $('#selectModal').modal('show');

            }

        });
    });

    if ($('#odnotip_new').length)
        $('#odnotip_new').tagsInput({
            'height': '100px',
            'width': '100%',
            'interactive': true,
            'defaultText': locale.enter,
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 0, // if not provided there is no limit
            'placeholderColor': '#666666'
        });

    // ���������� ������� ���������
    if (typeof(TREEGRID_LOAD) != 'undefined')
        $('.title-icon .glyphicon-chevron-down').on('click', function() {
            $('.tree').treegrid('expandAll');
        });

    if (typeof(TREEGRID_LOAD) != 'undefined')
        $('.title-icon .glyphicon-chevron-up').on('click', function() {
            $('.tree').treegrid('collapseAll');
        });

    // ������ ���������
    if (typeof(TREEGRID_LOAD) != 'undefined')
        $('.tree').treegrid({
            saveState: true,
            color: $('#temp-color').css('color'),
            showBorder: false,
            selectedBackColor: $('#temp-color-selected').css('color'),
            onhoverColor: $('.navbar-action').css('background-color'),
            backColor: "transparent",
            expanderExpandedClass: 'glyphicon glyphicon-triangle-bottom',
            expanderCollapsedClass: 'glyphicon glyphicon-triangle-right'
        });

    $('.data-tree .dropdown-toggle').addClass('btn-xs');

    // ��������� ���������
    if (typeof(TREEGRID_LOAD) != 'undefined')
        $(".treegrid-parent").on('click', function(event) {
            event.preventDefault();
            $('.' + $(this).attr('data-parent')).treegrid('toggle');
        });

    // ������������� ��������� � ������
    $(".tree .edit").on('click', function(event) {
        event.preventDefault();
        window.location.href = '?path=page.catalog&id=' + $(this).attr('data-id');

    });

    // ������� ��������� � ������
    $(".tree .delete").on('click', function(event) {
        event.preventDefault();
        var id = $(this).closest('.data-tree');
        var data_id = $(this).attr('data-id');

        $.MessageBox({
            buttonDone: "OK",
            buttonFail: locale.cancel,
            message: locale.confirm_delete
        }).done(function() {

            $('.list_edit_' + data_id).ajaxSubmit({
                success: function() {
                    id.empty();
                    showAlertMessage(locale.save_done);
                }
            });
        })
    });

    // ������� ����� �� ������
    $("button[name=addNew]").on('click', function() {
        var cat = $(this).attr('data-cat');
        var href = '?path=page&return=page.catalog&action=new';
        if (cat > 0)
            href += '&cat=' + cat;
        window.location.href = href;
        action = true;
    });

    // ��������� ������� ���������
    if (typeof cat != 'undefined') {
        $('.treegrid-' + cat).addClass('treegrid-active');
    }

    // ������� �� �������� �� ������
    $("#dropdown_action  .url").on('click', function(event) {
        event.preventDefault();
        var url = $(this).closest('.data-row').find('.page-url > a').html();
        window.open('../../page/' + url + '.html');
    });


    // ��������� �� ������ dropdown
    $('.data-row, .data-tree').hover(
            function() {
                $(this).find('#dropdown_action').show();
                $(this).find('.editable').removeClass('input-hidden');
                $(this).find('.media-object').addClass('image-shadow');
            },
            function() {
                $(this).find('#dropdown_action').hide();
                $(this).find('.editable').addClass('input-hidden');
                $(this).find('.media-object').removeClass('image-shadow');
            });

});