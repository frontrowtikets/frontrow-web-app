const PaymentDetails = {
    namespaced: true,
    state: () => ({
        details: null,
    }),

    mutations: {
        savePaymentDetails(state, data) {
            state.details = data;
        }
    },

    actions: {},

    getters: {
        getPaymentDetails(state) {
            return state.details;
        },
    },
};

export default PaymentDetails;
