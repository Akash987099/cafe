document.addEventListener("DOMContentLoaded", function () {
    const tableWrappers = document.querySelectorAll(".table-responsive");

    tableWrappers.forEach(function (wrapper, index) {
        const table = wrapper.querySelector("table");
        const tbody = table ? table.querySelector("tbody") : null;

        if (!table || !tbody) {
            return;
        }

        const card = wrapper.closest(".card");
        const cardHeader = card ? card.querySelector(".card-header") : null;
        const pagination = wrapper.querySelector(":scope > .mt-4") || wrapper.querySelector(".table-pagination-footer");

        if (!cardHeader) {
            return;
        }

        let actions = cardHeader.querySelector(".table-search-actions");
        if (!actions) {
            actions = document.createElement("div");
            actions.className = "d-flex align-items-center gap-2 table-search-actions";
            cardHeader.appendChild(actions);
        }

        let searchInput =
            cardHeader.querySelector("[data-table-search]") ||
            cardHeader.querySelector("#searchInput");

        if (!searchInput) {
            searchInput = document.createElement("input");
            searchInput.type = "search";
            searchInput.placeholder = "Search...";
            searchInput.setAttribute("data-table-search", "true");
            searchInput.className = "form-control form-control-sm";
            actions.appendChild(searchInput);
        } else {
            searchInput.setAttribute("data-table-search", "true");
            if (!searchInput.parentElement || searchInput.parentElement !== actions) {
                actions.appendChild(searchInput);
            }
        }

        const originalRows = Array.from(tbody.querySelectorAll("tr")).filter(function (row) {
            return !row.hasAttribute("data-search-empty");
        });

        let emptyRow = tbody.querySelector("[data-search-empty]");
        if (!emptyRow) {
            emptyRow = document.createElement("tr");
            emptyRow.setAttribute("data-search-empty", "true");
            emptyRow.style.display = "none";

            const emptyCell = document.createElement("td");
            emptyCell.colSpan = table.querySelectorAll("thead th").length || 1;
            emptyCell.className = "text-center text-muted py-4";
            emptyCell.textContent = "No matching records found.";

            emptyRow.appendChild(emptyCell);
            tbody.appendChild(emptyRow);
        }

        const filterTable = function () {
            const query = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            originalRows.forEach(function (row) {
                const text = row.textContent.toLowerCase().replace(/\s+/g, " ").trim();
                const isVisible = query === "" || text.includes(query);

                row.style.display = isVisible ? "" : "none";

                if (isVisible) {
                    visibleCount += 1;
                }
            });

            emptyRow.style.display = visibleCount === 0 ? "" : "none";

            if (pagination) {
                pagination.style.display = query === "" ? "" : "none";
            }
        };

        if (!searchInput.dataset.tableSearchBound) {
            searchInput.addEventListener("input", filterTable);
            searchInput.dataset.tableSearchBound = "1";
        }

        wrapper.dataset.tableSearchIndex = String(index);
        filterTable();
    });
});
