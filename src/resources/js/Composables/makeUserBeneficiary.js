import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const makeUserBeneficiary = (userName,userId) => {

        Swal.fire({
            title: "Are you sure?",
            icon: "info",
            html: `<p style="font-size: 14px">You are to make ${userName} a Beneficiary.</p>`,
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
                    "/makeuserbeneficiary",
                    { userId: userId },
                    {
                        onSuccess: (page) => {
                            Swal.fire({
                                title: "Action Successfull.",
                                icon: "success",
                                html: `<p style="font-size: 14px">You have successfully made ${userName} a beneficiary.</p>`,
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

export default makeUserBeneficiary;
