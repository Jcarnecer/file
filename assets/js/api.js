function getUser(userId) {

    return $.ajax({
         
        async: false,
        type: 'GET',
        url: `${baseUrl}api/user/${userId}`,
        dataType: 'json'
    });
};