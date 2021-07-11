require('./bootstrap');

var $ = require('jquery');

const renderFileTable = function () {
    $.ajax({
        url: "/files/list",
        method: "GET",
    }).done (function (res) {
        $.each(res, function(i, file) {
            let textLink = "<a href='/files/download/" + file['id'] + "' target='__blank'>" + file['path'] + "</a>";
            let textOperButtons = "<div class='btn-group' role='group' aria-label='operButtons'> \
                <a class='btn btn-outline-primary btn-rename' href='/files/rename/" + file['id'] + "'>Rename</a> \
                <a type='button' class='btn btn-outline-primary'>Delete</a> \
            </div>";
            let tr = $('<tr>').append(
                $('<td>').append(textLink),
                $('<td>').text(file['size']),
                $('<td>').append(textOperButtons),
            ).appendTo('#fileTableBody');
        });
    });
};

$(document).ready(renderFileTable);
