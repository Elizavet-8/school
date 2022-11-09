$(function() {
    $(".nav-treeview .nav-link, .nav-link").each(function() {
        var location2 =
            window.location.protocol +
            "//" +
            window.location.host +
            window.location.pathname;
        var link = this.href;
        if (link == location2) {
            $(this).addClass("active");
            $(this)
                .parent()
                .parent()
                .parent()
                .addClass("menu-is-opening menu-open");
        }
    });

    $(".delete-btn").click(function() {
        var res = confirm(
            "Удаленную запись невозможно будет восстановить. Вы действительно хотите удалить ее?"
        );
        if (!res) {
            return false;
        }
    });
});

function generatePassword() {
    const randomstring = Math.random()
        .toString(36)
        .substr(2, 10);

    $("#password_input").val(randomstring);
}
