
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}




// Account Box js started //

let accountBox = document.querySelector('.home-section .account_box');

document.querySelector('#user_btn').onclick = () =>
{
    accountBox.classList.toggle('active');
}

window.onscroll = () =>
{
    accountBox.classList.remove('active');
}
 


document.querySelector('#close-update').onclick = () =>{
  document.querySelector('.edit-product-form').style.display = 'none';
  window.location.href = 'admin_product.php';
}



document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
  inputNumber.oninput = () =>{
     if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
  };
});