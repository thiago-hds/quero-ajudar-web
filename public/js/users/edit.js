$("input[name=profile]").change(function () {
    if (this.value == "1") {
        $("#organization_div").show(400);
    } else {
        $("#organization_div").hide(400);
    }
});
