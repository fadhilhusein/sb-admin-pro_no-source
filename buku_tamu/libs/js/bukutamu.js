$(document).ready(function (e) {
    $("#preview-image").hide();
})

$("#photo-tamu").change(function (e) {
    // Sembunyikan place holder
    $("#place-holder").hide();

    // Ambil file objet dari input file & buat objectURL
    let file = e.target.files[0];

    let urlPhoto = URL.createObjectURL(file)
    $("#preview-image").attr("src", urlPhoto);
    $("#preview-image").show();
})

$('#form_buku').on("submit", function (e) {
    e.preventDefault();

    // Ambil element form
    const form = e.target;
    const formData = new FormData(form);
    formData.append('type', "input_tamu");

    $.ajax({
        type: "post",
        url: "../action/tamu.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            const data = JSON.parse(response);
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.type
            });

            $("#preview-image").hide();
            $("#place-holder").show();
            $("#form_buku").reset()
            return;
        }
    });
})