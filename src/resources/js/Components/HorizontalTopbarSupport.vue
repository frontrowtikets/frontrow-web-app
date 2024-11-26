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

import { Head, Link, router,usePage } from "@inertiajs/vue3";
import axios from "axios";

import { useStore } from "vuex";

export default {
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
            currentUser:{}
        };
    },

    //using vuex
    computed: {
        userDetails: function () {
            const store = useStore();
            return store.getters["LoggedInUser/getUserDetails"];
        },
    },
    mounted() {
        this.currentUser = usePage().props.auth.user
    },
    methods: {
        logout() {
            // router.post(route("logout"));
            router.visit("/logout", {
                method: "post",
                replace: false,
                preserveState: false,
                preserveScroll: false,
                forceFormData: false,
                onStart: (visit) => {
                    location.reload();
                },
            });
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
        goBack(){
            window.history.back();
        }
        
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header" style="background-color: #0160a0">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <div role="button" class="logo logo-dark">
                        <span class="logo-sm">
                            <img :src="logoDarkSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoDarkLg" alt height="17" />
                        </span>
                    </div>

                    <div role="button"  class="logo logo-light">
                        <span class="logo-sm">
                            <img :src="logoLightSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoLightLg" alt height="19" />
                        </span>
                    </div>
                </div>


                <!-- App Search-->
              
                

            </div>

            <div class="d-flex">
               


                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon" @click="initFullScreen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="dropdown d-none d-lg-inline-block ml-1">
                   <button type="button" class="btn header-item noti-icon text-white" @click="goBack">
                        Go Back
                    </button>
                </div>

            </div>
        </div>
    </header>
</template>
