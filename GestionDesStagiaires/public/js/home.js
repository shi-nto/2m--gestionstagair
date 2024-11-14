
    let page = 1; // Initialize page number

    $(window).scroll(function() {
        // If user scrolls to the bottom of the page
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            page++; // Increment page number
          var  search=$('.usernameSearchInput').val();
            loadMoreData(page,search); // Call function to load more data
        }
    });

    function loadMoreData(page,search=null) {
        $.ajax({
            url: '?page=' + page + '&search=' + search, // Pass the current page number as a query parameter
            type: 'get',
            beforeSend: function() {
                // Optionally, show a loading spinner or message
            }
        })
        .done(function(data) {
            if (data.trim().length === 0) {
                // If no more data to load, hide or remove loader/spinner
                return;
            }
            $('#posts').append(data); // Append new data to the existing posts container
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
          
        });
    }
