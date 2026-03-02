document.addEventListener("DOMContentLoaded", function () {
  const results = document.getElementById("dentist-results");
  const mapStates = document.querySelectorAll("#states > path, #states > g");
  const searchInput = document.getElementById("dentist-search");
  const searchBtn = document.getElementById("dentist-search-btn");

  function fetchDentists(type, value) {
    let data = new FormData();
    data.append("action", "fetch_dentists");
    data.append("filter_type", type);
    data.append("filter_value", value);

    results.innerHTML = "<p>Loading...</p>";

    fetch(dentistLocatorAjax.ajax_url, { method: "POST", body: data })
      .then((res) => res.text())
      .then((html) => (results.innerHTML = html));
  }

  mapStates.forEach(function (el) {
    el.addEventListener("click", function () {
      mapStates.forEach((p) => p.classList.remove("active"));
      this.classList.add("active");
      fetchDentists("state", this.id);
    });
  });

  function performSearch() {
    mapStates.forEach((p) => p.classList.remove("active"));
    fetchDentists("search", searchInput.value.trim());
  }

  searchBtn.addEventListener("click", performSearch);

  searchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      performSearch();
    }
  });
});
