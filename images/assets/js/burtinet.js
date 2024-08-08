function submitMSG(valid, msg) {
    if (valid) {
        Swal.fire(
            'Done!',
            msg,
            'success'
        )

    } else {
        Swal.fire(
            'Error!',
            msg,
            'error'
        )
    }
}

