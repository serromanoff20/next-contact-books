let classMessage = 'display-none';

function removeBook(idBook) {
    $.ajax({
        url: "http://localhost:8083/ajax/delete-book",
        type: "DELETE",
        dataType: 'json',
        data: {idBook: idBook},
        success: successRemoved,
        error: failRemoved,
    });
}

function editBook(id) {
    let params = {};
    let dataForm = $('#formEditingBook').serializeArray();

    params.id = id;
    dataForm.forEach((element) => {
        params[element.name] = element.value;
    });

    $.ajax({
        url: "http://localhost:8083/ajax/edit-book",
        type: "PUT",
        dataType: 'json',
        data: params,
        success: successRemoved,
        error: failRemoved,
    });
}

function removeAuthor(idAuthor) {
    $.ajax({
        url: "http://localhost:8083/ajax/delete-author",
        type: "delete",
        dataType: 'json',
        data: {idAuthor: idAuthor},
        success: successRemoved,
        error: failRemoved,
    });
}

function editAuthor(id) {
    let params = {};
    let dataForm = $('#formEditingAuthor').serializeArray();

    params.id = id;
    dataForm.forEach((element) => {
        params[element.name] = element.value;
    });

    console.log(params);
    $.ajax({
        url: "http://localhost:8083/ajax/edit-author",
        type: "PUT",
        dataType: 'json',
        data: params,
        success: successRemoved,
        error: failRemoved,
    });
}

function redirectCard(id, page) {
    let del_s = page.slice(0, -1);

    window.location.href = 'http://localhost:8083/site/card-'+ del_s +'?id-' + del_s + '='+id;
}

function successRemoved(response){
    let messageElement = $('#message');

    if ("deleted" in response && !!response.deleted) {

        alert(response.message);
        if ("redirectPage" in response) {
            window.location.href = "http://localhost:8083/"+response.redirectPage;
        } else {
            window.location.href = "http://localhost:8083/";
        }

    } else if ("edited" in response && !!response.edited) {

        classMessage = 'success-message';
        messageElement.attr('class', classMessage);
        messageElement.children(":first").html(response.message);
        alert(response.message);
        if ("redirectPage" in response) {
            window.location.href = "http://localhost:8083/"+response.redirectPage;
        } else {
            window.location.href = "http://localhost:8083/";
        }

    } else {

        classMessage = 'error-message';
        messageElement.children(":first").html(response.message.Error[0]);
        alert(response.message.Error[0]);

    }
}

function failRemoved(xhr, status, error) {
    let messageElement = $('#message');

    classMessage = 'error-message';
    messageElement.attr('class', classMessage);

    messageElement.children(":first").html(error);

    console.error("Ошибка: ", error);
}

$(document).ready(() => {

    console.log($("#sortBy").val());

    $("#search").keyup(() => {
        console.log($("#search").val());
    });
})