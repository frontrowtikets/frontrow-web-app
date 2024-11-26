<script>
import simplebar from "simplebar-vue";

import logoDarkLg from "../../images/logo-dark.svg";
import logoDarkSm from "../../images/logo.svg";
import logoLightLg from "../../images/logo-dark.svg";
import logoLightSm from "../../images/logo-light.svg";

import avatar1 from "../../images/users/avatar-1.jpg";
import avatar3 from "../../images/users/avatar-3.jpg";
import avatar4 from "../../images/users/avatar-4.jpg";

import megamenu from "../../images/header-logo.svg";

import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { BscNavigator } from "../Composables/BscNavigator.js";
import { BscRequestsNavigator } from "../Composables/BscRequestsNavigator.js";
import { LeaveNavigator } from "../Composables/LeaveNavigator.js";
import { LowValueNavigator } from "../Composables/LowValueNavigator.js";
import { SupplyPlanNavigator } from "../Composables/SupplyPlanNavigator.js";
import { HrNavigator } from "../Composables/HrNavigator.js";
import { notify } from "@/mixins/notify";
import {
    AccidentReportingNavigator,
    diplomaticVehicleRegistration,
    officeSupplies,
    goToAssetSubModule,
    vehicleFuelManagement,
    vehiclePrivateUse,
    administrationSettings,
    vehicleUtilization,
    vehicleMaintenance,
    carQueueManagement,
    AirtimeDataNavigator,
    visitortrackerNavigator,
    IncidentReportingNavigator,
    GuestHouseNavigator,
} from "../Composables/AdminNavigator.js";
import { FinanceInvoiceNavitor } from "../Composables/FinanceInvoiceNavitor.js";
import { TravelPlannerNavigator } from "../Composables/TravelPlannerNavigator.js";
import { IctNavigator } from "../Composables/IctNavigator.js";

import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";
import { useStore } from "vuex";

