import { usePage } from "@inertiajs/vue3";

const IsUserBeneficiary = () => {
    const userPermissions = usePage().props.auth.user.allPermissions;

    if (userPermissions.includes("beneficiary")) {
        return true;
    } else {
        return false;
    }
};

export default IsUserBeneficiary;
