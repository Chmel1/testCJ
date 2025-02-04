document.addEventListener("DOMContentLoaded", function () {
    alert("JS работает!");
});
console.log("JS подключился!");

let sortedColumn = -1; // Запоминаем последний отсортированный столбец
let sortDirection = 1; // 1 - по возрастанию, -1 - по убыванию

function sortTable(columnIndex) {
    console.log("Функция sortTable вызвана с columnIndex:", columnIndex);
    
    let table = document.querySelector("#myTable");
    let tbody = table.querySelector("tbody");
    let rows = Array.from(tbody.rows);

    if (rows.length === 0 || columnIndex >= rows[0].cells.length) {
        return; // Защита от ошибки, если колонка не существует
    }

    let isNumeric = !isNaN(parseFloat(rows[0].cells[columnIndex]?.textContent?.trim() || ""));

    // Изменение направления сортировки
    if (sortedColumn === columnIndex) {
        sortDirection *= -1;
    } else {
        sortDirection = 1;
        sortedColumn = columnIndex;
    }

    rows.sort((rowA, rowB) => {
        let cellA = rowA.cells[columnIndex].textContent.trim();
        let cellB = rowB.cells[columnIndex].textContent.trim();

        if (isNumeric) {
            return (parseFloat(cellA) - parseFloat(cellB)) * sortDirection;
        }
        return cellA.localeCompare(cellB, "ru") * sortDirection;
    });

    tbody.replaceChildren(...rows);

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
