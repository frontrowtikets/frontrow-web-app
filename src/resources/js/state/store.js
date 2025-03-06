import { createStore } from "vuex";

import LoggedInUser from "./modules/LoggedInUser";
import PaymentDetails from "./modules/PaymentDetails";


const store = createStore({
    modules: {
        LoggedInUser,
        PaymentDetails,
    },

    // Enable strict mode in development to get a warning
    // when mutating state outside of a mutation.
    // https://vuex.vuejs.org/guide/strict.html
    strict: process.env.NODE_ENV !== "production",
});

export default store;
