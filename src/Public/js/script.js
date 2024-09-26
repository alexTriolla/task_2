$(document).ready(function () {
  new Sortable(document.getElementById('logoContainer'), {
    animation: 150,
    ghostClass: 'sortable-ghost',
  });

  $('#saveOrder').click(function () {
    var order = [];
    $('#logoContainer .logo-item').each(function () {
      order.push($(this).data('id'));
    });

    $.ajax({
      url: 'saveOrder.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ order: order }),
      success: function (response) {
        alert(response);
      },
      error: function () {
        alert('Failed to save order.');
      },
    });
  });
});
