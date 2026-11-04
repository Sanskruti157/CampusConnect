// Client-side search and category filtering for the events page.
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const eventCards = document.querySelectorAll(".event-card[data-name]");
const noResults = document.getElementById("noResults");

function filterEvents() {
  if (!searchInput || !categoryFilter) return;

  const searchText = searchInput.value.toLowerCase().trim();
  const selectedCategory = categoryFilter.value;
  let visibleCount = 0;

  eventCards.forEach((card) => {
    const name = card.dataset.name;
    const category = card.dataset.category;
    const matchesName = name.includes(searchText);
    const matchesCategory = selectedCategory === "" || category === selectedCategory;
    const shouldShow = matchesName && matchesCategory;

    card.hidden = !shouldShow;
    if (shouldShow) visibleCount++;
  });

  if (noResults) noResults.hidden = visibleCount !== 0;
}

if (searchInput) searchInput.addEventListener("input", filterEvents);
if (categoryFilter) categoryFilter.addEventListener("change", filterEvents);

// A small client-side check before the browser submits the registration form.
const registrationForm = document.getElementById("registrationForm");
if (registrationForm) {
  registrationForm.addEventListener("submit", (event) => {
    const name = registrationForm.elements["student_name"].value.trim();
    if (name.length < 2) {
      event.preventDefault();
      alert("Please enter your full name.");
    }
  });
}
