$(document).ready(function () {

    // @author: Zahaire Guro
    var newFileForm = $('#new_file_form');
    var cancel_button = (newFileForm).find('button#cancel_upload');
    var submit_button = (newFileForm).find('button#upload');
    var retry_button = (newFileForm).find('button#retry_upload');
    var close_button = (newFileForm).find('button#close_upload');
    var file_input = (newFileForm).find('input#new_file');
    var upload_status = newFileForm.find('div#upload_status');
    var progress = $('div#progress');
    var progressBar = $('#progressBar');
    var upload_modal_trigger = $('button#upload_modal_trigger');
    var instructions_div = $('div#instructions');
    var restore_btn = $('#restore_btn');

    var fileID = "";
    var errorHTML = '<h4 class="text-danger font-weight-bold">Oops!</h4>';
    var xhr = new window.XMLHttpRequest();

    // ------------------ //
    // FILE RETRIEVE AJAX //
    // ------------------ //

    var fileDisplayTable = $('#fileDataTable').DataTable(
        {
            "ajax": {
                "dataType": "json",
                "url": "get_dir_contents",
                "type": "GET",
                "dataSrc": "current_directory.file",
            },
            "language": {
                "emptyTable": "No files available."
            },
            "columnDefs": [
                {
                    "className": "text-secondary",
                    "targets": [2, 3, 4, 5]
                },
                {
                    "className": "text-center",
                    "targets": [0, 6]
                }
            ],
            "columns": [
                {
                    "data": "name",
                    "width": "5%",
                    "orderable": false,
                    "render": function (data, type, row, meta) {
                        var fasClass = getIconClass(data.substring(data.lastIndexOf(".") + 1));
                        return '<i class="fas fa-2x center-v h-100 ' + fasClass + '"></i>';
                    }
                },
                {
                    "data": "name",
                    "width": "45%"
                },
                {
                    "data": "created_at",
                    "width": "10%"
                },
                {
                    "data": "updated_at",
                    "width": "10%"
                },
                {
                    "data": "updated_by",
                    "width": "12%",
                    "render": function (data, type, row, meta) {
                        var user = getUser(data);
                        return user.fullname;
                    }
                },
                {
                    "data": "size",
                    "width": "10%",
                    "render":
                        function (data, type, row, meta) {
                            return data + ' KB';
                        }
                },
                {
                    "data": null,
                    "orderable": false,
                    "render":
                        function (data, type, row, meta) {
                            downloadBtn_str = '<a href="' + row.source + '" download="' + row.name + '" class="btn btn-success m-1"><i class="fas fa-download"></i></a>';
                            deleteBtn_str = '<button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#delete_modal" data-fileid="' + row.id + '"><i class="fas fa-trash"></i></button>';
                            return downloadBtn_str + deleteBtn_str;
                        }
                }
            ],
            "processing": true,
            "paging": true,
            "order": [[1, 'asc']],
            "pageLength": 10
        }
    );

    var fileBinTable = $('#fileBinTable').DataTable(
        {
            "ajax": {
                "dataType": "json",
                "async": "true",
                "url": "get_bin_contents",
                "type": "GET",
                "dataSrc": "project_bin",
            },
            "language": {
                "emptyTable": "No files here"
            },
            "processing": true,
            "paging": true,
            "order": [[0, 'asc']],
            "pageLength": 5,
            "destroy": true,
            "columns": [
                { "data": "name" },
                { "data": "updated_at" },
                {
                    "data": "updated_by",
                    "render": function (data, type, row, meta) {
                        var user = getUser(data);
                        return user.fullname;
                    }
                }
            ]
        }
    );

    $('#fileBinTable tbody').on('click', 'tr',
        function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                fileBinTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }

            if (fileBinTable.rows('.selected').data().length != 0) {
                if (restore_btn.attr('disabled')) {
                    restore_btn.removeAttr('disabled');
                }
            } else {
                restore_btn.attr('disabled', 'true');
            }
        }
    );

    restore_btn.click(
        function () {
            var row_id = (fileBinTable.rows('.selected').data())[0].id;
            restore_file(row_id);
            fileBinTable.ajax.reload();
            fileDisplayTable.ajax.reload();
        }
    );

    function restore_file(id) {
        console.log(id);
        $.ajax(
            {
                method: 'GET',
                async: true,
                url: 'restore_file/' + id,
                datatype: 'json'
            })
            .done(
                function (data) {
                    console.log(data);
                })
            .fail(
                function (data) {
                    console.log(data + " error");
                });
    }

    $('#bin_modal_trigger').click(
        function (e) {
            fileBinTable.ajax.reload();
        }
    );

    // ------------------ //
    // FILE UPLOAD AJAX //
    // ------------------ //

    // reset buttons to default states
    upload_modal_trigger.click(
        function (e) {
            resetUploadButtons();
        }
    );

    function resetUploadButtons() {
        instructions_div.css(
            {
                "height": "auto",
                "opacity": "1"
            }
        );
        file_input.val(null);

        // status texts
        if (!upload_status.is(':empty')) {
            upload_status.empty();
        }
        upload_status.attr('hidden', 'true');

        // cancel button
        if (cancel_button.hasClass('btn-primary')) {
            cancel_button.removeClass('btn-primary');
        }

        // submit button
        submit_button.removeAttr('hidden');

        // progress bar
        if (progressBar.hasClass('bg-danger')) {
            progressBar.removeClass('bg-danger');
        }
        if (progressBar.hasClass('bg-success')) {
            progressBar.removeClass('bg-success');
        }
        progressBar.css('width', '0%');
        progress.attr('hidden', 'true');

        // file input
        file_input.removeAttr('hidden');
        close_button.removeAttr('hidden');
        retry_button.attr('hidden', 'true');
        submit_button.attr('disabled', 'true');
    }

    retry_button.click(
        function () {
            resetUploadButtons();
        }
    );

    // make sure a file is selected
    file_input.change(
        function (e) {
            upload_status.empty().attr('hidden', 'true');
            if ($(this).val && $(this)[0].files[0].size < 120000000) {
                submit_button.removeAttr('disabled');
            } else {
                upload_status.append('<p class="text-danger"><small>That file is too large</small></p>')
                    .removeAttr('hidden');
            }
        }
    );

    // FILE UPLOAD
    newFileForm.submit(
        function (e) {
            e.preventDefault();
            instructions_div.animate(
                {
                    height: '0px',
                    opacity: '0'
                },
                500
            );
            // Show progress bar and change button context
            submit_button.attr('hidden', 'true');
            progress.removeAttr('hidden');
            file_input.attr('hidden', 'true');
            close_button.attr('hidden', 'true');
            cancel_button.removeAttr('hidden', 'true')

            $.ajax(
                {
                    xhr:
                        function () { // loader logic
                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var percent = Math.round((e.loaded / e.total) * 100);
                                    progressBar.attr('aria-valuenow', percent).css('width', percent + '%');
                                }
                            });
                            return xhr;
                        },
                    url: 'add_file',
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    timeout: 3600000,
                    async: true
                })
                .done(
                    function (data) {
                        if (file_input[0].files[0].size === 0) {
                            uploadErrorBtnState('Your file does not contain anything!');
                            return;
                        }

                        if (data.error != null) {
                            uploadErrorBtnState(data.error);
                            return;
                        }

                        cancel_button.attr('hidden', 'true');

                        close_button.removeAttr('hidden');

                        retry_button
                            .text('Upload another file')
                            .removeClass('btn-warning')
                            .addClass('btn-secondary')
                            .removeAttr('hidden');

                        upload_status.removeAttr('hidden')
                            .append('Your file has been uploaded!');

                        progressBar.addClass('bg-success');

                        fileDisplayTable.ajax.reload();
                    })
                .fail(
                    function (xhr, status, error) {
                        refresh();

                        if (xhr.readyState === 0) {
                            uploadErrorBtnState('Upload has been interrupted');
                            retry_button
                                .text('Upload another')
                                .removeClass('btn-warning')
                                .removeAttr('hidden');

                            return;
                        }

                        if (file_input[0].files[0].size >= 5 * (1024) * (1025)) {
                            uploadErrorBtnState('Your file exceeds maximum size allowed!');
                            return;
                        }

                        errorText = 'Could not connect to the server.';
                        uploadErrorBtnState(errorText);
                    });
        }
    );

    function uploadErrorBtnState(error) {
        upload_status.removeAttr('hidden')
            .empty()
            .append(errorHTML)
            .append(error);

        close_button.removeAttr('hidden');

        retry_button.removeAttr('hidden');

        cancel_button.attr('hidden', 'true');

        file_input.attr('hidden', 'true');

        progressBar.addClass('bg-danger');
    }

    // cancel button
    cancel_button.click(
        function () {
            xhr.abort();
        }
    );

    // ------ //
    // MODALS //
    // ------ //

    // dynamically generate delete modal contents
    $('#delete_modal').on(
        'show.bs.modal',
        function (event) {
            var rowFileID = $(event.relatedTarget).data('fileid'); // Extract info button's from data-* attributes
            var modal = $(this);

            fileID = rowFileID;
        }
    );

    // delete ajax request
    $('#deleteFile_btn').click(
        function (e) {
            e.preventDefault();

            $.ajax(
                {
                    method: 'GET',
                    async: true,
                    url: 'delete_file/' + fileID,
                    datatype: 'json'
                })
                .done(
                    function (data) {
                        fileDisplayTable.ajax.reload();
                    })
                .fail(
                    function (data) {
                        console.log(data + " error");
                    });

            $('#delete_modal').modal('hide');
        }
    );
});