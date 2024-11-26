import { createStore } from "vuex";

import LoggedInUser from "./modules/LoggedInUser";


const store = createStore({
    modules: {
        LoggedInUser,
 
    },

    // Enable strict mode in development to get a warning
    // when mutating state outside of a mutation.
    // https://vuex.vuejs.org/guide/strict.html
    strict: process.env.NODE_ENV !== "production",
});

export default store;
