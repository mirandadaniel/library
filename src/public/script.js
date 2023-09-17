document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.table');
    const headers = table.querySelectorAll('th[data-column]');
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    let currentSortColumn = null;
    let currentSortDirection = 'asc';

    function sortTable(column) {
        const columnIndex = Array.from(headers).indexOf(column);
        const columnName = column.getAttribute('data-column');

        rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].textContent.toLowerCase();
            const cellB = b.cells[columnIndex].textContent.toLowerCase();

            if (currentSortDirection === 'asc') {
                return cellA.localeCompare(cellB);
            } else {
                return cellB.localeCompare(cellA);
            }
        });

        rows.forEach(row => {
            table.tBodies[0].appendChild(row);
        });

        currentSortColumn = columnName;
        currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
    }

    headers.forEach(header => {
        header.addEventListener('click', () => {
            sortTable(header);
        });
    });

    sortTable(headers[0]);
});

document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.table');
    const headers = table.querySelectorAll('th[data-column]');
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const searchInput = document.getElementById('search');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const title = row.cells[0].textContent.toLowerCase();
            const author = row.cells[1].textContent.toLowerCase();

            if (title.includes(searchText) || author.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
});
