import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const useInertiaFormSubmit = (payload = {}, endpoint = "", successEndpoint = "/", approveText = "", successText = "") => {
    Swal.fire({
        title: "Are you sure?",
        icon: "info",
        html: `<p style="font-size: 14px">${approveText}.</p>`,
        showCancelButton: true,
        focusConfirm: true,
        confirmButtonText: "Yes, Proceed",
        confirmButtonColor: "#43ad60",
        allowOutsideClick: false,
        allowEscapeKey: false,
        closeOnClickOutside: false,
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: "Please wait...",
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            router.post(endpoint, payload, {
                onSuccess: (page) => {
                    Swal.fire({
                        title: "Action Successfull.",
                        icon: "success",
                        html: `<p style="font-size: 14px">${successText}.</p>`,
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#43ad60",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    }).then((result) => {

                            Swal.close();
                            if (successEndpoint === 'reload'){
                                router.reload();
                            }else{
                                 router.get(`${successEndpoint}`);
                            }

                    });
                },
                onError: (errors) => {
                    Swal.fire({
                        title: "Something Went Wrong",
                        icon: "error",
                        html: `<p style="font-size: 14px">There is something that went wrong and it is not your fault. Please, reach out to Support for help.</p>`,
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#43ad60",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    }).then((result) => {
                        if (result.value) {
                            router.reload({
                                preserveState: false,
                            });
                        }
                    });
                },
                preserveState:false,
                preserveScroll:true
            });
        }
    });
};
export default useInertiaFormSubmit;
