<script>
import simplebar from "simplebar-vue";
import us from "../../images/flags/us.jpg";
import fr from "../../images/flags/french.jpg";
import es from "../../images/flags/spain.jpg";
import zh from "../../images/flags/chaina.png";
import ar from "../../images/flags/arabic.png";

import logoDarkLg from "../../images/logo-dark.svg";
import logoDarkSm from "../../images/logo.svg";
import logoLightLg from "../../images/logo-dark.svg";
import logoLightSm from "../../images/logo-light.svg";

import avatar1 from "../../images/users/avatar-1.jpg";
import avatar3 from "../../images/users/avatar-3.jpg";
import avatar4 from "../../images/users/avatar-4.jpg";

import finance from "../../images/finance.svg";
import bitbucket from "../../images/brands/bitbucket.png";
import dribbble from "../../images/brands/dribbble.png";
import dropbox from "../../images/brands/dropbox.png";
import mail_chimp from "../../images/brands/mail_chimp.png";
import slack from "../../images/brands/slack.png";

import megamenu from "../../images/header-logo.svg";

import { Head, Link, router,usePage } from "@inertiajs/vue3";

import { useStore } from "vuex";

/**
 * Nav-bar Component
 */

export default {
    data() {
        return {
            logoDarkLg,
            logoDarkSm,
            logoLightLg,
            logoLightSm,
            avatar1,
            avatar3,
            avatar4,
            finance,
            bitbucket,
            dribbble,
            dropbox,
            mail_chimp,
            slack,
            megamenu,
            languages: [
                {
                    flag: us,
                    language: "en",
                    title: "English",
                },
                {
                    flag: fr,
                    language: "fr",
                    title: "French",
                },
                {
                    flag: es,
                    language: "es",
                    title: "Spanish",
                },
                {
                    flag: zh,
                    language: "zh",
                    title: "Chinese",
                },
                {
                    flag: ar,
                    language: "ar",
                    title: "Arabic",
                },
            ],
            lan: this.$i18n.locale,
            text: null,
            flag: null,
            value: null,
            currentUser:{}
        };
    },
    components: { simplebar, Link },
    //using vuex
    computed: {
        userDetails: function () {
            const store = useStore();
            return store.getters["LoggedInUser/getUserDetails"];
        },
    },
    mounted() {
        this.value = this.languages.find((x) => x.language === this.$i18n.locale);
        this.text = this.value.title;
        this.flag = this.value.flag;
        this.currentUser = usePage().props.auth.user
    },
    methods: {
        moduelLogout() {
            const mainURL = import.meta.env.VITE_MAIN_APP_URL;
            const url = `${mainURL}/api/auth-token/logout`;
            router.visit('/logout', {
                method: "post",
                replace: false,
                preserveState: false,
                preserveScroll: false,
                forceFormData: false,
                onFinish: (visit) => {
                    console.log({visit});
                    // location.reload();
                    // window.location.href = "/";
                },
            });
        },
        returnToMain() {
            const mainURL = import.meta.env.VITE_MAIN_APP_URL;
            const authHeaders = {
                auth_token: this.userDetails.token,
            };

            axios
                .get(`${mainURL}/api/returnFromModule`, { headers: authHeaders })
                .then((res) => {
                    console.log({res});
                    if (res.status == 200) {
                        // window.location.href = mainURL + "/dashboard";
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
    },
};
</script>

<style lang="scss" scoped>
    .navbar-vendor{
        background-color: white;
        .navbar-header{
            background-color: white;
            color: #607d8b !important;

        }
        .header-item{
            color: #607d8b !important;
        }
        .nav-icon{
            color: #607d8b !important;

        }
    }
</style>

<template>
    <header id="page-topbar" class="navbar-vendor">
        <div class="navbar-header light">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box" style="background-color: #0160a0">
                    <router-link to="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img :src="logoDarkSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoDarkLg" alt height="17" />
                        </span>
                    </router-link>

                    <router-link to="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img :src="logoLightSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoLightLg" alt height="19" />
                        </span>
                    </router-link>
                </div>

                <button id="vertical-menu-btn" type="button" class="btn btn-sm px-3 font-size-16 header-item" @click="toggleMenu">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <!-- <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" :placeholder="$t('navbar.search.text')" />
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form> -->
                  <form class="d-flex align-items-center ">
                    <div class="rounded-pill d-none d-lg-block" style="background-color: #F3F3F9; border: 0px; ">
                        <div class="input-group d-flex flex-row align-items-center">
                            <div class="mt-1">
                                <span class="" style="font-size: medium"><i class="bx bx-search-alt"></i></span>
                            </div>
                            <div><input type="text" class="form-control" :placeholder="$t('navbar.search.text')" style="background-color: #F3F3F9; border: 0px;" /></div>

                            <div class="hstack gap-3" role="button">
                                <div class="vr" style="color: #dbdbdb;"></div>
                                <div class="">filter</div>
                                <div><i class="mdi mdi-chevron-down"></i></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex">
                <b-dropdown class="d-inline-block d-lg-none ms-2" variant="black" menu-class="dropdown-menu-lg p-0" toggle-class="header-item noti-icon" right>
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
<!--
                <b-dropdown class="d-none d-lg-inline-block noti-icon" menu-class="dropdown-menu-lg dropdown-menu-end" right toggle-class="header-item" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-customize"></i>
                    </template>

                    <div class="px-lg-2">
                        <div class="row no-gutters">
                            <div class="col">
                                <Link class="dropdown-icon-item" :href="''">
                                    <img :src="finance" alt="Github" style="height: 2.7em" />
                                    <span>BSC</span>
                                </Link>
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

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon" @click="initFullScreen">
                        <i class="bx bx-fullscreen nav-icon"></i>
                    </button>
                </div>

                <b-dropdown right menu-class="dropdown-menu-lg p-0 dropdown-menu-end" toggle-class="header-item noti-icon" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-bell nav-icon"></i>
                        <span class="badge bg-danger rounded-pill">{{ $t("navbar.dropdown.notification.badge") }}</span>
                    </template>

                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">{{ $t("navbar.dropdown.notification.text") }}</h6>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="small">{{ $t("navbar.dropdown.notification.subtext") }}</a>
                            </div>
                        </div>
                    </div>
                    <simplebar style="max-height: 230px">
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t("navbar.dropdown.notification.order.title") }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t("navbar.dropdown.notification.order.text") }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t("navbar.dropdown.notification.order.time") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img :src="avatar3" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t("navbar.dropdown.notification.james.title") }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t("navbar.dropdown.notification.james.text") }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t("navbar.dropdown.notification.james.time") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t("navbar.dropdown.notification.item.title") }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t("navbar.dropdown.notification.item.text") }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t("navbar.dropdown.notification.item.time") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img :src="avatar4" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t("navbar.dropdown.notification.salena.title") }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t("navbar.dropdown.notification.salena.text") }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t("navbar.dropdown.notification.salena.time") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </simplebar>

                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-down-circle me-1"></i>
                            <span key="t-view-more"> {{ $t("navbar.dropdown.notification.button") }} </span>
                        </a>
                    </div>
                </b-dropdown>

                <b-dropdown right variant="black" toggle-class="header-item" menu-class="dropdown-menu-end">
                    <template v-slot:button-content>
                        <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                        <img :src="currentUser.profile_photo_url" :alt="'p'" class="rounded-circle header-profile-user object-fit-cover" />

                        <span class="d-none d-xl-inline-block ms-1 nav-icon">{{ currentUser.name }}</span>
                        <!-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> -->
                    </template>
                    <!-- item-->

                    <b-dropdown-item href="javascript: void(0);">
                        <i class="bx bx-wallet font-size-16 align-middle me-1"></i>

                        My Account
                    </b-dropdown-item>
                    <!-- <b-dropdown-item class="d-block" href="javascript: void(0);">
                        <span class="badge bg-success float-end">11</span>
                        <i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        {{ $t("navbar.dropdown.henry.list.settings") }}
                    </b-dropdown-item> -->

                    <!-- <div @click="returnToMain">
                        <b-dropdown-item>
                            <div>
                                <i class="bx bx bx-home font-size-16 align-middle me-1"></i>
                                Return to main
                            </div>

                            {{ $t("navbar.dropdown.henry.list.lockscreen") }}
                        </b-dropdown-item>
                    </div> -->

                    <b-dropdown-divider></b-dropdown-divider>
                    <div @click="moduelLogout" class="dropdown-item text-danger" role="button">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        {{ $t("navbar.dropdown.henry.list.logout") }}
                    </div>
                </b-dropdown>


            </div>
        </div>
    </header>
</template>
