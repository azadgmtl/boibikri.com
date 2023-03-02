var navbar = document.querySelector('.header .navbar-nav');

var menu = document.querySelector('#menu_bars');

menu.onclick = () =>
{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};



var swiper = new Swiper(".home_slider", 
{
    grabCursor:true,
    loop:true,
    centeredSlides:true,
    navigation: 
    {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});






  





 window.onscroll = () =>
{
  if(window.scrollY > 70)
  {
    document.querySelector('#top_scroll').classList.add('active');
  }
  else
  {
    document.querySelector('#top_scroll').classList.remove('active');
  }
}





document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
  inputNumber.oninput = () =>{
     if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
  };
});