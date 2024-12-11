import { router } from "@inertiajs/vue3";

export default function useScheduleEventsPage() {
      document.body.classList.toggle("sidebar-enable");
      router.get(route("schedule_events_page"));
}
