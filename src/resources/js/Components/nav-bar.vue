<script>
import simplebar from "simplebar-vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";

const breakpoints = useBreakpoints(breakpointsTailwind);
const lgAndSmaller = breakpoints.smallerOrEqual("md");
import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";
import { useStore } from "vuex";
import { Loader } from "@googlemaps/js-api-loader";

export default {
    setup() {
        return {
            lgAndSmaller,
            router,
            usePage,
        };
    },
    components: {
        simplebar,
        Link,
    },

    data() {
        return {
            text: null,
            flag: null,
            value: null,
            currentUser: {},
            currentLink: "",
            searchWithIn: "Users",
            searchText: "",
        };
    },

    //using vuex
    computed: {
        userDetails: function () {
            const store = useStore();
            return store.getters["LoggedInUser/getUserDetails"];
        },
        allRoles: function () {
            const allUserRoles = usePage().props.auth.user.roles.map(
                (role) => role.name
            );
            return allUserRoles;
        },
        allPermissions: function () {
            const allPermissions = usePage().props.auth.user.allPermissions;
            return allPermissions;
        },
        dashboardView() {
            let showDashboard = import.meta.env.VITE_COUNTRY_OFFICE;
            let isToShow = 0;
            switch (showDashboard) {
                case "Uganda":
                    isToShow = 2;
                    break;
                default:
                    isToShow = 1;
                    break;
            }
            return isToShow;
        },
    },
    mounted() {
        this.currentUser = usePage().props.auth.user;
        router.reload();
    },
    methods: {
        async loadSearchMap() {
            const loader = new Loader({
                apiKey: "AIzaSyCBE7aRb0VJdRBlUnvjcQ_lnKWoAWuXUx8",
                version: "weekly",
            });
            const Places = await loader.importLibrary("places");

            const input = document.getElementById("searched_place");

            //this object will be our second arg for the new instance of the Places API
            const options = {
                types: ["establishment"], //optioanl
                fields: ["address_components", "geometry", "icon", "name"], //allows the api to accept these inputs and return similar ones
                strictBounds: false, //optional
            };

            // per the Google docs create the new instance of the import above. I named it Places.
            const autocomplete = new Places.Autocomplete(input, options);

            //add the place_changed listener to display results when inputs change
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.geometry && place.geometry.location) {
                    router.visit("/searchWeather", {
                        method: "get",
                        data: {
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng(),
                            placeName: place.name,
                        },
                        replace: false,
                        preserveState: false,
                        preserveScroll: true,
                    });
                } else {
                    console.log("No coordinates available for this place.");
                }
            });
        },
        doSearch() {
            const app = this;
            if (app.searchText == "" || app.searchText == null) {
                router.visit("/dashboard");
            } else {
                router.visit("/search", {
                    method: "get",
                    data: {
                        searchWithIn: app.searchWithIn,
                        searchText: app.searchText,
                    },
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                });
            }
        },
        async goToFinanceModule(system_index) {
            const systems = [
                import.meta.env.VITE_BSC_APP_URL,
                import.meta.env.VITE_FINANCE_APP_URL,
            ];
            const url = systems[system_index];

            const token = attrs.auth.user.api_token;
            const authHeaders = {
                auth_token: props.user.token,
                Authorization: `Bearer ${token}`,
            };

            return (window.location.href = `${url}/loginFromMain?token=${props.user.token}`);
        },
        logout() {
            // router.post(route("logout"));
            router.visit("/logout", {
                method: "post",
            });
        },
        toStaffOnboarding() {
            const staffOnboardingUrl = import.meta.env.VITE_STAFFONBOARDING_URL;
            const userToken = usePage().props.userToken;

            if (userToken != null) {
                Swal.fire({
                    html: `<p style='fontsize:16px'>Loading ...</p>`,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                });
                return (window.location.href = `${staffOnboardingUrl}/loginFromMain?token=${userToken}`);
            } else {
                notify.toastErrorMessage("Invalid Session");
            }
        },
        toBSC() {
            const BSCURL = import.meta.env.VITE_BSC_APP_URL;

            axios
                .get(`${BSCURL}/api/loginFromMain`, { headers: authHeaders })
                .then((res) => {
                    if (res.status == 200) {
                        window.location.href = BSCURL;
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        markAllNotificationsRead() {
            const options = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Authorization: `Bearer ${
                        usePage().props.auth.user.api_token
                    }`,
                },
            };

            axios
                .post(`/api/userRegister/notificationsread`, {}, options)
                .then((res) => {
                    if (res.status == 200) {
                        router.reload();
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        toggleMenu() {
            this.$parent.toggleMenu();
        },
        toggleRightSidebar() {
            this.$parent.toggleRightSidebar();
        },
        toOfficeSupplies() {
            const officeUrl = import.meta.env.VITE_OFFICESUPPLIES_URL;
            const userToken = usePage().props.userToken;

            if (userToken != null) {
                Swal.fire({
                    html: `<p style='fontsize:16px'>Loading ...</p>`,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                });
                return (window.location.href = `${officeUrl}/loginFromMain?token=${userToken}`);
            } else {
                notify.toastErrorMessage("Invalid Session");
            }
        },
        downloadApk() {
            const fileUrl = `/FRONTROW_V1.0.1.apk`;

            const a = document.createElement("a");
            a.href = fileUrl;
            a.download = "FRONTROW_V1.0.1.apk";
            document.body.appendChild(a);
            a.click();
            URL.revokeObjectURL(fileURL);
            document.body.removeChild(a);
        },

        initFullScreen() {
            document.body.classList.toggle("fullscreen-enable");
            if (
                !document.fullscreenElement &&
                /* alternative standard method */ !document.mozFullScreenElement &&
                !document.webkitFullscreenElement
            ) {
                // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    );
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        },
        setLanguage(locale, country, flag) {
            this.lan = locale;
            this.text = country;
            this.flag = flag;
            this.$i18n.locale = locale;
            localStorage.setItem("locale", locale);
        },
        toVehicleMaintenance() {
            const VHCL_MAIN_URL = import.meta.env
                .VITE_ADMIN_VEHICLE_MAINTENANCE_URL;
            showLoader("Applying user session ...");
            return (window.location.href = `${VHCL_MAIN_URL}/loginFromMain?token=${this.currentUser.token}`);
        },
        toDIM() {
            const URL = import.meta.env.VITE_ADMIN_DIM;
            Swal.fire({
                html: `<p style='font-size:16px'>Loading...</p>`,
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
            });
            return (window.location.href = `${URL}/loginFromMain?token=${this.currentUser.token}`);
        },
        formatDate(theDate) {
            return moment(theDate).fromNow();
        },
        getWeatherLocation($event) {
            router.visit(
                "/searchWeather",
                {
                    place: $event.target.value,
                },
                {}
            );
        },
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header" style="background-color: #01676C">
            <div class="d-flex">
                <!-- LOGO -->
                <div
                    class="navbar-brand-box d-flex align-items-center justify-content-center"
                >
                    <Link :href="route('landing')">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-light">
                                <!-- <img
                                    src="@/images/FRONTROWLogo.svg"
                                    alt
                                    height="48"
                                /> -->
                            </span>
                        </div>
                    </Link>
                </div>

                <button
                    v-show="lgAndSmaller"
                    id="vertical-menu-btn "
                    type="button"
                    class="px-3 btn btn-sm font-size-16 header-item mobilehumburgeMenu"
                    @click="toggleMenu"
                >
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input
                            type="text"
                            class="form-control"
                            id="searched_place"
                            :placeholder="'Search '"
                        />
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex" style="color: #f3f3f9">
                <b-dropdown
                    class="ml-2 d-inline-block d-lg-none"
                    variant="black"
                    menu-class="p-0 dropdown-menu-lg dropdown-menu-end"
                    toggle-class="header-item noti-icon"
                    right
                >
                    <template v-slot:button-content>
                        <i class="mdi mdi-magnify"></i>
                    </template>

                    <form class="p-3">
                        <div class="m-0 form-group">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="searched_place"
                                    placeholder="Search Weather"
                                />
                                <div class="input-group-append">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </b-dropdown>

                <div class="ml-1 dropdown d-none d-lg-inline-block">
                    <button
                        type="button"
                        class="btn header-item noti-icon"
                        @click="initFullScreen"
                    >
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>

                <!-- <b-dropdown
                    right
                    menu-class="p-0 dropdown-menu-lg dropdown-menu-end"
                    toggle-class="header-item noti-icon"
                    variant="black"
                >
                    < <template v-slot:button-content>
                        <i class="bx bx-bell"></i>
                        <span
                            class="badge bg-danger rounded-pill"
                            v-if="currentUser.notifications == null"
                            >0</span
                        >
                        <span
                            class="badge bg-danger rounded-pill"
                            v-else-if="currentUser.notifications.length > 99"
                            >99+</span
                        >
                        <span class="badge bg-danger rounded-pill" v-else>{{
                            currentUser.notifications.length
                        }}</span>
                    </template>
                    <div v-if="currentUser.notifications != null">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0">Notification</h6>
                                </div>
                                <div
                                    class="col-auto"
                                    v-if="currentUser.notifications.length > 0"
                                    @click="markAllNotificationsRead"
                                >
                                    <a href="#" class="small"
                                        >Mark All as Read</a
                                    >
                                </div>
                            </div>
                        </div>
                        <simplebar
                            style="max-height: 230px"
                            v-if="currentUser.notifications.length > 0"
                        >
                            <div v-if="currentUser.notifications.length > 0">
                                <a
                                    class="text-reset notification-item"
                                    v-for="notification in currentUser.notifications"
                                    :key="`${notification.id}`"
                                >
                                    <div class="d-flex">
                                        <img
                                            v-if="
                                                notification?.profile_photo_path !=
                                                null
                                            "
                                            :src="`${notification?.profile_photo_path}`"
                                            :alt="'p'"
                                            class="me-3 rounded-circle header-profile-user object-fit-cover"
                                        />
                                        <img
                                            v-else
                                            :src="`https://ui-avatars.com/api/?name=${notification?.submitted_by_name}?background=cdd7f7&color=7f9cf5`"
                                            class="me-3 rounded-circle avatar-xs"
                                            alt="user-pic"
                                        />
                                        <div class="flex-grow-1">
                                            <div
                                                class="font-size-12 text-muted"
                                            >
                                                <p class="mb-1 fw-bold">
                                                    {{ notification?.title }}
                                                </p>
                                                <p
                                                    class="mb-1"
                                                    v-html="
                                                        notification?.message
                                                    "
                                                ></p>
                                                <p class="mb-0">
                                                    <i
                                                        class="mdi mdi-clock-outline"
                                                    ></i>
                                                    {{
                                                        formatDate(
                                                            notification.created_at
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </simplebar>
                        <div class="mt-5 mb-5 text-center" v-else>
                            You have no Notifications
                        </div>
                         <div class="p-2 border-top d-grid" v-if="currentUser.notifications.length > 0">
                            <a class="text-center btn btn-sm btn-link font-size-14" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-down-circle me-1"></i>
                                <span key="t-view-more">
                                    {{ $t("navbar.dropdown.notification.button") }}
                                </span>
                            </a>
                        </div>
                    </div>
                </b-dropdown> -->

                <b-dropdown
                    right
                    variant="black"
                    toggle-class="header-item"
                    menu-class="dropdown-menu-end"
                >
                    <template v-slot:button-content>
                        <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                        <img
                            :src="currentUser.profile_photo_url"
                            :alt="'p'"
                            class="rounded-circle header-profile-user object-fit-cover"
                        />

                        <span
                            class="d-none d-xl-inline-block ms-1"
                            style="color: #f3f3f9"
                            >{{ currentUser.name }}</span
                        >
                        <!-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> -->
                    </template>
                    <!-- item-->
                    <Link :href="route('profile.show')">
                        <b-dropdown-item>
                            <i
                                class="p-1 align-middle bx bx-user font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>

                            My Profile
                            <!-- {{ $t("navbar.dropdown.henry.list.profile") }} -->
                        </b-dropdown-item>
                    </Link>
                    <b-dropdown-item href="javascript: void(0);">
                        <i
                            class="p-1 align-middle bx bxs-report font-size-16 me-1"
                            style="
                                color: #639099;
                                background-color: #e0e8f1;
                                border-radius: 50%;
                            "
                        ></i>
                        Reports
                        <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                    </b-dropdown-item>
                    <Link :href="route('landing')">
                        <b-dropdown-item href="javascript: void(0);">
                            <i
                                class="p-1 align-middle bx bxs-home font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>
                            Return to Home
                            <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                        </b-dropdown-item>
                    </Link>

                    <Link>
                        <b-dropdown-item @click="downloadApk">
                            <i
                                class="p-1 align-middle bx bx-mobile font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>
                            Mobile App
                            <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                        </b-dropdown-item>
                    </Link>

                    <b-dropdown-divider></b-dropdown-divider>
                    <a
                        @click="logout"
                        class="dropdown-item text-danger"
                        role="button"
                    >
                        <i
                            class="p-1 align-middle mdi mdi-login-variant font-size-16 me-1 text-danger"
                        ></i>
                        Logout
                    </a>
                </b-dropdown>
            </div>
        </div>
    </header>
</template>
