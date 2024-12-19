document.addEventListener("DOMContentLoaded", () => {
  // Hamburger menu functionality
  const hamburger = document.querySelector(".hamburger-icon");
  const menu = document.querySelector(".fullscreen-menu");
  const body = document.body;
  const menuItems = document.querySelectorAll<HTMLElement>('.menu-left nav ul li');
  const recipeItems = document.querySelectorAll<HTMLElement>('.menu-right .recipe-preview');

  if (hamburger && menu) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("open");
      menu.classList.toggle("open");
      body.classList.toggle("menu-open");

      if (menu.classList.contains('open')) {
        menuItems.forEach((item, index) => {
          item.classList.add(`animate-item-${index}`);
        });

        recipeItems.forEach((item, index) => {
          item.classList.add(`animate-item-${index}`);
        });
      } else {
        menuItems.forEach((item, index) => {
          item.classList.remove(`animate-item-${index}`);
        });

        recipeItems.forEach((item, index) => {
          item.classList.remove(`animate-item-${index}`);
        });
      }
    });
  }

  // Recipe ingredients functionality
const ingredientItems = document.querySelectorAll('.ingredient-checkbox');
if (ingredientItems.length > 0) {
    ingredientItems.forEach((checkbox) => {
        checkbox.addEventListener('change', (e) => {
            const target = e.target as HTMLInputElement;
            const listItem = target.closest('li');
            const recipeContainer = document.querySelector('.recipe-layout');
            const recipeId = recipeContainer?.getAttribute('data-post-id');

            if (listItem && recipeId) {
                // Uppdatera utseendet
                if (target.checked) {
                    listItem.classList.add('checked');
                } else {
                    listItem.classList.remove('checked');
                }

                // Spara i localStorage
                const checkedBoxes = Array.from(ingredientItems)
                    .map((item, index) => ((item as HTMLInputElement).checked ? index : -1))
                    .filter(index => index !== -1);

                localStorage.setItem(`recipe-${recipeId}`, JSON.stringify(checkedBoxes));
            }
        });
    });

    // Ladda sparade val från localStorage om det finns
    const recipeContainer = document.querySelector('.recipe-layout');
    if (recipeContainer) {
        const recipeId = recipeContainer.getAttribute('data-post-id');
        if (recipeId) {
            const savedIngredients = localStorage.getItem(`recipe-${recipeId}`);
            if (savedIngredients) {
                const checkedIndexes = JSON.parse(savedIngredients);
                ingredientItems.forEach((checkbox, index) => {
                    if (checkedIndexes.includes(index)) {
                        (checkbox as HTMLInputElement).checked = true;
                        const listItem = checkbox.closest('li');
                        if (listItem) {
                            listItem.classList.add('checked');
                        }
                    }
                });
            }
        }
    }
}
});