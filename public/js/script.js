let cityId = null;

// inclui a rota correta de remoção no modal de confirmação
//ao clicar no botão deletar de algum item da tabela
function updateDeleteConfirmationModal(url) {
    $("#form-delete").attr("action", url);
}

function initSelect2(id, value = []) {
    $(document).ready(function () {
        console.log(id);
        $(`#${id}`).val(value);
        $(`#${id}`).trigger("change");
    });
}

$(".btn-delete").on("click", function () {
    console.log("delete");
    const { url } = this.dataset;
    if (!url) return;
    console.log(url);
    updateDeleteConfirmationModal(url);
});

// controle de exibição select de instituições no cadastro de usuários
$("input[name=profile]").change(function () {
    if (this.value == "organization") {
        $(".organization-container").show(300);
    } else {
        $(".organization-container").hide(300);
    }
});
/**
 * vacancies.edit
 */
$("input[name=location_type]").change(function () {
    if (this.value == "specific_address") {
        $("#address-panel").removeClass("d-none");
    } else {
        $("#address-panel").addClass("d-none");
    }
});

// controle de select dinamico de cidades
$("select[name=address_state]").on("change", function (event) {
    const selectedStateAbbr = $(this).find(":selected").attr("value");
    // $(".loading").css("display", "block");
    $.ajax({
        url: `/state/${selectedStateAbbr}/cities/`,
        type: "GET",
        dataType: "json",
    }).done(function (data) {
        const citySelect = $("select[name=address_city]");
        citySelect.empty();
        citySelect.append(
            '<option value="0" >Por favor selecione uma cidade</option>'
        );

        $.each(data, function (key, value) {
            citySelect.append(
                `<option value=${value.id} ${cityId == value.id ? 'selected' : ''}>${
                    value.name
                }</option>`
            );
        });
        $(".loading").css("display", "none");
    });
});

$("input[name=address_zipcode]").on("change", function () {
    var selected = $(this).val();
    console.log(selected);
    $(".loading").removeClass("d-none");
    $.ajax({
        url: "http://viacep.com.br/ws/" + selected + "/json/",
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
            console.log(data);
            cityId = data.ibge;

            $("input[name=address_street]").val(data.logradouro);
            $("input[name=address_neighborhood]").val(data.bairro);
            $("select[name=address_state]").val(data.uf).change();
            $(".loading").addClass("d-none");
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            // Request failed. Show error message to user.
            // errorThrown has error message.
            cityId = null;
            console.log("erro");
            console.log(errorThrown);
            $(".loading").addClass("d-none");
        });
});

$(document).ready(function () {
    // Index page

    // $(".select2").select2({ allowClear: true });
    $(".date-input").inputmask("99/99/9999");
    $(".phone-input").inputmask("(99) 99999999[9]");
    $(".hour-input").inputmask("99:99");
    // $('.image-dropzone').dropzone();
    $('[data-toggle="tooltip"]').tooltip();

    // controle de multiplos telefones
    $(document.body).on("click", ".btn-remove-phone", function () {
        $(this).closest(".phone-input-group").remove();
        if ($(".phone-input-group").length <= 4) {
            $(".btn-add-phone").prop("disabled", false);
        }
    });

    $(".btn-add-phone").click(function () {
        addNewPhoneInput();
    });

    if ($(".phone-input-group").length > 4) {
        $(".btn-add-phone").prop("disabled", true);
    }

    $("input[name=fontawesome_icon_unicode]").on(
        "change paste keyup",
        function () {
            var icon_unicode = $(this).val();
            console.log(icon_unicode);
            $("div[name=category_icon]")
                .find("i")
                .html("&#x" + icon_unicode + ";");
        }
    );
});

// adiciona um novo input de telefone no form
function addNewPhoneInput() {
    var index = $(".phone-input-group").length;
    console.log(index);
    $(".phone-list").append(
        "" +
            '<div class="input-group phone-input-group">' +
            '<input type="text" id="phone-' +
            index +
            '" name="phones[' +
            index +
            ']" class="form-control" placeholder="(99) 999999999" />' +
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger btn-remove-phone" type="button"><i class="fas fa-times"></i></button>' +
            "</div>" +
            "</div>"
    );
    $("#phone-" + index).inputmask("(99) 99999999[9]");

    if (index >= 4) {
        $(".btn-add-phone").prop("disabled", true);
    }
}
