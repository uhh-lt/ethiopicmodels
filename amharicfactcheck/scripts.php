<script src="lib/sidebar/jquery.min.js.download"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="lib/sidebar/popper.js.download"></script>
<script src="lib/sidebar/bootstrap.min.js.download"></script>
<script src="lib/sidebar/main.js.download"></script>
<script defer="" src="lib/sidebar/beacon.min.js.download"></script>
<script src="lib/jquery.canvasjs.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>


<script>

    $('.carousel').carousel({
      interval: 1000 * 10
    });

    function changethumbsupcolor(x) {
        if ($(x).hasClass("fa-thumbs-up-hate")) {
            $(x).removeClass("fa-thumbs-up-hate")
            x.classList.toggle("fa-thumbs-up-fake");
        }
        else if ($(x).hasClass("fa-thumbs-up-fake")) {
            $(x).removeClass("fa-thumbs-up-fake")
            x.classList.toggle("fa-thumbs-up-normal");

        }
        else {
            $(x).removeClass("fa-thumbs-up-normal")
            $(x).removeClass("fa-thumbs-up-normal")
            x.classList.toggle("fa-thumbs-up-hate");
        }
    }
</script>
