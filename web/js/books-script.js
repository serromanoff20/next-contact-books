const page = $(location).attr('href').split("site/");

if (page[1] === 'books') {
    let sortBy = $('input:radio[name="sortBy"]:checked').val();

    getAllBooks(sortBy, null);

    $('input:radio[name="sortBy"]').change(() => {
        let sortBy = $('input:radio[name="sortBy"]:checked').val();

        getAllBooks(sortBy, null)
    });

    let filter = {
        'byValue': null,
        'onProps': null,
    };
    $("#search").keyup(() => {
        let value = $("#search").val();

            $('input:radio[name="filter"]').each(function () {
                if (this.checked) {
                    filter.onProps = this.id;
                }
            })
            filter.byValue = value;

            if (filter.onProps !== null) {
                $('input:button').attr("disabled", false);
            }

        getAllBooks(sortBy, filter);
    });

}

function getAllBooks(sortBy, filter=null) {
    let data = {
        'sortBy': sortBy,
    };
    if (filter !== null) {
        data['filterOnProps'] = filter.onProps;
        data['filterByValue'] = filter.byValue;
    }
    $.ajax({
        url: "http://localhost:8083/ajax/select-books",
        type: "GET",
        dataType: 'json',
        data: data,
        success: successSelectBooks,
        error: failSelectBooks,
    });
}

function successSelectBooks (response) {
    $('#data').empty();

    let result = response.data;
    let message = response.message;

    if( result.length > 0 ) {
        if ($('#book').length === 0) {
            result.forEach((book) => {
                let block = $("<div></div>", {class: 'w-50 border border-primary rounded p-2 mt-2 mb-2', id: "book"});

                let label_1 = block.append("<li>id: " + book.id + " </li>");
                let label_2 = block.append("<li>Наименование произведения: " + book.name + " </li>");
                let label_3 = block.append("<li>Жанр: " + book.genre + " </li>");
                let label_4 = block.append("<li>Год публикации: " + book.public_year + " </li>");
                let label_5 = block.append("<li>Автор: " + book.author_short_name + " </li>");


                $('#data').append(label_1);
                $('#data').append(label_2);
                $('#data').append(label_3);
                $('#data').append(label_4);
                $('#data').append(label_5);
            })
        } else {
            result.forEach((book) => {
                let block = $("<div></div>", {class: 'w-50 border border-primary rounded p-3 mt-2 mb-2', id: "book"});

                let label_1 = block.append("<li>id: " + book.id + " </li>");
                let label_2 = block.append("<li>Наименование произведения: " + book.name + " </li>");
                let label_3 = block.append("<li>Жанр: " + book.genre + " </li>");
                let label_4 = block.append("<li>Год публикации: " + book.public_year + " </li>");
                let label_5 = block.append("<li>Автор: " + book.author_short_name + " </li>");


                $('#data').append(label_1);
                $('#data').append(label_2);
                $('#data').append(label_3);
                $('#data').append(label_4);
                $('#data').append(label_5);

            })
        }
    } else {
        let p = $("<p class='error-message'>" + message + " </p>");

        $('#data').append(p);
        // console.log(message);
    }
}

function failSelectBooks (xhr, status, error) {
    console.error("Ошибка: ", error);
}