export default function useGetLowestPrice(showTimes) {
      const lowestShowTime = showTimes.reduce((lowest, current)=>{
        return current.ticket_price < lowest.ticket_price ? current: lowest
      }, showTimes[0]);

      return lowestShowTime;
}
