<script>
import { menuItems } from "./horizontal-menu";
import megamenu from "../../images/header-logo.svg";
import { BscNavigator } from "../Composables/BscNavigator.js";
import { BscRequestsNavigator } from "../Composables/BscRequestsNavigator.js";
import { LeaveNavigator } from "../Composables/LeaveNavigator.js";
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
} from "../Composables/AdminNavigator.js";
import { HrNavigator } from "../Composables/HrNavigator.js";
import { SupplyPlanNavigator } from "../Composables/SupplyPlanNavigator.js";
import { LowValueNavigator } from "../Composables/LowValueNavigator.js";
import { showLoader } from "@/mixins/helpers";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { notify } from "@/mixins/notify";
import { FinanceInvoiceNavitor } from "../Composables/FinanceInvoiceNavitor.js";
import { TravelPlannerNavigator } from "../Composables/TravelPlannerNavigator.js";

import { useStore } from "vuex";

export default {
    setup() {
        return {
            BscNavigator,
            LeaveNavigator,
            AccidentReportingNavigator,
            diplomaticVehicleRegistration,
            officeSupplies,
            SupplyPlanNavigator,
            LowValueNavigator,
            BscRequestsNavigator,
            HrNavigator,
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
        };
    },
    data() {
        return {
            menuItems: menuItems,
            megamenu,
            currentLink: "",
            currentUser: {},
        };
    },
    computed: {
        userDetails: function () {
            const store = useStore();
            return store.getters["LoggedInUser/getUserDetails"];
        },
    },
    mounted() {
        this.currentUser = usePage().props.auth.user;
        var links = document.getElementsByClassName("side-nav-link-ref");
        var matchingMenuItem = null;
        for (var i = 0; i < links.length; i++) {
            if (window.location.pathname === links[i].pathname) {
                matchingMenuItem = links[i];
                break;
            }
        }

        if (matchingMenuItem) {
            matchingMenuItem.classList.add("active");
            var parent = matchingMenuItem.parentElement;

            /**
             * TODO: This is hard coded way of expading/activating parent menu dropdown and working till level 3.
             * We should come up with non hard coded approach
             */
            if (parent) {
                parent.classList.add("active");
                const parent2 = parent.parentElement;
                if (parent2) {
                    parent2.classList.add("active");
                }
                const parent3 = parent2.parentElement;
                if (parent3) {
                    parent3.classList.add("active");
                    var childAnchor = parent3.querySelector(".has-dropdown");
                    if (childAnchor) childAnchor.classList.add("active");
                }

                const parent4 = parent3.parentElement;
                if (parent4) parent4.classList.add("active");
                const parent5 = parent4.parentElement;
                if (parent5) parent5.classList.add("active");
            }
        }
    },
    methods: {
        /**
         * Menu clicked show the submenu
         */
        onMenuClick(event) {
            event.preventDefault();
            const nextEl = event.target.nextElementSibling;
            if (nextEl && !nextEl.classList.contains("show")) {
                const parentEl = event.target.parentNode;
                if (parentEl) {
                    parentEl.classList.remove("show");
                }
                nextEl.classList.add("show");
            } else if (nextEl) {
                nextEl.classList.remove("show");
            }
            return false;
        },
        /**
         * Returns true or false if given menu item has child or not
         * @param item menuItem
         */
        hasItems(item) {
            return item.subItems !== undefined ? item.subItems.length > 0 : false;
        },
        topbarLight() {
            document.body.setAttribute("data-topbar", "light");
            document.body.removeAttribute("data-layout-size", "boxed");
        },
        boxedWidth() {
            document.body.setAttribute("data-layout-size", "boxed");
            document.body.removeAttribute("data-topbar", "light");
            document.body.setAttribute("data-topbar", "dark");
        },
        coloredHeader() {
            document.body.setAttribute("data-topbar", "colored");
            document.body.removeAttribute("data-layout-size", "boxed");
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
        toVehicleUtilization() {
            const VHCL_UTIL_URL = import.meta.env.VITE_ADMIN_VEHICLE_UTILIZATION_URL;
            showLoader("Applying user session ...");
            return (window.location.href = `${VHCL_UTIL_URL}/loginFromMain?token=${this.currentUser.token}`);
        },
        toFuelManagement() {
            const FUEL_MGMT_URL = import.meta.env.VITE_ADMIN_FUEL_MANAGEMENT_URL;
            showLoader("Applying user session ...");
            return (window.location.href = `${FUEL_MGMT_URL}/loginFromMain?token=${this.currentUser.token}`);
        },
        toVehicleMaintenance() {
            const VHCL_MAIN_URL = import.meta.env.VITE_ADMIN_VEHICLE_MAINTENANCE_URL;
            showLoader("Applying user session ...");
            return (window.location.href = `${VHCL_MAIN_URL}/loginFromMain?token=${this.currentUser.token}`);
        },
    },
};
</script>

<template>
    <div class="topnav" style="background-color: #fff">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div id="topnav-menu-content" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" @click="onMenuClick($event)" href="javascript: void(0);" id="topnav-components" role="button">
                                <i :class="`bx bx-home-circle mr-1`"></i>
                                Dashboard Systems
                                <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-mega-menu-xl p-4" aria-labelledby="topnav-dashboard">
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
                                                                @click="FinanceInvoiceNavitor(1)"
                                                            >
                                                                Invoices
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'bscRequests'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'bscRequests' ? 'text-secondary' : ''"
                                                                @click="BscRequestsNavigator('myRequests')"
                                                            >
                                                                Finance Requests
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'settings'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'settings' ? 'text-secondary' : ''"
                                                                @click="BscRequestsNavigator('settings')"
                                                            >
                                                                Settings
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div>
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
                                                                @mouseenter="currentLink = 'updataAvailability'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'updataAvailability' ? 'text-secondary' : ''"
                                                                @click="LeaveNavigator('updateAvailability')"
                                                            >
                                                                Update Availability
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <h5 class="font-size-14 mt-0 fw-bold">
                                                    Administration
                                                    <!-- {{ $t("navbar.dropdown.megamenu.application.title") }} -->
                                                </h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li @click="vehiclePrivateUse()">
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'privateUnicefVehicle'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'privateUnicefVehicle' ? 'text-secondary' : ''"
                                                        >
                                                            Private Use UNICEF Vehicle
                                                        </div>
                                                    </li>
                                                    <li @click="toVehicleMaintenance()">
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'vehicleMaintenance'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'vehicleMaintenance' ? 'text-secondary' : ''"
                                                        >
                                                            Vehicle Maintenance
                                                        </div>
                                                    </li>
                                                    <li @click="toVehicleUtilization()">
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
                                                            @mouseenter="currentLink = 'CarPark'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'CarPark' ? 'text-secondary' : ''"
                                                        >
                                                            Car Park
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'AccidentReporting'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'AccidentReporting' ? 'text-secondary' : ''"
                                                            @click="AccidentReportingNavigator('accidentReport')"
                                                        >
                                                            Accident Reporting
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'diplomaticVehicleReg'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'diplomaticVehicleReg' ? 'text-secondary' : ''"
                                                            @click="diplomaticVehicleRegistration('vehicleReg')"
                                                        >
                                                            Diplomatic Vehicle Registration
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'AdminSettings'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'AdminSettings' ? 'text-secondary' : ''"
                                                        >
                                                            Settings
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-3">
                                                <h5 class="font-size-14 mt-0 fw-bold invisible">
                                                    AMR
                                                    <!-- {{ $t("navbar.dropdown.megamenu.extrapages.title") }} -->
                                                </h5>

                                                <ul class="list-unstyled megamenu-list">
                                                    <li @click="goToAssetSubModule(4)">
                                                        <div role="button" @mouseenter="currentLink = 'amr'" @mouseleave="currentLink = ''" :class="currentLink === 'amr' ? 'text-secondary' : ''">
                                                            AMR creation
                                                        </div>
                                                    </li>

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
                                                    <li @click="goToAssetSubModule(2, 'requests#initiate')">
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'initiateEquipmetRequest'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'initiateEquipmetRequest' ? 'text-secondary' : ''"
                                                        >
                                                            Initiate Equipment Request
                                                        </div>
                                                    </li>
                                                    <li @click="goToAssetSubModule(0)">
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'tagging'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'tagging' ? 'text-secondary' : ''"
                                                        >
                                                            Tagging of Non Expendables
                                                        </div>
                                                    </li>

                                                    <li @click="goToAssetSubModule(3)">
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'disposal'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'disposal' ? 'text-secondary' : ''"
                                                        >
                                                            Disposal
                                                        </div>
                                                    </li>
                                                    <hr class="bg-muted border border-top mt-4 mb-4" />
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'phoneBill'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'phoneBill' ? 'text-secondary' : ''"
                                                            @click="AirtimeDataNavigator('airtimeData')"
                                                        >
                                                            Airtime & Data
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

                                            <div class="col-md-3">
                                                <h5 class="font-size-14 mt-0 fw-bold">
                                                    HR
                                                    <!-- {{ $t("navbar.dropdown.megamenu.extrapages.title") }} -->
                                                </h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'staffManagement'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'staffManagement' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('staff')"
                                                        >
                                                            Staff Management
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'staffOrientation'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'staffOrientation' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('staff-orientation')"
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
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'tors'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'tors' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('consultant-tor')"
                                                        >
                                                            Consultant TORs
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'staffExit'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'staffExit' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('staff-exit')"
                                                        >
                                                            Staff Exit
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'staffHeadcount'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'staffHeadcount' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('radio-call')"
                                                        >
                                                            Staff Headcount
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'Hrsettings'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'Hrsettings' ? 'text-secondary' : ''"
                                                            @click="HrNavigator('settings')"
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
                                                <div class="mb-5">
                                                    <h5 class="font-size-14 mt-0 fw-bold">
                                                        Supply
                                                        <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                                    </h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'lowValue'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'lowValue' ? 'text-secondary' : ''"
                                                                @click="LowValueNavigator('home')"
                                                            >
                                                                Low Value Procurement
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'supplyPlan'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'supplyPlan' ? 'text-secondary' : ''"
                                                                @click="SupplyPlanNavigator('home')"
                                                            >
                                                                Supply Plan Management
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'supplySettings'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'supplySettings' ? 'text-secondary' : ''"
                                                            >
                                                                Settings
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <div class="mb-4">
                                                        <h5 class="font-size-14 mt-0 fw-bold">
                                                            IFM/ PPM Checklist
                                                            <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                                        </h5>
                                                        <ul class="list-unstyled megamenu-list">
                                                            <li>
                                                                <div
                                                                    role="button"
                                                                    @mouseenter="currentLink = 'forms'"
                                                                    @mouseleave="currentLink = ''"
                                                                    :class="currentLink === 'forms' ? 'text-secondary' : ''"
                                                                >
                                                                    Forms
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <div class="d-none d-lg-block">
                                                    <img :src="megamenu" alt class="img-fluid mx-auto d-block" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- ................................................ -->

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" @click="onMenuClick($event)" href="javascript: void(0);" id="topnav-components2" role="button">
                                <i :class="`bx bx-file mr-1`"></i>
                                Forms
                                <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-mega-menu-lg p-4" aria-labelledby="topnav-dashboard">
                                <div class="d-flex flex-row mb-5 jutify-content-center">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-5">
                                                    <h5 class="font-size-14 mt-0 fw-bold invisible">
                                                        Staff <i class="fas fa-exclamation-triangle"></i>
                                                        <!-- {{ $t("navbar.dropdown.megamenu.uicontent.title") }} -->
                                                    </h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'staffExit'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'staffExit' ? 'text-secondary' : ''"
                                                                @click="HrNavigator('staff-exit')"
                                                            >
                                                                Staff Exit
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'forEquipment'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'forEquipment' ? 'text-secondary' : ''"
                                                                @click="goToAssetSubModule(2)"
                                                            >
                                                                Request For Equipment
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div
                                                                role="button"
                                                                @mouseenter="currentLink = 'forBsc'"
                                                                @mouseleave="currentLink = ''"
                                                                :class="currentLink === 'forBsc' ? 'text-secondary' : ''"
                                                                @click="BscRequestsNavigator('myRequests')"
                                                            >
                                                                Finance Request
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <h5 class="font-size-14 mt-0 fw-bold invisible">
                                                    Private
                                                    <!-- {{ $t("navbar.dropdown.megamenu.application.title") }} -->
                                                </h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'forPrivateUse'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'forPrivateUse' ? 'text-secondary' : ''"
                                                            @click="vehiclePrivateUse()"
                                                        >
                                                            Private use of UNICEF Vehicle
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'forAssets'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'forAssets' ? 'text-secondary' : ''"
                                                            @click="goToAssetSubModule(1, 'manage-assets')"
                                                        >
                                                            Update Asset Status
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            role="button"
                                                            @mouseenter="currentLink = 'forDiplomaticVehicle'"
                                                            @mouseleave="currentLink = ''"
                                                            :class="currentLink === 'forDiplomaticVehicle' ? 'text-secondary' : ''"
                                                            @click="diplomaticVehicleRegistration('vehicleReg')"
                                                        >
                                                            Diplomatic Vehicle Registration
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 d-flex align-items-center">
                                        <div class="d-none d-lg-block">
                                            <img :src="megamenu" alt class="img-fluid mx-auto d-block" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</template>
