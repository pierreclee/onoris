document.addEventListener("DOMContentLoaded", () => {
    const burger = document.querySelector(".burger");
    const mobileMenu = document.querySelector(".mobile-menu");
    const closeBtn = document.querySelector(".close-menu");
    const backdrop = document.getElementById("mobile-backdrop");

    function openMenu() {
        mobileMenu.classList.add("open");
        backdrop.classList.add("visible");
        document.body.classList.add("menu-open");
}

    function closeMenu() {
        mobileMenu.classList.remove("open");
        backdrop.classList.remove("visible");
        document.body.classList.remove("menu-open");
    }

    burger.addEventListener("click", openMenu);
    closeBtn.addEventListener("click", closeMenu);
    backdrop.addEventListener("click", closeMenu);
});