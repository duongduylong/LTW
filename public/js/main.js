function handleCheckboxClick(event) {
  const creditId = event.target.getAttribute('data-credit-id'); 
  const isChecked = event.target.checked; 
  
  myElement.style.display = "none";

  if (isChecked) {
      $.ajax({
          method: "POST",
          data: { credit_id: creditId },
          url:"http://localhost:3000/views/registerlist.php",
          success: function(data) {
              $("#cart-container").html(data);
          //   alert("Đã thêm sản phẩm vào giỏ hàng!");
          }
      });
      } else {
          $.ajax({
          method: "POST",
          data: { credit_id: creditId },
          url:"http://localhost:3000/views/removeproduct.php",
          success: function(data) {
              $("#cart-container").html(data);
          }
      });
      }
      
  }

