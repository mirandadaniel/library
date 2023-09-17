function sortTableAuthor() {
    console.log('sortTable function called');
    const table = document.querySelector('.table');
    const sortSelect = document.getElementById('sort');

    const sortByAuthor = (a, b) => {
        const authorA = a.cells[1].textContent.toLowerCase();
        const authorB = b.cells[1].textContent.toLowerCase();

        if (authorA < authorB) {
            return -1;
        }
        if (authorA > authorB) {
            return 1;
        }
        return 0;
    };

    const sortDirection = sortSelect.value;
    const rows = Array.from(table.tBodies[0].rows); 

    rows.sort(sortByAuthor);

    if (sortDirection === 'desc') {
        rows.reverse();
    }

    for (const row of rows) {
        table.tBodies[0].appendChild(row); 
    }
}

function sortTableTitle() {
    console.log('sortTable function called');
    const table = document.querySelector('.table'); 
    const sortSelect = document.getElementById('sort');

    const sortByAuthor = (a, b) => {
        const authorA = a.cells[1].textContent.toLowerCase();
        const authorB = b.cells[1].textContent.toLowerCase();

        if (authorA < authorB) {
            return -1;
        }
        if (authorA > authorB) {
            return 1;
        }
        return 0;
    };

    const sortDirection = sortSelect.value;
    const rows = Array.from(table.tBodies[0].rows);

    rows.sort(sortByAuthor);

    if (sortDirection === 'desc') {
        rows.reverse();
    }

    for (const row of rows) {
        table.tBodies[0].appendChild(row); 
    }
}


