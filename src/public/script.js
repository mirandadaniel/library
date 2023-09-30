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

    let currentSortDirection = 'asc';

    
    function sortTable(columnName) {
        currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
        rows.sort((a, b) => {
            const aValue = a.querySelector(`[data-field="${columnName}"]`).textContent;
            const bValue = b.querySelector(`[data-field="${columnName}"]`).textContent;

            if (currentSortDirection === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });

        headers.forEach(header => {
            header.classList.remove('sorted-asc', 'sorted-desc');
        });

        const column = table.querySelector(`th[data-column="${columnName}"]`);
        column.classList.add(`sorted-${currentSortDirection}`);

        const tbody = table.querySelector('tbody');
        rows.forEach(row => {
            tbody.appendChild(row);
        });
    }

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const columnName = header.getAttribute('data-column');
            sortTable(columnName);
        });
    });
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
    
    // Prompt the user for a new value
    const newValue = prompt(`Edit ${field}:`, currentValue);
    
    if (newValue !== null && newValue !== currentValue) {
        // Check if the new value is empty
        if (newValue.trim() === '') {
            alert('Value cannot be left blank');
            return; // Do not proceed with the update
        }

        // Proceed with the update if the new value is not empty
        updateBookField(bookId, field, newValue);
    }
});


// $('.editable-cell').click(function () {
//     const cell = $(this);
//     const bookId = cell.data('id');
//     const field = cell.data('field');
//     const currentValue = cell.text();
//     const newValue = prompt(`Edit ${field}:`, currentValue);
//     if (newValue !== null && newValue !== currentValue) {
//         updateBookField(bookId, field, newValue);
//     }
// });

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const table = document.querySelector('.table');
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    searchInput.addEventListener('input', function () {
        console.log("in search")
        const searchTerm = searchInput.value.toLowerCase();
        console.log("search term is: ", searchTerm)

        rows.forEach((row) => {
            const titleElement = row.querySelector('[data-field="title"]');
            const authorElement = row.querySelector('[data-field="author"]');
            const title = titleElement.textContent.toLowerCase();
            const author = authorElement.textContent.toLowerCase();

            if (titleElement && authorElement) {
                const title = titleElement.textContent.toLowerCase();
                const author = authorElement.textContent.toLowerCase();
                console.log("title is: , author is: , search term is: ", title, author, searchTerm)

                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    row.style.display = '';
                    console.log("match found!")
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});

