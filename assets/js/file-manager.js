var baseUrl = `${window.location.origin}/file/`;

$(function(){
    showAll();
    //get all files of dir

    function showAll(){
        $.ajax({
            type: 'get',
            url: `${baseUrl}api/get_contents`,
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);
            },
            error: function() {
                alert('Could not get data from DB');
            }
        })
    }
});