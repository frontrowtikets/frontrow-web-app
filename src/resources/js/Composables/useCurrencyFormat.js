import {computed} from 'vue';
export default function useCurrencyFormat(amount){
       return new Intl.NumberFormat("en-US", {
           minimumFractionDigits: 2,
           maximumFractionDigits: 2,
       }).format(amount);

}
