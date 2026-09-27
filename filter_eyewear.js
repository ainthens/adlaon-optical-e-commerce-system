document.querySelectorAll('.filter-button').forEach(button => {
  button.addEventListener('click', () => {
    const category = button.getAttribute('data-filter'); 

   

   document.querySelectorAll('.filter-button').forEach(btn => {
      btn.classList.remove('active');
      btn.querySelector('img')?.classList.remove('active'); 
    });

    button.classList.add('active');
    button.querySelector('img')?.classList.add('active');

    fetch('products.php?category=' + category)
      .then(response => response.text())
      .then(data => {
        document.querySelector('.products-grid').innerHTML = data;
      })
      .catch(err => {
        document.querySelector('.products-grid').innerHTML = 'Error loading order details.';
      });
  });
});

window.addEventListener('DOMContentLoaded', () => {
  document.querySelector('.filter-button[data-filter="all"]').click();
});