const basicAlert = (message, title, icon = "success") => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        showConfirmButton: false,
        timer: 3000
    });
}

export function useSweetAlert() {
    return {
        basicAlert
    }
}
