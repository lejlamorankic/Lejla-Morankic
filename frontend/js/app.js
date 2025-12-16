$(document).ready(function () {

  const app = $.spapp({
    defaultView: "login",
    templateDir: "views/"
  });

  app.route({ view: "login",     load: "login.html" });
  app.route({ view: "dashboard", load: "dashboard.html" });
  app.route({ view: "meals",     load: "meals.html" });
  app.route({ view: "exercises", load: "exercises.html" });
  app.route({ view: "hydration", load: "hydration.html" });
  app.route({ view: "quotes",    load: "quotes.html" });

  app.run();

  function updateActiveView() {
    let hash = location.hash.replace("#", "");
    if (!hash) hash = "login";

    $("main#spapp > section").removeClass("spapp-active");
    $("#" + hash).addClass("spapp-active");
  }

  updateActiveView();
  $(window).on("hashchange", updateActiveView);


  function syncNav() {
    const token = localStorage.getItem("user_token");

    if (!token || location.hash === "#login" || location.hash === "") {
      $("nav.navbar").addClass("hidden");
    } else {
      $("nav.navbar").removeClass("hidden");
    }
  }

  syncNav();
  $(window).on("hashchange", syncNav);


  function applyRoleUI() {
    const user = localStorage.getItem("user");

    if (!user) {
      $(".admin-only").hide();
      return;
    }

    const parsedUser = JSON.parse(user);

    if (parsedUser.role !== Constants.ADMIN_ROLE) {
      $(".admin-only").hide();
    } else {
      $(".admin-only").show();
    }
  }

  applyRoleUI();
  $(window).on("hashchange", function () {
    setTimeout(applyRoleUI, 50);
  });


  $(document).on("submit", "#loginForm", function (e) {
    e.preventDefault();

    const email = $("#email").val();
    const password = $("#password").val();

    if (!email || !password) {
      alert("Email and password are required");
      return;
    }

    RestClient.post(
      "/auth/login",
      { email: email, password: password },
      function (response) {

        localStorage.setItem("user_token", response.token);
        localStorage.setItem("user", JSON.stringify(response.user));

        location.hash = "#dashboard";
        syncNav();
        applyRoleUI();
      },
      function () {
        alert("Login failed");
      }
    );
  });


  $(document).on("click", "a.logout", function (e) {
    e.preventDefault();

    localStorage.removeItem("user_token");
    localStorage.removeItem("user");

    location.hash = "#login";
    syncNav();
  });


  function requireAuth() {
    const token = localStorage.getItem("user_token");
    if (!token) {
      location.hash = "#login";
      $("nav.navbar").addClass("hidden");
    }
  }

  $(window).on("hashchange", function () {
    if (location.hash !== "#login") {
      requireAuth();
    }
  });

  $(document).on("spapp:page", function (event, data) {
  if (data.page === "admin-users") {
    AdminUsersService.init();
  }
});


});
