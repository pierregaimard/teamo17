import "../../styles/home/home.scss";

const brandLinkElem = document.querySelector(".navbar-brand a");
const homeBrandSection = document.querySelector(".app-brand-title");

brandLinkElem.style.opacity = "0";

document.addEventListener("scroll", () => {
  if (window.scrollY < 600) {
    brandLinkElem.style.opacity = String((window.scrollY / 600).toFixed(2));
    homeBrandSection.style.opacity = String(
      (1 - window.scrollY / 400).toFixed(2)
    );
  }
});
