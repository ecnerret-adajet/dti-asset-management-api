const basicAlert = (message, title, icon = "success") => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        showConfirmButton: false,
        timer: 3000,
        customClass: {
            popup: 'swal2-center',
            icon: 'swal2-icon-center'
        }
    });
}

const confirmAlert = (message, title, icon = "warning") => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirm",
    });
}

export function useSweetAlert() {
    return {
        basicAlert,
        confirmAlert
    }
}
