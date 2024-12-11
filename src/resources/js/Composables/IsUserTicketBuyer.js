import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const IsUserTicketBuyer = () => {

    const isTicketBuyer = computed(()=>{
         if (usePage().props.auth.user.allPermissions.includes("ticket_buyer")) {
             return true;
         } else {
             return false;
         }
    })

    return {
        isTicketBuyer,
    };
};

export default IsUserTicketBuyer;
