$(function(){

    var dir = '/project/web';

    /**
     * show modal
     */
    $('body').on('click', '.show-modal', function(e){
        e.preventDefault();
        var action = $(this).data('action');
        var id = $(this).data('id');

        $.ajax({
            cache:false,
            dataType: 'json',
            method: 'post',
            url: dir + '/ajax',
            data: {
                action: action,
                id:id
            },
            beforeSend: function() {

            },
            success: function(data) {
                $('body').append(data.view);
                $('#modal-dialog').modal('show');
                $('#modal-dialog').on('hidden.bs.modal', function(){
                    $('.modal-ajax').remove();
                });
            },
            complete: function() {

            },
            error: function(data) {

            }
        });
    });

    $('body').on('click', '#black_users_form_save', function(e){
        e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var form = $('[name="black_users_form"]');
        form.ajaxSubmit({
            cache:false,
            method: 'post',
            url: dir + '/ajax',
            data: {
                action: 'add_user_black_list'
            },
            success: function(data) {

                if ('error' in data) {
                    $('#alert-block').html(data.error);
                }
                else{
                    $('#alert-block').html(data.success);
                    form.clearForm();
                }

            },
            complete: function() {
                btn.button('reset');
            },
            error: function(data) {
               // console.log(data);
            }
        });
    });

    $('body').on('change', '.type-order', function(){

        var tpl = $(this).data('form');
        var obj = $(this).data('object');

        ajaxShowForm(tpl, obj, '#order-form-contain');
    });

    function ajaxShowForm(tpl, obj, selector){

        $('#alert-block').empty();

        $.ajax({
            cache:false,
            dataType: 'json',
            method: 'post',
            url: dir + '/ajax',
            data: {
                action: 'show_form',
                tpl: tpl,
                obj:obj
            },
            beforeSend: function() {

            },
            success: function(data) {
                $(selector).html(data.view);
            },
            complete: function() {

            },
            error: function(data) {

            }
        });
    }

    $('body').on('click', '.order-save', function(e){
        e.preventDefault();
        var btn = $(this);
        var action = btn.data('action');
        btn.button('loading');
        $('.help-block').remove();
        $('.form-group').removeClass('has-error');
        var form = btn.closest('form');
        form.ajaxSubmit({
            cache:false,
            method: 'post',
            url: dir + '/ajax',
            data: {
                action: action
            },
            success: function(data) {

                if ('error' in data) {
                    $('#order-form-contain').html(data.error);
                }
                else{
                    $('#alert-block').html(data.success);
                }
            },
            complete: function() {
                form.clearForm();
                btn.button('reset');
            },
            error: function(data) {
                 console.log(data);
            }
        });
    });

    $('body').on('click', '.js-datepicker', function(){
        var date = new Date();
        $(this).datetimepicker({
            format: 'dd.mm.yyyy hh:ii',
            startDate: date,
            autoclose: true,
            language: 'ru',
            pickerPosition: 'top-right',
            weekStart: 1,
            minuteStep: 10
        });
        $(this).datetimepicker('show');
    });

    $('body').on('click', '.ajax-load', function(e){
        e.preventDefault();
        var btn = $(this);
        $.ajax({
            cache:false,
            dataType: 'json',
            method: 'post',
            url: dir + '/ajax',
            data: {
                action: btn.data('action'),
                tpl:btn.data('tpl'),
                obj:btn.data('object'),
                sort:btn.data('sort')
            },
            beforeSend: function() {

            },
            success: function(data) {
                $('#ajax-result').html(data.view);
            },
            complete: function() {

            },
            error: function(data) {

            }
        });
    });

});