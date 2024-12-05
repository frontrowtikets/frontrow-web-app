import { usePage } from "@inertiajs/vue3";

const IsUserAdmin =() => {
    const userPermissions = usePage().props.auth.user.allPermissions

      if (userPermissions.includes("s_admin") || userPermissions.includes("admin")) {
          return true;
      } else {
          return false;
      }
   
}

export default IsUserAdmin;
