document.addEventListener('DOMContentLoaded', function() {
    const transactionForm = document.getElementById('transactionForm');
    if (transactionForm) {
        const transactionId = new URLSearchParams(window.location.search).get('transaction_id');
        if (transactionId) {
            fetchTransaction(transactionId);
        }

        const categorySelect = document.getElementById('category');
        const typeSelect = document.getElementById('type');
        
        categorySelect.addEventListener('change', function() {
            updateTypeOptions();
        });
        
        updateTypeOptions(); // Initialize type options based on the default category

        transactionForm.addEventListener('submit', function(event) {
            event.preventDefault();
            saveTransaction(transactionId);
        });
    }

    fetchTransactions();
    fetchAnalysis();
    fetchProfileData();
});

function updateTypeOptions() {
    const category = document.getElementById('category').value;
    const typeSelect = document.getElementById('type');
    
    typeSelect.innerHTML = '';
    
    if (category === 'income') {
        const options = ['office', 'home', 'free-lancing', 'others'];
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            typeSelect.appendChild(opt);
        });
    } else if (category === 'expense') {
        const options = ['food', 'grocery', 'rent', 'bills', 'shopping', 'others'];
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            typeSelect.appendChild(opt);
        });
    }
}

function addTransaction() {
    const form = document.getElementById('transactionForm');
    const formData = new FormData(form);

    fetch('php/add_transaction.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        window.location.href = 'transaction_history.html';
    });
}

function fetchTransaction(transactionId) {
    fetch(`php/get_transaction_details.php?id=${transactionId}`)
        .then(response => response.json())
        .then(transaction => {
            document.getElementById('transactionId').value = transaction.id;
            document.getElementById('category').value = transaction.category;
            updateTypeOptions();
            document.getElementById('type').value = transaction.type;
            document.getElementById('sub_type').value = transaction.sub_type;
            document.getElementById('amount').value = transaction.amount;
            document.getElementById('transaction_date').value = transaction.transaction_date;
        });
}

function saveTransaction(transactionId) {
    const form = document.getElementById('transactionForm');
    const formData = new FormData(form);

    let url = 'php/add_transaction.php';
    if (transactionId) {
        url = `php/update_transaction.php?id=${transactionId}`;
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        window.location.href = 'transaction_history.html';
    });
}

function fetchTransactions() {
    fetch('php/get_transactions.php')
        .then(response => response.json())
        .then(transactions => {
            const tableBody = document.getElementById('transactionTable').querySelector('tbody');
            tableBody.innerHTML = '';
            let totalIncome = 0;
            let totalExpense = 0;
            transactions.forEach(transaction => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${transaction.category}</td>
                    <td>${transaction.type}</td>
                    <td>${transaction.sub_type}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.transaction_date}</td>
                    <td>
                        <button onclick="editTransaction(${transaction.id})">Edit</button>
                        <button onclick="deleteTransaction(${transaction.id})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
                
                // Calculate total income and expense
                if (transaction.category.toLowerCase() === 'income') {
                    totalIncome += parseFloat(transaction.amount);
                } else if (transaction.category.toLowerCase() === 'expense') {
                    totalExpense += parseFloat(transaction.amount);
                }
            });
            const totalAmount = totalIncome - totalExpense;
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        });
}

function editTransaction(id) {
    window.location.href = `add_edit_transaction.html?transaction_id=${id}`;
}

function deleteTransaction(id) {
    fetch('php/delete_transaction.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `transaction_id=${id}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchTransactions();
    });
}

function fetchAnalysis() {
    fetch('php/analysis.php')
        .then(response => response.json())
        .then(data => {
            renderCharts(data);
        });
}

function renderCharts(data) {
    const ctx1 = document.getElementById('incomeExpenseChart');
    const ctx2 = document.getElementById('incomeCategoryChart');
    const ctx3 = document.getElementById('expenseCategoryChart');

    if (ctx1 && ctx2 && ctx3) {
        const ctx1Context = ctx1.getContext('2d');
        const ctx2Context = ctx2.getContext('2d');
        const ctx3Context = ctx3.getContext('2d');

        new Chart(ctx1Context, {
            type: 'bar',
            data: {
                labels: ['Total Income', 'Total Expense'],
                datasets: [{
                    label: 'Amount',
                    data: [data.total_income, data.total_expense],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx2Context, {
            type: 'bar',
            data: {
                labels: ['Office', 'Home', 'Free-lancing', 'Others'],
                datasets: [{
                    label: 'Income Categories',
                    data: [data.office_income, data.home_income, data.freelancing_income, data.other_income],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx3Context, {
            type: 'bar',
            data: {
                labels: ['Food', 'Grocery', 'Rent', 'Bills', 'Shopping', 'Others'],
                datasets: [{
                    label: 'Expense Categories',
                    data: [data.food_expense, data.grocery_expense, data.rent_expense, data.bills_expense, data.shopping_expense, data.other_expense],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        console.error('Chart canvas elements not found');
    }
}

function fetchProfileData() {
    if (window.location.pathname.includes('profile.html')) {
        fetch('php/get_profile.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name;
                document.getElementById('username').value = data.username;
                document.getElementById('email').value = data.email;
            });
    }
}

function updateProfile() {
    const form = document.getElementById('profileForm');
    const formData = new FormData(form);

    fetch('php/update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchProfileData();
    });
}

function logout() {
    fetch('php/logout.php')
        .then(() => {
            window.location.href = 'login.html';
        });
}

// Function to export table data as CSV
function exportCSV() {
    let table = document.getElementById("transactionTable");
    let rows = Array.from(table.rows);
    let csv = rows.map((row, rowIndex) => {
        let cells = Array.from(row.cells);
        if (rowIndex === 0) {
            // Header row, exclude the "Actions" column
            return cells.slice(0, -1).map(cell => `"${cell.innerText}"`).join(",");
        } else {
            // Data rows, exclude the "Actions" column and format date
            return cells.slice(0, -1).map((cell, cellIndex) => {
                if (cellIndex === 4) { // Date column index
                    let dateParts = cell.innerText.split("-");
                    let formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                    return `"${formattedDate}"`;
                }
                return `"${cell.innerText}"`;
            }).join(",");
        }
    }).join("\n");

    let csvFile = new Blob([csv], { type: "text/csv" });
    let downloadLink = document.createElement("a");
    downloadLink.download = "transaction_history.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}