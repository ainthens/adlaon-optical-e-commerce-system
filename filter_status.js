document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.order-sort-btn');
    const tableRows = document.querySelectorAll('#ordersTableBody tr');

    buttons.forEach(button => {
      button.addEventListener('click', function(e){
        const statusToShow = button.getAttribute('data-status');

        tableRows.forEach(row => {
          if (row.getAttribute('data-status') === statusToShow) {
            row.style.display = ''; // Show row
          } else {
            row.style.display = 'none'; // Hide row
          }
        });
      });
    });
    document.getElementById('show-all-btn').addEventListener('click', function(e){
  tableRows.forEach(row => {
    row.style.display = ''; // Show all rows
  });
});
  });
  