var UserService = {

  initLogin: function () {
    if (this._loginInitialized) return;
    this._loginInitialized = true;

    $(document).on("submit", "#login-form", function (e) {
      e.preventDefault();

      const entity = Object.fromEntries(
        new FormData(this).entries()
      );

      UserService.login(entity);
    });
  },

  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",

      success: function (result) {
        localStorage.setItem("user_token", result.data.token);

        $(".navbar").removeClass("hidden");

        UserService.generateMenuItems();

        window.location.hash = "#dashboard";
      },

      error: function (xhr) {
        toastr.error(
          xhr?.responseJSON?.message || "Invalid email or password"
        );
      }
    });
  },

  logout: function () {
    localStorage.removeItem("user_token");
    $(".navbar").addClass("hidden");
    window.location.hash = "#login";
  },

  generateMenuItems: function () {
    const token = localStorage.getItem("user_token");
    if (!token) {
      window.location.hash = "#login";
      return;
    }

    const user = Utils.parseJwt(token).user;
    const nav = document.querySelector(".navbar .wrap");

    nav.innerHTML = `
      <strong>FitTrack</strong>
      <span class="spacer"></span>

      <a href="#dashboard">Dashboard</a>
      <a href="#meals">Meals</a>
      <a href="#exercises">Exercises</a>
      <a href="#hydration">Hydration</a>
      <a href="#quotes">Quotes</a>

      <a href="#" class="logout">Logout</a>
    `;
  },

  applyRoleUI: function () {
    const token = localStorage.getItem("user_token");

    if (!token) {
      $(".admin-only").hide();
      return;
    }

    const user = Utils.parseJwt(token).user;

    if (user.role === "ADMIN") {
      $(".admin-only").show();
    } else {
      $(".admin-only").hide();
    }
  }
};

$(document).on("click", "a.logout", function (e) {
  e.preventDefault();
  UserService.logout();
});

$(window).on("hashchange", function () {
  setTimeout(function () {
    UserService.applyRoleUI();
  }, 50);
});

$(document).ready(function () {
  UserService.applyRoleUI();
});
