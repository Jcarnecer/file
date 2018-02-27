//Smooth Scrolling

$(document).ready(function () {

    //@TODO add file ajax
    $.ajax(
        {
            method: 'GET',
            async: true,
            url: 'get_dir_contents',
            datatype: 'json'
        }
    ).done(
        function (data) {
            //console.log());
            data = JSON.parse(data);
            console.log(data);
            var data = data.current_directory;
            console.log(data.name);

            var str = "";
            $.each(data.file, function (i, val) {
                str += generateRow(val);
            });

            $('#file_browser').append(str);
        }
    );

    function generateRow(row) {
        // build string to return
        var str = "";

        // build tr opening and closing tags
        var trOpeningTag_str = "<tr id='file[" + row.id +"]'>";
        var trClosingTag_str = "</tr>";

        // declare td css classes
        var tdAdditionalClasses_CSS = "align-middle";
        // declare td css styles
        var tdAdditionalStyle_CSS = "";

        // build td opening tag
        var tdOpeningTag_str =
            "<td class='" + tdAdditionalClasses_CSS +
            "' style='" + tdAdditionalStyle_CSS + "'>";

        var tdClosingTag_str = "</td>";

        // content html of each td

        // build file icon
        var fileIcon_str = "<span class='fas fa-file fa-2x mr-5'></span>";

        var fileName_str = // file name
            tdOpeningTag_str +  
                "<p class='table-row-first'>" + 
                fileIcon_str + // file icon
                row.name + 
                "</p>" + 
            tdClosingTag_str;

        var fileModified_str = // last modified
            tdOpeningTag_str + 
            "<p class='text-secondary'>" + row.updated_at + "</p>" + 
            tdClosingTag_str;

        var fileCreated_str = // date created
            tdOpeningTag_str + 
            "<p class='text-secondary'>" + row.created_at + "</p>" + 
            tdClosingTag_str;

        var fileDownloadLink_str = // download button
            "<a href='" + row.source +
            "' download='" + row.name +
            "' target='_blank' " +
            "class='btn btn-success m-2'>" +
            "<i class='fas fa-download fa-1x'></i>" +
            "</a>";

        var fileDeleteButton_str = // delete button
            "<button type='button' " +
            "data-toggle='modal' " +
            "class='btn btn-danger m-2' " +
            "data-target='#delete_modal' " + // what modal to target
            "data-fileid='" + row.id + "'>" + // new data-* field to dynamically vary modal content
            "<i class='fas fa-trash fa-1x'></i></button>"; // delete button icon

        var lastcolumn =
            tdOpeningTag_str +
            "<div class='float-right mr-5'>" +
            fileDownloadLink_str +
            fileDeleteButton_str +
            "</div>" +
            tdClosingTag_str;

        str =
            trOpeningTag_str +
                fileName_str + 
                fileModified_str + 
                fileCreated_str + 
                lastcolumn + 
            trClosingTag_str;
        
        return str;
    }

    $('#delete_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var fileid = button.data('fileid'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-footer a').attr('href', "delete/" + fileid);
    });

});