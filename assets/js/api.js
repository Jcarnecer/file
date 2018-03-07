function getUser(userId) {
    var user = new Object;
    $.ajax(
        {
            async: false,
            type: 'GET',
            url: `${baseUrl}api/user/${userId}`,
            dataType: 'json'
        })
        .done(
            function (data) {
                user.fullname = data.first_name + " " + data.last_name;
            })
        .fail(
            function (data) {
                user.fullname = '--';
            }
        );
    return user;
};

function getIconClass(file_ext) {
    var fasClass = 'fa-file';
    $.ajax(
        {
            async: false,
            type: 'GET',
            url: `${baseUrl}api/icon/${file_ext}`,
            dataType: 'json'
        })
        .done(
            function (data) {
                fasClass = data;
            })
        .fail(
            function (data) {
                fasClass = 'fa-file';
            });

    return fasClass;
};