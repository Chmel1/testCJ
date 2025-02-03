function sortTable(columnIndex){
    let table = document.querySelector("#myTable")
    let tbody = table.querySelector("tbody")
    let rows = Array.from(tbody.rows)
    let sortedColumn = null; // Отслеживание последнего отсортированного столбца
    let sortDirection = 1;   // 1 - по возрастанию, -1 по убыванию

    let isNumeric = !isNaN(parseFloat(rows[0].cells[columnIndex].textContent.trim()));

    if (sortedColumn === columnIndex) {
        sortDirection *= -1;
    } else {
        sortDirection = 1;
        sortedColumn = columnIndex;
    }


    rows.sort((rowA, rowB)=>
    {
        let cellA =rowA.cells[columnIndex].textContent.trim()
        let cellB = rowB.cells[columnIndex].textContent.trim()

        if (isNumeric) {
            return (parseFloat(cellA) - parseFloat(cellB)) * sortDirection;
        } else {
            return cellA.localeCompare(cellB, "ru") * sortDirection;
        }
    })
    tbody.innerHTML = "";
    tbody.append(...rows);
    
    updateTableHeaders(columnIndex, sortDirection);

    
}
function updateTableHeaders(columnIndex, direction) {
    let headers = document.querySelectorAll("#myTable th");
    headers.forEach((th, index) => {
        if (index === columnIndex) {
            th.textContent = th.textContent.replace(/ ▲| ▼/g, "") + (direction === 1 ? " ▲" : " ▼");
        } else {
            th.textContent = th.textContent.replace(/ ▲| ▼/g, "");
        }
    });
}