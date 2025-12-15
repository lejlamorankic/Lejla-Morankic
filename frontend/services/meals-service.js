var MealsService = {

  init: function () {
    MealsService.getAll();
  },

  getAll: function () {
    RestClient.get("meals", function (response) {
      MealsService.renderMeals(response.data);
    });
  },

  renderMeals: function (meals) {
    const list = $("#meals-list");
    list.empty();

    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token).user;
    const isAdmin = user.role === Constants.ADMIN_ROLE;

    meals.forEach(meal => {
      let li = `
        <li>
          <strong>${meal.name}</strong> – ${meal.calories} kcal
      `;

      if (isAdmin) {
        li += `
          <span class="admin-only" style="margin-left:10px;">
            <button class="btn btn-small edit-meal" data-id="${meal.id}">
              Edit
            </button>
            <button class="btn btn-small delete-meal" data-id="${meal.id}">
              Delete
            </button>
          </span>
        `;
      }

      li += `</li>`;
      list.append(li);
    });
  }

};
