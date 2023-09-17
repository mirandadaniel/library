function sortTable() {
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



// let currentSortDirectionTitle = 'asc'; // Initialize with 'asc' for title sorting
// let currentSortDirectionAuthor = 'asc'; // Initialize with 'asc' for author sorting

// function sortTableAuthor() {
//     console.log('sortTableAuthor function called');
//     const table = document.querySelector('.table');
//     const sortSelect = document.getElementById('sort');

//     const sortByAuthor = (a, b) => {
//         const authorA = a.cells[1].textContent.toLowerCase();
//         const authorB = b.cells[1].textContent.toLowerCase();
//         if (currentSortDirectionAuthor === 'asc') {
//             if (authorA < authorB) {
//                 return -1;
//             }
//             if (authorA > authorB) {
//                 return 1;
//             }
//         } else {
//             if (authorA < authorB) {
//                 return 1;
//             }
//             if (authorA > authorB) {
//                 return -1;
//             }
//         }

//         return 0;
//     };

//     const sortDirection = sortSelect.value;
//     const rows = Array.from(table.tBodies[0].rows);

//     rows.sort(sortByAuthor);

//     if (sortDirection === 'desc') {
//         rows.reverse();
//         currentSortDirectionAuthor = 'desc'; // Update the sorting direction for author column
//     } else {
//         currentSortDirectionAuthor = 'asc'; // Update the sorting direction for author column
//     }

//     for (const row of rows) {
//         table.tBodies[0].appendChild(row);
//     }
// }

// function sortTableTitle() {
//     console.log('sortTableTitle function called');
//     const table = document.querySelector('.table');
//     const sortSelect = document.getElementById('sort');

//     const sortByTitle = (a, b) => {
//         const titleA = a.cells[0].textContent.toLowerCase();
//         const titleB = b.cells[0].textContent.toLowerCase();

//         if (currentSortDirectionTitle === 'asc') {
//             if (titleA < titleB) {
//                 return -1;
//             }
//             if (titleA > titleB) {
//                 return 1;
//             }
//         } else {
//             if (titleA < titleB) {
//                 return 1;
//             }
//             if (titleA > titleB) {
//                 return -1;
//             }
//         }

//         return 0;
//     };

//     const sortDirection = sortSelect.value;
//     const rows = Array.from(table.tBodies[0].rows);

//     rows.sort(sortByTitle);

//     if (sortDirection === 'desc') {
//         rows.reverse();
//         currentSortDirectionTitle = 'desc'; // Update the sorting direction for title column
//     } else {
//         currentSortDirectionTitle = 'asc'; // Update the sorting direction for title column
//     }

//     for (const row of rows) {
//         table.tBodies[0].appendChild(row);
//     }
// }









// let currentSortDirection = 'asc'; 
// function sortTableAuthor() {
//     console.log('sortTable function called');
//     const table = document.querySelector('.table');
//     const sortSelect = document.getElementById('sort');

//     const sortByAuthor = (a, b) => {
//         const authorA = a.cells[1].textContent.toLowerCase();
//         const authorB = b.cells[1].textContent.toLowerCase();
//         if (currentSortDirection === 'asc') {
//             if (authorA < authorB) {
//                 return -1;
//             }
//             if (authorA > authorB) {
//                 return 1;
//             }
//         } else {
//             if (authorA < authorB) {
//                 return 1;
//             }
//             if (authorA > authorB) {
//                 return -1;
//             }
//         }

//         return 0;
//     };

//     const sortDirection = sortSelect.value;
//     const rows = Array.from(table.tBodies[0].rows); 

//     rows.sort(sortByAuthor);

//     if (sortDirection === 'desc') {
//         rows.reverse();
//     }

//     for (const row of rows) {
//         table.tBodies[0].appendChild(row); 
//     }
// }

// function sortTableTitle() {
//     console.log('sortTable function called');
//     const table = document.querySelector('.table'); 
//     const sortSelect = document.getElementById('sort');

//     const sortByTitle = (a, b) => {
//         const titleA = a.cells[0].textContent.toLowerCase();
//         const titleB = b.cells[0].textContent.toLowerCase();

//         if (titleA < titleB) {
//             return -1;
//         }
//         if (titleA > titleB) {
//             return 1;
//         }
//         return 0;
//     };

//     const sortDirection = sortSelect.value;
//     const rows = Array.from(table.tBodies[0].rows);

//     rows.sort(sortByTitle);

//     if (sortDirection === 'desc') {
//         rows.reverse();
//     }

//     for (const row of rows) {
//         table.tBodies[0].appendChild(row); 
//     }
// }


