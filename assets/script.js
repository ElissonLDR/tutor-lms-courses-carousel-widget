function initMaskavoSwiper(){
  document.querySelectorAll(".maskavo-swiper").forEach(carousel=>{
    if (carousel.swiper) return;

    const slidesDesktop = parseInt(carousel.dataset.desktop) || 4;
    const slidesTablet  = parseInt(carousel.dataset.tablet)  || 2;
    const slidesMobile  = parseInt(carousel.dataset.mobile)  || 1;
    const autoplay      = (carousel.dataset.autoplay === "yes");
    const loop          = (carousel.dataset.loop === "yes");
    const gap           = parseInt(carousel.dataset.gap) || 20;

    carousel.swiper = new Swiper(carousel,{
      slidesPerView: slidesDesktop,
      spaceBetween: gap,
      loop: loop,
      autoplay: autoplay ? { delay: 4000, disableOnInteraction: false } : false,
      navigation: {
        nextEl: carousel.querySelector(".swiper-button-next"),
        prevEl: carousel.querySelector(".swiper-button-prev"),
      },
      pagination: {
        el: carousel.querySelector(".swiper-pagination"),
        clickable: true
      },
      breakpoints: {
        1024: { slidesPerView: slidesDesktop, spaceBetween: gap },
        768:  { slidesPerView: slidesTablet,  spaceBetween: gap },
        0:    { slidesPerView: slidesMobile,  spaceBetween: gap }
      }
    });
  });
}

document.addEventListener("DOMContentLoaded", initMaskavoSwiper);
window.addEventListener("elementor/frontend/init", ()=>{
  elementorFrontend.hooks.addAction("frontend/element_ready/global", initMaskavoSwiper);
});
