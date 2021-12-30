/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
    
    url: $("#fileupload").attr('action')
    });
    
    $('#fileupload').addClass('fileupload-processing');

    $.ajax({
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
    });
});

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } }); 

        // saber quando arquivos são add ao drag
//    drop: function (e, data) {
//        $.each(data.files, function (index, file) {
//            alert('Dropped file: ' + file.name);
//        });
//    },
//    change: function (e, data) {
//        $.each(data.files, function (index, file) {
//            alert('Selected file: ' + file.name);
//        });
//    }