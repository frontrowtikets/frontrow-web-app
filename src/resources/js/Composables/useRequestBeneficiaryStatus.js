import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";


const useRequestBeneficiaryStatus = (userId) => {
    Swal.fire({
        title: "Are you sure?",
        icon: "info",
        html: `<p style="font-size: 14px">You are about to submit a request to become a Beneficiary .</p>`,
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
            router.post(
                "/userbeneficiaryrequest",
                { userId: userId },
                {
                    onSuccess: (page) => {
                        Swal.fire({
                            title: "Action Successfull.",
                            icon: "success",
                            html: `<p style="font-size: 14px">You have successfully submitted a beneficiary request.</p>`,
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
                                Swal.close();
                                router.reload({
                                    preserveState: false,
                                });
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
                }
            );
        }
    });
};
export default useRequestBeneficiaryStatus;
