
$(document).ready(function() {
  var app = $.spapp({ defaultView: "login", templateDir: "views/" });

  app.route({ view: "login",     load: "login.html" });
  app.route({ view: "dashboard", load: "dashboard.html" });
  app.route({ view: "meals",     load: "meals.html" });
  app.route({ view: "exercises", load: "exercises.html" });
  app.route({ view: "hydration", load: "hydration.html" });
  app.route({ view: "quotes",    load: "quotes.html" });

  app.run();
function updateActiveView() {
  var hash = location.hash.slice(1);
  if (!hash) hash = "login";
  $("main#spapp > section").removeClass("spapp-active");
  $("#" + hash).addClass("spapp-active");
}
updateActiveView();
$(window).on("hashchange", updateActiveView);


  function syncNav(){
    if(location.hash === "#login" || location.hash === ""){
      $("nav.navbar").addClass("hidden");
    } else {
      $("nav.navbar").removeClass("hidden");
    }
  }
  syncNav();
  $(window).on("hashchange", syncNav);

  $(document).on("submit", "#loginForm", function(e){
    e.preventDefault();
    location.hash = "#dashboard";
  });

  $(document).on("click", "a.logout", function(e){
    e.preventDefault();
    location.hash = "#login";
  });
});
