const $ = jQuery;

function getEstates() {
    const BUTTON = ('.re_search');
    const URL = `${window.location.origin}/wp-json/re/v2/estates/`;

    function fetchData(target) {
        const $filters = $(target).closest('.re_filters');
        const $searchResults = $(target).parents(':eq(2)').find('.re_search_results');
        const $buildingName = $filters.find('input[name=building_name]');
        const $floorCount = $filters.find('select[name=floor_count]');
        const $estateType = $filters.find('input[type=radio]');
        const $searchButton = $(target);

        $.ajax(URL, {
            type: 'POST',
            data: {
                name: $buildingName.val(),
                floor: $floorCount.val(),
                type: $estateType.filter(':checked').val(),
            },
            success(response) {
                $searchResults.html('');
                $searchResults.append(response);
                $searchButton.attr('disabled', false);
            },
        });
    }

    $(document).on('click', BUTTON, (e) => {
        $(e.target).attr('disabled', 'disabled');
        fetchData(e.target);
    });
}

function estatePagination() {
    const BUTTON = '.re_pagination';
    const PAGE = '.re_page';

    $(document).on('click', BUTTON, (e) => {
        e.preventDefault();

        const $page = $(e.target).attr('data-re-paging');
        const $buttonContainer = $(e.target).closest('.re_search_results');
        const $current = $buttonContainer.find('[data-re-list-page=' + $page + ']');
        $buttonContainer.find(PAGE).removeClass('active');
        $buttonContainer.find(BUTTON).removeClass('active');
        $current.addClass('active');
        $(e.target).addClass('active');

    });
}

getEstates();
estatePagination();