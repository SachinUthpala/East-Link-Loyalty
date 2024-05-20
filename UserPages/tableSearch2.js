let currentPage = 1;
const rowsPerPage = 8;

function searchTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('myTable_2');
    const rows = Array.from(table.getElementsByTagName('tr')).slice(1);
    const filteredRows = rows.filter(row => {
        const cells = row.getElementsByTagName('td');
        return Array.from(cells).some(cell => cell.innerText.toLowerCase().includes(input));
    });
    displayRows(filteredRows);
}

function displayRows(rows) {
    const tbody = document.querySelector('#myTable_2 tbody');
    tbody.innerHTML = '';
    
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedRows = rows.slice(start, end);

    paginatedRows.forEach(row => tbody.appendChild(row));

    document.getElementById('page').innerText = `Page ${currentPage}`;
    document.getElementById('btn_prev').disabled = currentPage === 1;
    document.getElementById('btn_next').disabled = end >= rows.length;
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        searchTable();
    }
}

function nextPage() {
    const table = document.getElementById('myTable_2');
    const rows = Array.from(table.getElementsByTagName('tr')).slice(1);
    const input = document.getElementById('searchInput').value.toLowerCase();
    const filteredRows = rows.filter(row => {
        const cells = row.getElementsByTagName('td');
        return Array.from(cells).some(cell => cell.innerText.toLowerCase().includes(input));
    });

    if ((currentPage * rowsPerPage) < filteredRows.length) {
        currentPage++;
        searchTable();
    }
}

document.addEventListener('DOMContentLoaded', searchTable);
