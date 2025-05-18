const showKatalogBtn = document.getElementById("showKatalogBtn");
const heroSection = document.getElementById("hero-section");
const katalogSection = document.getElementById("katalog");

showKatalogBtn.addEventListener("click", () => {
  heroSection.classList.add("d-none"); // Sembunyikan hero section
  katalogSection.classList.remove("d-none"); // Tampilkan katalog section
});

document.addEventListener("DOMContentLoaded", function () {
  const pekerjaanLink = document.getElementById("link-pekerjaan");
  const pekerjaanSection = document.getElementById("pekerjaan");

  if (pekerjaanLink && pekerjaanSection) {
    pekerjaanLink.addEventListener("click", function (event) {
      event.preventDefault();

      pekerjaanSection.scrollIntoView({ behavior: "smooth" });
    });
  }
});
