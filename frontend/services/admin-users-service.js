var AdminUsersService = {

  init: function () {
    const token = localStorage.getItem("user_token");
    if (!token) return;

    const user = Utils.parseJwt(token).user;

    if (user.role !== "ADMIN") {
      window.location.hash = "#dashboard";
      toastr.error("Access denied");
      return;
    }

    AdminUsersService.loadUsers();
  },

  loadUsers: function () {
    RestClient.get(
      "users",
      function (response) {
        AdminUsersService.renderTable(response);
      },
      function () {
        toastr.error("Failed to load users");
      }
    );
  },

  renderTable: function (users) {
    Utils.datatable(
      "users-table",
      [
        { data: "id" },
        { data: "name" },
        { data: "email" },
        { data: "role" },
        {
          data: null,
          render: function (data, type, row) {
            return `
              <button class="btn btn-danger btn-sm"
                onclick="AdminUsersService.deleteUser(${row.id})">
                Delete
              </button>
            `;
          }
        }
      ],
      users
    );
  },

  deleteUser: function (id) {
    if (!confirm("Are you sure?")) return;

    RestClient.delete(
      "users/" + id,
      null,
      function () {
        toastr.success("User deleted");
        AdminUsersService.loadUsers();
      },
      function () {
        toastr.error("Delete failed");
      }
    );
  }
};
