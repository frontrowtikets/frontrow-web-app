import { usePage } from "@inertiajs/vue3";
import {computed} from "vue";

const IsUserBeneficiary = () => {

    const isBeneficiary = computed(()=>{
         if (usePage().props.auth.user.allPermissions.includes("beneficiary")) {
             return true;
         } else {
             return false;
         }
    })

    return {
        isBeneficiary,
    };
};

export default IsUserBeneficiary;
