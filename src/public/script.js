const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.table');
    const headers = table.querySelectorAll('th[data-column]');
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    let currentSortColumn = null;
    let currentSortDirection = 'asc';

    function sortTable(column) {
    }

    function filterTable() {
    }

    headers.forEach(header => {
        header.addEventListener('click', () => {
            sortTable(header);
        });
    });

    sortTable(headers[0]);

    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', filterTable);
});

function exportTasks(_this) {
}

function updateBookField(bookId, field, newValue, title) {
    console.log("hiiii im inside update book field: ", bookId, field, newValue)
    console.log('Request URL:', `/books/${bookId}`);
    console.log('hey??????')
    $.ajax({
        method: 'PUT',
        url: `/books/${bookId}`,
        data: {
            bookId: bookId,
            field: field,
            value: newValue,
            title: field === 'title' ? newValue : '',  
            author: field === 'author' ? newValue : '',
            _token: csrfToken,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Updated successfully:', response, title);
            const cellSelector = `.editable-cell[data-id="${bookId}"][data-field="${field}"]`;
            const cell = $(cellSelector);
            cell.text(newValue);
        },
        error: function (error) {
            console.error('Update failed:', error, "title is ", error.responseJSON.title, "author is ", error.responseJSON.author);
        },
    });
}

$('.editable-cell').click(function () {
    const cell = $(this);
    const bookId = cell.data('id');
    const field = cell.data('field');
    const currentValue = cell.text();
    const newValue = prompt(`Edit ${field}:`, currentValue);
    if (newValue !== null && newValue !== currentValue) {
        updateBookField(bookId, field, newValue);
    }
});