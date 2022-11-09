document.addEventListener("DOMContentLoaded", function() {
    $(".close-nav, .burger, .overlay").click(function() {
        $(".overlay").toggleClass("show");
        $("nav").toggleClass("show");
        $("body").toggleClass("overflow");
    });
    $(document).ready(function() {
        $("#nav").on("click", "a", function(event) {
            event.preventDefault();
            var id = $(this).attr("href"),
                top = $(id).offset().top;
            $("body,html").animate({ scrollTop: top }, 1500);
            $(".overlay").removeClass("show");
            $("nav").removeClass("show");
            $("body").removeClass("overflow");
        });
    });
});

