export default function useGetLowestEventTicket(showTimes) {
    const lowestShowTime = showTimes.reduce((lowest, current)=>{
      return current.price < lowest.price ? current: lowest
    }, showTimes[0]);

    return lowestShowTime;
}
