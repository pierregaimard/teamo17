const navbarMobileMenuElem = document.querySelector(".navbar-mobile-menu");
const navbarButtonElem = document.querySelector(".navbar-button");
const navbarMenuItems = document.querySelectorAll(
  ".navbar-menu .navbar-menu-item"
);

let isMenuOpen = false;

const setMobileMenu = () => {
  const mobileMenuItems = Array.from(navbarMenuItems).map((elem) =>
    createMobileMenuElem(elem)
  );

  navbarMobileMenuElem.append(...mobileMenuItems);
};

const createMobileMenuElem = (menuElem) => {
  const li = document.createElement("li");
  li.append(menuElem.cloneNode(true));

  return li;
};

const displayMenu = () => {
  navbarMobileMenuElem.classList.remove("hidden");
  navbarMobileMenuElem.classList.add("visible");
  isMenuOpen = true;
  console.log("display");
};

const hideMenu = () => {
  navbarMobileMenuElem.classList.remove("visible");
  navbarMobileMenuElem.classList.add("hidden");
  isMenuOpen = false;
  console.log("hide");
};

setMobileMenu();

navbarButtonElem.addEventListener("click", (event) => {
  event.stopPropagation();
  isMenuOpen ? hideMenu() : displayMenu();
});

window.addEventListener("click", (event) => {
  if (
    event.target.closest(".navbar-mobile ul") &&
    !(event.target instanceof HTMLAnchorElement)
  ) {
    return;
  }

  hideMenu();
});
