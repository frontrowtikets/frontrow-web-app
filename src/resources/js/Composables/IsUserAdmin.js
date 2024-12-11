import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";


const IsUserAdmin =() => {

      const isAdmin = computed(() => {
          if (usePage().props.auth.user.allPermissions.includes("s_admin") || usePage().props.auth.user.allPermissions.includes("admin")) {
              return true;
          } else {
              return false;
          }
      });

      return {
          isAdmin,
      };

}

export default IsUserAdmin;