export default {
    setup() {
        return {
            BscNavigator,
            LeaveNavigator,
            AccidentReportingNavigator,
            diplomaticVehicleRegistration,
            LowValueNavigator,
            SupplyPlanNavigator,
            officeSupplies,
            HrNavigator,
            goToAssetSubModule,
            BscRequestsNavigator,
            router,
            notify,
            vehicleFuelManagement,
            vehiclePrivateUse,
            administrationSettings,
            vehicleUtilization,
            vehicleMaintenance,
            carQueueManagement,
            FinanceInvoiceNavitor,
            AirtimeDataNavigator,
            visitortrackerNavigator,
            TravelPlannerNavigator,
            IncidentReportingNavigator,
            GuestHouseNavigator,
            IctNavigator,
        };
    },
    components: {
        simplebar,
        Link,
    },

    data() {
        return {
            logoDarkLg,
            logoDarkSm,
            logoLightLg,
            logoLightSm,
            avatar1,
            avatar3,
            avatar4,
            megamenu,
            lan: this.$i18n.locale,
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
            const allUserRoles = usePage().props.auth.user.roles.map((role) => role.name);
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
    },
    methods: {
        doSearch() {

            const app = this;
            if (app.searchText == "" || app.searchText == null) {
                router.visit("/dashboard");
            } else {
                router.visit(
                    "/search",
                    {
                        method: "get",
                        data: {
                        searchWithIn: app.searchWithIn,
                        searchText: app.searchText,
                    },
                        replace: false,
                        preserveState: true,
                        preserveScroll: true,
                    },
                    
                );
            }
        },
        async goToFinanceModule(system_index) {
            const systems = [import.meta.env.VITE_BSC_APP_URL, import.meta.env.VITE_FINANCE_APP_URL];
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
            const authHeaders = {
                auth_token: this.userDetails.token,
            };
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
        toggleMenu() {
            let element = document.getElementById("topnav-menu-content");
            element.classList.toggle("show");
        },
        initFullScreen() {
            document.body.classList.toggle("fullscreen-enable");
            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {
                // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
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
            const VHCL_MAIN_URL = import.meta.env.VITE_ADMIN_VEHICLE_MAINTENANCE_URL;
            showLoader("Applying user session ...");
            return (window.location.href = `${VHCL_MAIN_URL}/loginFromMain?token=${this.currentUser.token}`);
        },
        toDIM(){
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
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header" style="background-color: #0160a0">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <Link :href="route('dashboard')" class="logo logo-dark">
                        <span class="logo-sm">
                            <img :src="logoDarkSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoDarkLg" alt height="17" />
                        </span>
                    </Link>

                    <Link :href="route('dashboard')" class="logo logo-light">
                        <span class="logo-sm">
                            <img :src="logoLightSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoLightLg" alt height="19" />
                        </span>
                    </Link>
                </div>

                <button id="toggle" type="button" class="btn btn-sm me-2 font-size-16 d-lg-none header-item" @click="toggleMenu">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="d-flex align-items-center">
                    <div class="rounded-pill d-none d-lg-block" style="background-color: #126ba7; border: 0px; color: #c6c6ca">
                        <div class="input-group d-flex flex-row align-items-center">
                            <div class="mt-1">
                                <span class="" style="font-size: medium"><i class="bx bx-search-alt"></i></span>
                            </div>
                            <div>
                                <input
                                    type="text"
                                    class="form-control"
                                    :placeholder="$t('navbar.search.text')"
                                    style="background-color: #126ba7; border: 0px; color: #c6c6ca; font-size: 13px"
                                    v-model="searchText"
                                    @input="doSearch"
                                />
                            </div>

                            <div class="hstack gap-3" role="button">
                                <div class="vr" style="color: #dbdbdb"></div>
                                <div class="btn-group dropbottomstart">
                                    <div data-bs-toggle="dropdown" class="d-flex flex-row gap-3">
                                        <div class="">{{ searchWithIn }}</div>
                                        <div>
                                            <i class="mdi mdi-chevron-down" aria-expanded="false"></i>
                                        </div>
                                    </div>

                                    <ul class="dropdown-menu">
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Users'">Users</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Emails'">Emails</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Invoices'">Invoices</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Finance Requests'">Finance Requests</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Items/Assets/LVNEs'">Items/Assets/LVNEs</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Call Logs'">Call Logs</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Monthly Travel Plans'">Monthly Travel Plans</b-dropdown-item>
                                        <b-dropdown-item class="mb-1" @click="searchWithIn = 'Staff Exit'">Staff Exit</b-dropdown-item>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <b-dropdown variant="black" class="dropdown-mega d-none d-lg-block ml-4" toggle-class="header-item" menu-class="dropdown-megamenu dropdown-menu-end" style="color: #f3f3f9">
                    <template v-slot:button-content>
                        <div style="color: #f3f3f9">Menu</div>
                        <!-- <i class="mdi mdi-chevron-down"></i> -->
                        <!-- {{ $t("navbar.dropdown.megamenu.text") }} -->
                    </template>

                    <div class="d-flex flex-row mb-5 jutify-content-center">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-5">
                                        <h5 class="font-size-14 mt-0 fw-bold">
                                            Finance
                                            <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                        </h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'invoices'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'invoices' ? 'text-secondary' : ''"
                                                    @click="FinanceInvoiceNavitor('all-invoices')"
                                                >
                                                    Invoices
                                                </div>
                                            </li>

                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'invoices'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'invoices' ? 'text-secondary' : ''"
                                                    @click="FinanceInvoiceNavitor('cash-incentives')"
                                                >
                                                    Cash Incentives
                                                </div>
                                            </li>

                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'BscRequests'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'BscRequests' ? 'text-secondary' : ''"
                                                    @click="BscRequestsNavigator('myRequests')"
                                                >
                                                    Finance Requests
                                                </div>
                                            </li>

                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'payroll'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'payroll' ? 'text-secondary' : ''"
                                                    @click="BscRequestsNavigator('payroll')"
                                                >
                                                    Payroll
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'pettycashReconciliation'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'pettycashReconciliation' ? 'text-secondary' : ''"
                                                    @click="BscRequestsNavigator('pettyCashReconciliation')"
                                                >
                                                    Petty Cash Reconciliation
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'helpCenter'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'helpCenter' ? 'text-secondary' : ''"
                                                    @click="BscRequestsNavigator('helpcenter')"
                                                >
                                                    Help Center
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'bscSettings'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'bscSettings' ? 'text-secondary' : ''"
                                                    @click="BscRequestsNavigator('settings')"
                                                >
                                                    Settings
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div v-if="dashboardView != 2">
                                        <h5 class="font-size-14 mt-0 fw-bold">
                                            Leave
                                            <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                        </h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'myAvailability'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'myAvailability' ? 'text-secondary' : ''"
                                                    @click="LeaveNavigator('updateAvailability')"
                                                >
                                                    My Availability
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'updateAvailability'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'updateAvailability' ? 'text-secondary' : ''"
                                                    @click="LeaveNavigator('updateAvailability')"
                                                >
                                                    Update Availability
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-3" v-if="dashboardView != 2">
                                    <h5 class="font-size-14 mt-0 fw-bold">
                                        Administration
                                        <!-- {{ $t("navbar.dropdown.megamenu.application.title") }} -->
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li @click="vehiclePrivateUse()">
                                            <div role="button" @mouseenter="currentLink = 'privateUse'" @mouseleave="currentLink = ''" :class="currentLink === 'privateUse' ? 'text-secondary' : ''">
                                                Private use of UNICEF Vehicle
                                            </div>
                                        </li>

                                        <li @click="vehicleMaintenance()">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'vehicleMaintenance'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'vehicleMaintenance' ? 'text-secondary' : ''"
                                            >
                                                Vehicle Maintenance
                                            </div>
                                        </li>
                                        <li @click="vehicleUtilization()">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'vehicleUtilization'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'vehicleUtilization' ? 'text-secondary' : ''"
                                            >
                                                Vehicle Utilization Log
                                            </div>
                                        </li>
                                        <li @click="vehicleFuelManagement()">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'fuelManagement'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'fuelManagement' ? 'text-secondary' : ''"
                                            >
                                                Fuel Management
                                            </div>
                                        </li>

                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'travelPlanner'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'travelPlanner' ? 'text-secondary' : ''"
                                                @click="TravelPlannerNavigator(0)"
                                            >
                                                Travel Planner
                                            </div>
                                        </li>

                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'accidentReporting'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'accidentReporting' ? 'text-secondary' : ''"
                                                @click="AccidentReportingNavigator('accidentReport')"
                                            >
                                                Accident Reporting
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'vehicleReg'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'vehicleReg' ? 'text-secondary' : ''"
                                                @click="diplomaticVehicleRegistration('vehicleReg')"
                                            >
                                                Diplomatic Vehicle Registration
                                            </div>
                                        </li>

                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'dim'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'dim' ? 'text-secondary' : ''"
                                                @click="toDIM()"
                                            >
                                                Diplomatic Information Management
                                            </div>
                                        </li>

                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'adminHelpcetnter'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'adminHelpcetnter' ? 'text-secondary' : ''"
                                            >
                                                Help Center
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @click="vehiclePrivateUse('admin-settings')"
                                                @mouseenter="currentLink = 'AdminSettings'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'AdminSettings' ? 'text-secondary' : ''"
                                            >
                                                Settings
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-3" v-if="dashboardView != 2">
                                    <h5 class="font-size-14 mt-0 fw-bold invisible">
                                        AMR
                                        <!-- {{ $t("navbar.dropdown.megamenu.extrapages.title") }} -->
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li @click="goToAssetSubModule(2)">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'equipmentRequest'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'equipmentRequest' ? 'text-secondary' : ''"
                                            >
                                                Equipment Requests
                                            </div>
                                        </li>

                                        <li @click="goToAssetSubModule(0)">
                                            <div role="button" @mouseenter="currentLink = 'tagging'" @mouseleave="currentLink = ''" :class="currentLink === 'tagging' ? 'text-secondary' : ''">
                                                Tagging of Non Expendables
                                            </div>
                                        </li>
                                        <li @click="goToAssetSubModule(1)">
                                            <div role="button" @mouseenter="currentLink = 'tracking'" @mouseleave="currentLink = ''" :class="currentLink === 'tracking' ? 'text-secondary' : ''">
                                                Tracking of Non Expendables
                                            </div>
                                        </li>
                                        <li @click="goToAssetSubModule(1, 'manage-assets')">
                                            <div role="button" @mouseenter="currentLink = 'assetList'" @mouseleave="currentLink = ''" :class="currentLink === 'assetList' ? 'text-secondary' : ''">
                                                Manage Asset List
                                            </div>
                                        </li>
                                        <li @click="goToAssetSubModule(3)">
                                            <div role="button" @mouseenter="currentLink = 'disposal'" @mouseleave="currentLink = ''" :class="currentLink === 'disposal' ? 'text-secondary' : ''">
                                                Disposal
                                            </div>
                                        </li>

                                        <hr class="bg-muted border border-top mt-4 mb-4" />
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'airtimeData'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'airtimeData' ? 'text-secondary' : ''"
                                                @click="AirtimeDataNavigator('airtimeData')"
                                            >
                                                Airtime & Data Management
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'guestHouse'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'guestHouse' ? 'text-secondary' : ''"
                                                @click="GuestHouseNavigator('guestHouse')"
                                            >
                                                Guest House Management
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'incidentReport'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'incidentReport' ? 'text-secondary' : ''"
                                                @click="IncidentReportingNavigator('incidentReport')"
                                            >
                                                Incident Reporting
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'officeSupplies'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'officeSupplies' ? 'text-secondary' : ''"
                                                @click="toOfficeSupplies"
                                            >
                                                Office Supplies
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'visitorTracker'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'visitorTracker' ? 'text-secondary' : ''"
                                                @click="visitortrackerNavigator"
                                            >
                                                Visitor Tracker
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-3" v-if="dashboardView != 2">
                                    <h5 class="font-size-14 mt-0 fw-bold">
                                        HR
                                        <!-- {{ $t("navbar.dropdown.megamenu.extrapages.title") }} -->
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li @click="HrNavigator('staff')">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'staffManagement'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'staffManagement' ? 'text-secondary' : ''"
                                            >
                                                Staff Management
                                            </div>
                                        </li>
                                        <li @click="HrNavigator('staff-orientation')">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'staffOrientation'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'staffOrientation' ? 'text-secondary' : ''"
                                            >
                                                Staff Orientation
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'staffOnboarding'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'staffOnboarding' ? 'text-secondary' : ''"
                                                @click="toStaffOnboarding"
                                            >
                                                Staff Onboarding
                                            </div>
                                        </li>
                                        <li @click="HrNavigator('consultant-tor')">
                                            <div role="button" @mouseenter="currentLink = 'tors'" @mouseleave="currentLink = ''" :class="currentLink === 'tors' ? 'text-secondary' : ''">
                                                Consultant TORs
                                            </div>
                                        </li>

                                        <li @click="HrNavigator('staff-exit')">
                                            <div role="button" @mouseenter="currentLink = 'staffExit'" @mouseleave="currentLink = ''" :class="currentLink === 'staffExit' ? 'text-secondary' : ''">
                                                Staff Exit
                                            </div>
                                        </li>

                                        <li @click="HrNavigator('radio-call')">
                                            <div role="button" @mouseenter="currentLink = 'headcount'" @mouseleave="currentLink = ''" :class="currentLink === 'headcount' ? 'text-secondary' : ''">
                                                Staff Headcount
                                            </div>
                                        </li>
                                        <li @click="HrNavigator('help-center')">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'staffHelpCenter'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'staffHelpCenter' ? 'text-secondary' : ''"
                                            >
                                                Help Center
                                            </div>
                                        </li>
                                        <li @click="HrNavigator('settings')">
                                            <div
                                                role="button"
                                                @mouseenter="currentLink = 'staffSettings'"
                                                @mouseleave="currentLink = ''"
                                                :class="currentLink === 'staffSettings' ? 'text-secondary' : ''"
                                            >
                                                Settings
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-5" v-if="dashboardView != 2">
                                        <h5 class="font-size-14 mt-0 fw-bold">
                                            Supply
                                            <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                        </h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li @click="LowValueNavigator()">
                                                <div role="button" @mouseenter="currentLink = 'lowvalus'" @mouseleave="currentLink = ''" :class="currentLink === 'lowvalus' ? 'text-secondary' : ''">
                                                    Low Value Procurement
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'supplyPlann'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'supplyPlann' ? 'text-secondary' : ''"
                                                    @click="SupplyPlanNavigator('home')"
                                                >
                                                    Supply Plan Management
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'supplyHelpCenter'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'supplyHelpCenter' ? 'text-secondary' : ''"
                                                >
                                                    Help Center
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    role="button"
                                                    @mouseenter="currentLink = 'supplySupply'"
                                                    @mouseleave="currentLink = ''"
                                                    :class="currentLink === 'supplySupply' ? 'text-secondary' : ''"
                                                >
                                                    Settings
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="mb-4" v-if="dashboardView != 2">
                                            <h5 class="font-size-14 mt-0 fw-bold">
                                                ICT UNIT
                                                <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                            </h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <div
                                                        @click="IctNavigator('vision')"
                                                        role="button"
                                                        @mouseenter="currentLink = 'vision'"
                                                        @mouseleave="currentLink = ''"
                                                        :class="currentLink === 'vision' ? 'text-secondary' : ''"
                                                    >
                                                        VISION Access
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        @click="IctNavigator('services')"
                                                        role="button"
                                                        @mouseenter="currentLink = 'services'"
                                                        @mouseleave="currentLink = ''"
                                                        :class="currentLink === 'services' ? 'text-secondary' : ''"
                                                    >
                                                        Services Access
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        @click="IctNavigator('help-center')"
                                                        role="button"
                                                        @mouseenter="currentLink = 'visionHelp'"
                                                        @mouseleave="currentLink = ''"
                                                        :class="currentLink === 'visionHelp' ? 'text-secondary' : ''"
                                                    >
                                                        Help Center
                                                    </div>
                                                </li>
                                                <li>
                                                    <div
                                                        @click="IctNavigator('settings')"
                                                        role="button"
                                                        @mouseenter="currentLink = 'visionSettings'"
                                                        @mouseleave="currentLink = ''"
                                                        :class="currentLink === 'visionSettings' ? 'text-secondary' : ''"
                                                    >
                                                        Settings
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 d-flex align-items-center">
                                    <div>
                                        <img :src="megamenu" alt class="img-fluid mx-auto d-block" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-dropdown>
            </div>

            <div class="d-flex" style="color: #f3f3f9">
                <b-dropdown class="d-inline-block d-lg-none ml-2" variant="black" menu-class="dropdown-menu-lg p-0 dropdown-menu-end" toggle-class="header-item noti-icon" right>
                    <template v-slot:button-content>
                        <i class="mdi mdi-magnify"></i>
                    </template>

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </b-dropdown>

                <!-- <b-dropdown variant="white" right toggle-class="header-item">
                    <template v-slot:button-content>
                        <img class :src="flag" alt="Header Language" height="16" />
                        {{ text }}
                    </template>
                    <b-dropdown-item
                        class="notify-item"
                        v-for="(entry, i) in languages"
                        :key="`Lang${i}`"
                        :value="entry"
                        @click="setLanguage(entry.language, entry.title, entry.flag)"
                        :class="{ active: lan === entry.language }"
                    >
                        <img :src="`${entry.flag}`" alt="user-image" class="me-1" height="12" />
                        <span class="align-middle">{{ entry.title }}</span>
                    </b-dropdown-item>
                </b-dropdown> -->

                <!-- <b-dropdown class="d-none d-lg-inline-block noti-icon" menu-class="dropdown-menu-lg dropdown-menu-end" right toggle-class="header-item" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-customize"></i>
                    </template>

                    <div class="px-lg-2">
                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="github" alt="Github" />
                                    <span>{{ $t("navbar.dropdown.site.list.github") }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="bitbucket" alt="bitbucket" />
                                    <span>{{ $t("navbar.dropdown.site.list.github") }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="dribbble" alt="dribbble" />
                                    <span>{{ $t("navbar.dropdown.site.list.dribbble") }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="dropbox" alt="dropbox" />
                                    <span>{{ $t("navbar.dropdown.site.list.dropbox") }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="mail_chimp" alt="mail_chimp" />
                                    <span>{{ $t("navbar.dropdown.site.list.mailchimp") }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="slack" alt="slack" />
                                    <span>{{ $t("navbar.dropdown.site.list.slack") }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </b-dropdown> -->

                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon" @click="initFullScreen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>

                <b-dropdown right menu-class="dropdown-menu-lg p-0 dropdown-menu-end" toggle-class="header-item noti-icon" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-bell"></i>
                        <span class="badge bg-danger rounded-pill" v-if="currentUser.notifications == null">0</span>
                        <span class="badge bg-danger rounded-pill" v-else-if="currentUser.notifications.length > 99">99+</span>
                        <span class="badge bg-danger rounded-pill" v-else>{{ currentUser.notifications.length }}</span>
                    </template>
                    <div v-if="currentUser.notifications != null">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0">
                                        {{ $t("navbar.dropdown.notification.text") }}
                                    </h6>
                                </div>
                                <div class="col-auto" v-if="currentUser.notifications.length > 0">
                                    <a href="#" class="small">Mark All as Read</a>
                                </div>
                            </div>
                        </div>
                        <simplebar style="max-height: 230px" v-if="currentUser.notifications.length > 0">
                            <div v-if="currentUser.notifications.length > 0">
                                <a class="text-reset notification-item" v-for="notification in currentUser.notifications" :key="`${notification.id}`">
                                    <div class="d-flex">
                                        <img
                                            v-if="notification?.profile_photo_path == null"
                                            :src="`https://ui-avatars.com/api/?name=${notification?.submitted_by}?background=cdd7f7&color=7f9cf5`"
                                            class="me-3 rounded-circle avatar-xs"
                                            alt="user-pic"
                                        />

                                        <img v-else :src="`/storage/${notification?.profile_photo_path}`" :alt="'p'" class="me-3 rounded-circle header-profile-user object-fit-cover" />
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1">
                                                {{ notification?.submitted_by }}
                                            </h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">
                                                    {{ notification?.title }}
                                                </p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    {{ formatDate(notification.created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </simplebar>
                        <div v-else class="text-center mt-5 mb-5">You have no Notifications</div>
                        <div class="p-2 border-top d-grid" v-if="currentUser.notifications.length > 0">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-down-circle me-1"></i>
                                <span key="t-view-more">
                                    {{ $t("navbar.dropdown.notification.button") }}
                                </span>
                            </a>
                        </div>
                    </div>
                </b-dropdown>

                <b-dropdown right variant="black" toggle-class="header-item" menu-class="dropdown-menu-end">
                    <template v-slot:button-content>
                        <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                        <img :src="currentUser.profile_photo_url" :alt="'p'" class="rounded-circle header-profile-user object-fit-cover" />

                        <span class="d-none d-xl-inline-block ms-1" style="color: #f3f3f9">{{ currentUser.name }}</span>
                        <!-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> -->
                    </template>
                    <!-- item-->
                    <Link :href="route('profile.show')">
                        <b-dropdown-item>
                            <i class="bx bx-user font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>

                            My Profile
                            <!-- {{ $t("navbar.dropdown.henry.list.profile") }} -->
                        </b-dropdown-item>
                    </Link>
                    <Link :href="route('AllLogs')">
                        <b-dropdown-item>
                            <i class="bx bxs-chat font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            Emails
                            <!-- {{ $t("navbar.dropdown.henry.list.profile") }} -->
                        </b-dropdown-item>
                    </Link>
                    <b-dropdown-item href="javascript: void(0);">
                        <i class="bx bx bxs-report font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                        Reports
                        <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                    </b-dropdown-item>
                    <Link v-if="allPermissions.includes('s_admin')" :href="route('mobile-app', {}, { preserveState: false, preserveScroll: false })">
                        <b-dropdown-item href="javascript: void(0);">
                            <i class="bx bx bx-mobile font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            Mobile
                            <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                        </b-dropdown-item>
                    </Link>

                    <Link v-if="allPermissions.includes('s_admin')" :href="route('supportCenter', {}, { preserveState: false, preserveScroll: false })">
                        <b-dropdown-item href="javascript: void(0);">
                            <i class="bx bx bxs-help-circle font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            Support Center
                        </b-dropdown-item>
                    </Link>
                    <Link v-else :href="route('supportRequest', {}, { preserveState: false, preserveScroll: false })">
                        <b-dropdown-item href="javascript: void(0);">
                            <i class="bx bx bxs-help-circle font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            Support
                        </b-dropdown-item>
                    </Link>
                    <!-- <Link :href="route(`${allRoles.includes('Super Admin')?'supportCenter':'supportRequest'}`,)">
                     <b-dropdown-item href="javascript: void(0);">
                        <i class="bx bx bxs-help-circle font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #E0E8F1; border-radius: 50%;"></i>
                        {{ allRoles.includes('Super Admin')?'Support Center': 'Support' }}
                    </b-dropdown-item>
                    </Link> -->

                    <template v-if="allPermissions.includes('s_admin')">
                        <b-dropdown-item href="/pulse" target="_blank">
                            <i class="bx bx-health font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            System Health
                        </b-dropdown-item>
                    </template>

                    <Link v-if="allPermissions.includes('s_admin')" :href="route('systemconfig', {}, { preserveState: false, preserveScroll: false })">
                        <b-dropdown-item href="javascript: void(0);">
                            <i class="bx bx-cog font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            System Configuration
                        </b-dropdown-item>
                    </Link>

                    <Link :href="route('dashboards', {}, { preserveState: false, preserveScroll: false })">
                        <b-dropdown-item href="javascript: void(0);">
                            <i class="bx bxs-report font-size-16 align-middle me-1 p-1" style="color: #639099; background-color: #e0e8f1; border-radius: 50%"></i>
                            Dashboards
                        </b-dropdown-item>
                    </Link>

                    <!-- <b-dropdown-item class="d-block" href="javascript: void(0);">
                        <span class="badge bg-success float-end">11</span>
                        <i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        {{ $t("navbar.dropdown.henry.list.settings") }}
                    </b-dropdown-item>
                    <b-dropdown-item href="javascript: void(0);">
                        <i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                        {{ $t("navbar.dropdown.henry.list.lockscreen") }}
                    </b-dropdown-item> -->
                    <b-dropdown-divider></b-dropdown-divider>
                    <a @click="logout" class="dropdown-item text-danger" role="button">
                        <i class="mdi mdi-login-variant font-size-16 align-middle me-1 text-danger p-1"></i>
                        {{ $t("navbar.dropdown.henry.list.logout") }}
                    </a>
                </b-dropdown>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle toggle-right" @click="toggleRightSidebar">
                        <i class="bx bx-cog toggle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
