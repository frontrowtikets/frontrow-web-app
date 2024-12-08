import {onMounted,onUnmounted} from 'vue';
export function useObserveHitBottom(ref, callback, options={}) {


  const hitBottomObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
          if (entry.isIntersecting) {
              callback();
          }
      });
  }, options);

  onMounted(() => {
      hitBottomObserver.observe(ref.value);
  });
  onUnmounted(() => {
      hitBottomObserver.disconnect();
  });


}
