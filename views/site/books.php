<div class="site-login">
    <h1>Список книг</h1>
    <br />
    <div id="message" class="d-none">
        <p></p>
    </div>


    <div class="d-flex justify-content-between align-items-center">
        <div class="">
            <div class="form-check">
                <label class="form-check-label" for="name">
                    <input class="form-check-input" type="radio" name="sortBy" value="name" checked>

                    Сорт. по наименованию произведения
                </label>
            </div>

            <div class="form-check">
                <label class="form-check-label" for="public_year">
                    <input class="form-check-input" type="radio" name="sortBy" value="public_year">

                    Сорт. по году издания
                </label>
            </div>
        </div>

        <div class="">
            <div class="d-flex justify-content-end">
                <label for="search" class="w-100 d-flex justify-content-start">
                    <input class="form-control m-1" id="search" type="text" placeholder="Поиск...">
                </label>
            </div>

            <div class="d-flex justify-content-end">
                <input class="form-check-input m-1" id="author_short_name" name="filter" type="radio" checked>
                <label class="" for="short_name_author">
                    по автору
                </label>
                <input class="form-check-input m-1" id="genre" name="filter" type="radio">
                <label class="" for="genre">
                    по жанру
                </label>
                <input class="form-check-input m-1" id="public_year" name="filter" type="radio">
                <label class="" for="public_year">
                    по году издания
                </label>
            </div>
        </div>
    </div>


    <br />
    <div class="all_data" id=data> </div>
</div>
