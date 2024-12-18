let classMessage = 'display-none';

function removeBook(idBook) {
    $.ajax({
        url: "http://localhost:8083/ajax/delete-book",
        type: "DELETE",
        dataType: 'json',
        data: {idBook: idBook},
        success: successEvent,
        error: failEvent,
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
        success: successEvent,
        error: failEvent,
    });
}

function removeAuthor(idAuthor) {
    $.ajax({
        url: "http://localhost:8083/ajax/delete-author",
        type: "delete",
        dataType: 'json',
        data: {idAuthor: idAuthor},
        success: successEvent,
        error: failEvent,
    });
}

function editAuthor(id) {
    let params = {};
    let dataForm = $('#formEditingAuthor').serializeArray();

    params.id = id;
    dataForm.forEach((element) => {
        params[element.name] = element.value;
    });

    $.ajax({
        url: "http://localhost:8083/ajax/edit-author",
        type: "PUT",
        dataType: 'json',
        data: params,
        success: successEvent,
        error: failEvent,
    });
}

function redirectCard(id, page) {
    let del_s = page.slice(0, -1);

    window.location.href = 'http://localhost:8083/site/card-'+ del_s +'?id-' + del_s + '='+id;
}

function successEvent(response){
    let messageElement = $('#message');
    let responseData = response.data;
    let responseMessage  = ('messages' in response) ? response.messages : "";

    if ("deleted" in responseData && !!responseData.deleted) {

        alert(responseMessage);
        if ("redirectPage" in responseData) {
            window.location.href = "http://localhost:8083/site/"+responseData.redirectPage;
        } else {
            window.location.href = "http://localhost:8083/";
        }

    } else if ("edited" in responseData && !!responseData.edited) {

        alert(responseMessage);
        if ("redirectPage" in responseData) {
            window.location.href = "http://localhost:8083/site/"+responseData.redirectPage;
        } else {
            window.location.href = "http://localhost:8083/";
        }

    } else {

        classMessage = 'error-message';
        messageElement.children(":first").html(responseMessage.Error[0]);
        alert(responseMessage.Error[0]);

    }
}

function failEvent(xhr, status, error) {
    let messageElement = $('#message');

    classMessage = 'error-message';
    messageElement.attr('class', classMessage);

    messageElement.children(":first").html(error);

    console.error("Ошибка: ", error);
}