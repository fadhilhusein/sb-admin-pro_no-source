function updateClock() {
    const now = new Date();
    const hours = now.getHours();
    const minute = now.getMinutes().toString().padStart(2, '0');
    const second = now.getSeconds().toString().padStart(2, '0');
    
    $("#time-view").html(`${hours}:${minute}:${second}`);
}

$(".btn_checkout").click(function() {
    let tabel_tamu = document.querySelector(".tabel_tamu");
    let id_tamu = $(this).attr('id');
    let data = {
        type: "check_out",
        id_tamu: id_tamu
    };

    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin melakukan check out?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../action/tamu.php",
                type: "POST",
                data: data,
                success: (response) => {
                    let res = JSON.parse(response);
                    if (res.type === "success") {
                        Swal.fire({
                            title: res.title,
                            text: res.message,
                            icon: res.type,
                            confirmButtonText: "OK"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: res.title,
                            text: res.message,
                            icon: res.type,
                            confirmButtonText: "OK"
                        });
                    }
                }
            })
        }
    })
})

setInterval(() => {
    updateClock();
}, 1000);

updateClock();