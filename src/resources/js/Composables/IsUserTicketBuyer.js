import { usePage } from "@inertiajs/vue3";

const IsUserTicketBuyer = () => {
    const userPermissions = usePage().props.auth.user.allPermissions;

    if (userPermissions.includes("ticket_buyer")) {
        return true;
    } else {
        return false;
    }
};

export default IsUserTicketBuyer;
