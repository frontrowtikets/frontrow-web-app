import { router } from "@inertiajs/vue3";

export default function useScheduleMoviesPage() {
    document.body.classList.toggle("sidebar-enable");
    router.get(route("schedule_movies_page"));
}
