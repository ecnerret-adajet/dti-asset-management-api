import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = (message) => {
    toast(message, {
        autoClose: 2000,
        position: toast.POSITION.BOTTOM_RIGHT,
        transition: toast.TRANSITIONS.SLIDE
    }); // ToastOptions
}

export function useToastr() {
    return {
        notify
    }
}
