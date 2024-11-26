const LoggedInUser = {
    namespaced: true,
    state: () => ({
        userDetails: {},
        staffRegisterProfiles: [],
        iwillSign: 1,
        currentUrl:""
    }),

    mutations: {
        storeLoggedInUserDetails(state, data) {
            state.userDetails = data;
        },
        appendStaffProfiles(state, data) {
            state.staffRegisterProfiles = [...state.staffRegisterProfiles, ...data];
        },
        searchResultsStaffProfiles(state, data) {
            state.staffRegisterProfiles = data;
        },
        storeCurrentUrl(state, data) {
            state.currentUrl = data;
        },
        //checks whether user is to sign the form
        userSigns(state, data) {
            state.iwillSign = data;
        },
    },

    actions: {},

    getters: {
        getUserDetails(state) {
            return state.userDetails;
        },
    },
};

export default LoggedInUser;
