import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useObserveHitBottom } from "./useObserveHitBottom.js";

export function useInfiniteScroll(propName, elementRef = null, ) {
          const propValue = () => usePage().props[propName];
          const paginatedItems = ref(propValue()?.data);
          const initialUrl = usePage().url;
          let observerListner = null;

          const nextPageExists = computed(() => propValue().next_page_url !== null);

          const loadMoreItems = () => {
              if (!nextPageExists.value) {
                  return;
              }
              router.get(
                  propValue().next_page_url,
                  {},
                  {
                      preserveState: true,
                      preserveScroll: true,
                      onSuccess: () => {
                          window.history.replaceState({}, "", initialUrl);
                          paginatedItems.value = [...paginatedItems.value, ...propValue().data];
                      },
                  }
              );
          };

          if (elementRef != null) {
              useObserveHitBottom(elementRef, loadMoreItems, { rootMargin: "0px 0px 0px 0px" });
          }

          return {
              paginatedItems,
              loadMoreItems,
              //incase of filtering call reset when propvalue has changed
              reset: () => (paginatedItems.value = propValue().data),
              nextPageExists,
          };

}
