document.addEventListener("DOMContentLoaded", () => {
  const results = document.getElementById("dentist-results");
  const input = document.getElementById("dentist-search");
  const searchButton = document.getElementById("dentist-search-btn");
  const stateButtons = document.querySelectorAll(".state-button");
  if (!results || !input || !searchButton || !window.dentistLocator) return;

  let controller = null;

  async function fetchDentists(type, value) {
    value = String(value || "").trim();
    if (!value) {
      results.textContent = "Enter a search term or choose a state.";
      return;
    }

    if (controller) controller.abort();
    controller = new AbortController();

    const data = new FormData();
    data.append("action", "dl_fetch_dentists");
    data.append("nonce", dentistLocator.nonce);
    data.append("filter_type", type);
    data.append("filter_value", value);

    results.setAttribute("aria-busy", "true");
    results.textContent = dentistLocator.i18n.loading;

    try {
      const response = await fetch(dentistLocator.ajaxUrl, {
        method: "POST",
        body: data,
        credentials: "same-origin",
        signal: controller.signal,
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const payload = await response.json();
      if (!payload.success || !payload.data || typeof payload.data.html !== "string") {
        throw new Error("Invalid response");
      }
      results.innerHTML = payload.data.html;
    } catch (error) {
      if (error.name !== "AbortError") {
        results.textContent = dentistLocator.i18n.error;
      }
    } finally {
      results.removeAttribute("aria-busy");
    }
  }

  function selectState(button) {
    stateButtons.forEach((item) => item.setAttribute("aria-pressed", "false"));
    button.setAttribute("aria-pressed", "true");
    fetchDentists("state", button.dataset.state);
  }

  stateButtons.forEach((button) => {
    button.setAttribute("aria-pressed", "false");
    button.addEventListener("click", () => selectState(button));
  });

  searchButton.addEventListener("click", () => fetchDentists("search", input.value));
  input.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      event.preventDefault();
      fetchDentists("search", input.value);
    }
  });
});
