import {computed} from 'vue';
export default function useCurrencyFormat(amount){
    const roundedAmount = Math.round(amount);
         return new Intl.NumberFormat("en-US", {
             minimumFractionDigits: 0,
             maximumFractionDigits: 0,
         }).format(roundedAmount);

}
