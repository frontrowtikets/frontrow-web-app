<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, onMounted } from "vue";
import simplebar from "simplebar-vue";
import icondata from "@/images/icondata.png";
import axios from "axios";
// import 'simplebar-vue/dist/simplebar.min.css';

defineOptions({ layout: DashboardLayout });
const props = defineProps(["incidentCount"]);
const state = reactive({});
</script>
<template>
    <div>
        <Head title="Dashboard" />
        <PageHeader title="Dashboard" :items="state.items" />
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                            <img :src="usePage().props.auth.user.profile_photo_url" :alt="'p'" class="rounded-circle header-profile-user object-fit-cover" />
                        </div>
                    </div>

                    <div class="card-body border-top">
                        <div class="row">
                            <div class="mt-4 col-sm-6">
                                <div class="pb-5">
                                    <p class="fw-medium">Tickets</p>
                                    <h4>{{ props.incidentCount }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-6"></div>
                        </div>
                    </div>

                    <div class="mb-3 bg-transparent card-footer border-top">
                        <div class="text-center" @click="reportIncident">
                            <div class="btn btn-primary me-2 w-md">Create Ticket</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div>
                        <div class="row">
                            <div class="col-lg-9 col-sm-8">
                                <div class="p-4">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>FRONTROW Application Platform</p>

                                    <div class="text-muted">
                                        <p class="mb-1">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Book Tickets
                                        </p>
                                        <p class="mb-1">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Load wallet & make transactions.
                                        </p>
                                        <p class="mb-0">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Create Events & Manage Clients.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 align-self-center">
                                <div>
                                    <img src="@/images/profile-img.png" alt class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-4 text-muted">My Tickets</p>

                                <div class="row">
                                    <div class="col-6">
                                        <div>
                                            <h5>12</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <!-- <apexchart class="apex-charts" height="40" type="area" dir="ltr" :series="bitconinChart.series" :options="bitconinChart.chartOptions"></apexchart> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-4 text-muted">
                                    <!-- <i class="mb-0 align-middle mdi mdi-ethereum h2 text-primary me-3"></i> -->
                                    My Wallet Balance
                                </p>

                                <div class="row">
                                    <div class="col-6">
                                        <div>
                                            <h5>UGX 10,000</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <!-- <apexchart class="apex-charts" height="40" type="area" dir="ltr" :series="ethereumChart.series" :options="ethereumChart.chartOptions"></apexchart> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-4 text-muted">
                                    <!-- <i class="mb-0 align-middle mdi mdi-litecoin h2 text-info me-3"></i> -->
                                    Overview
                                </p>

                                <div class="row">
                                    <div class="col-6">
                                        <div>
                                            <h5>{{}} //</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <!-- <apexchart class="apex-charts" height="40" type="area" dir="ltr" :series="litecoinChart.series" :options="litecoinChart.chartOptions"></apexchart> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-8">
                <WalletBalance />
            </div>
            <div class="col-xl-4">
                <Overview />
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4 card-title">Transactions</h4>
                        <b-tabs pills nav-class="rounded bg-light" content-class="mt-4">
                            <b-tab title="All" active>
                                <b-card-text>
                                    <!-- <simpleBar style="max-height: 100vh"> -->
                                    <!-- <table class="table align-middle table-centered table-nowrap">
                                             <tbody>
                                                <tr v-for="data of transactionsData" :key="data.icon">
                                                    <td style="width: 50px">
                                                        <div :class="`font-size-22 text-${data.color}`">
                                                            <i
                                                                :class="{
                                                                    'bx bx-down-arrow-circle': `${data.color}` === 'primary',
                                                                    'bx bx-up-arrow-circle': `${data.color}` === 'danger',
                                                                }"
                                                            ></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="mb-1 font-size-14">{{ data.name }}</h5>
                                                            <p class="mb-0 text-muted">{{ data.date }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14">{{ data.text }}</h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14 text-muted">
                                                                {{ data.price }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                    <div v class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                    <!-- </simpleBar> -->
                                </b-card-text>
                            </b-tab>
                            <b-tab title="processing">
                                <b-card-text>
                                    <!-- <simpleBar style="max-height: 330px"> -->
                                    <!-- <table class="table align-middle table-centered table-nowrap">
                                            <tbody>
                                                <tr v-for="data of transactionsData" :key="data.id">
                                                    <td style="width: 50px">
                                                        <div :class="`font-size-22 text-${data.color}`">
                                                            <i
                                                                :class="{
                                                                    'bx bx-down-arrow-circle': `${data.color}` === 'primary',
                                                                    'bx bx-up-arrow-circle': `${data.color}` === 'danger',
                                                                }"
                                                            ></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="mb-1 font-size-14">{{ data.name }}</h5>
                                                            <p class="mb-0 text-muted">{{ data.date }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14">{{ data.text }}</h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14 text-muted">
                                                                {{ data.price }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                    <div v class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                    <!-- </simpleBar> -->
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Successful">
                                <b-card-text>
                                    <!-- <simpleBar style="max-height: 330px"> -->
                                    <!-- <table class="table align-middle table-centered table-nowrap">
                                            <tbody>
                                                <tr v-for="data of transactionsData" :key="data.id">
                                                    <td style="width: 50px">
                                                        <div :class="`font-size-22 text-${data.color}`">
                                                            <i
                                                                :class="{
                                                                    'bx bx-down-arrow-circle': `${data.color}` === 'primary',
                                                                    'bx bx-up-arrow-circle': `${data.color}` === 'danger',
                                                                }"
                                                            ></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="mb-1 font-size-14">{{ data.name }}</h5>
                                                            <p class="mb-0 text-muted">{{ data.date }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14">{{ data.text }}</h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14 text-muted">
                                                                {{ data.price }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                    <div v class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                    <!-- </simpleBar> -->
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Failed">
                                <b-card-text>
                                    <!-- <simpleBar style="max-height: 330px"> -->
                                    <!-- <table class="table align-middle table-centered table-nowrap">
                                            <tbody>
                                                <tr v-for="data of transactionsData" :key="data.id">
                                                    <td style="width: 50px">
                                                        <div :class="`font-size-22 text-${data.color}`">
                                                            <i
                                                                :class="{
                                                                    'bx bx-down-arrow-circle': `${data.color}` === 'primary',
                                                                    'bx bx-up-arrow-circle': `${data.color}` === 'danger',
                                                                }"
                                                            ></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="mb-1 font-size-14">{{ data.name }}</h5>
                                                            <p class="mb-0 text-muted">{{ data.date }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14">{{ data.text }}</h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="mb-0 font-size-14 text-muted">
                                                                {{ data.price }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                    <div v class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                    <!-- </simpleBar> -->
                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4 card-title">Notifications</h4>
                        <div v class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                            <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                            <div>No Notifications Yet.</div>
                        </div>
                        <!-- <ul class="list-group">
                                <li class="border-0 list-group-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="@/images/companies/img-1.png" alt height="18" />
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14">Donec vitae sapien ut</h5>
                                            <p class="text-muted">If several languages coalesce, the grammar of the resulting language</p>

                                            <div class="float-end">
                                                <p class="mb-0 text-muted"><i class="mdi mdi-account me-1"></i> Joseph</p>
                                            </div>
                                            <p class="mb-0 text-muted">12 Mar, 2020</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="border-0 list-group-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="@/images/companies/img-2.png" alt height="18" />
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14">Cras ultricies mi eu turpis</h5>
                                            <p class="text-muted">To an English person, it will seem like simplified English, as a skeptical cambridge</p>

                                            <div class="float-end">
                                                <p class="mb-0 text-muted"><i class="mdi mdi-account me-1"></i> Jerry</p>
                                            </div>
                                            <p class="mb-0 text-muted">13 Mar, 2020</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="border-0 list-group-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="@/images/companies/img-3.png" alt height="18" />
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14">Duis arcu tortor suscipit</h5>
                                            <p class="text-muted">It va esser tam simplic quam occidental in fact, it va esser occidental.</p>

                                            <div class="float-end">
                                                <p class="mb-0 text-muted"><i class="mdi mdi-account me-1"></i> Calvin</p>
                                            </div>
                                            <p class="mb-0 text-muted">14 Mar, 2020</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="border-0 list-group-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="@/images/companies/img-1.png" alt height="18" />
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-14">Donec vitae sapien ut</h5>
                                            <p class="text-muted">If several languages coalesce, the grammar of the resulting language</p>

                                            <div class="float-end">
                                                <p class="mb-0 text-muted"><i class="mdi mdi-account me-1"></i> Joseph</p>
                                            </div>
                                            <p class="mb-0 text-muted">12 Mar, 2020</p>
                                        </div>
                                    </div>
                                </li>
                        </ul> -->
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4 card-title">My Events</h4>
                        <div v class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                            <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                            <div>No Events Yet.</div>
                        </div>
                        <!-- <b-tabs pills nav-class="rounded bg-light" content-class="mt-4">
                            <b-tab title="Buy" active>
                                <b-card-text>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-14">
                                            <i class="align-middle bx bx-wallet text-primary font-size-16 me-1"></i>
                                            $4235.23
                                        </h5>
                                    </div>
                                    <h5 class="mb-4 font-size-14">Buy Coin</h5>

                                    <div>
                                        <div class="mb-3 form-group">
                                            <label>Payment method :</label>
                                            <select class="form-select">
                                                <option>Credit / Debit Card</option>
                                                <option>Paypal</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label>Add Amount :</label>
                                            <div class="mb-3 input-group">
                                                <label class="input-group-text">Amount</label>
                                                <select class="form-select" style="max-width: 90px">
                                                    <option value="BT" selected>BTC</option>
                                                    <option value="ET">ETH</option>
                                                    <option value="LT">LTC</option>
                                                </select>
                                                <input type="text" class="form-control" />
                                            </div>

                                            <div class="mb-3 input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">Price</label>
                                                </div>
                                                <input type="text" class="form-control" />
                                                <div class="input-group-append">
                                                    <label class="input-group-text">$</label>
                                                </div>
                                            </div>

                                            <div class="mb-3 input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">Total</label>
                                                </div>
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" class="btn btn-success w-md">Buy Coin</button>
                                        </div>
                                    </div>
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Sell">
                                <b-card-text>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-14">
                                            <i class="align-middle bx bx-wallet text-primary font-size-16 me-1"></i>
                                            $4235.23
                                        </h5>
                                    </div>
                                    <h5 class="mb-4 font-size-14">Sell Coin</h5>

                                    <div>
                                        <div class="mb-3 form-group">
                                            <label>Email :</label>
                                            <input type="email" class="form-control" />
                                        </div>
                                        <div>
                                            <label>Add Amount :</label>
                                            <div class="mb-3 input-group">
                                                <label class="input-group-text">Amount</label>

                                                <select class="form-select" style="max-width: 90px">
                                                    <option value="BT" selected>BTC</option>
                                                    <option value="ET">ETH</option>
                                                    <option value="LT">LTC</option>
                                                </select>
                                                <input type="text" class="form-control" />
                                            </div>

                                            <div class="mb-3 input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">Price</label>
                                                </div>
                                                <input type="text" class="form-control" />
                                                <div class="input-group-append">
                                                    <label class="input-group-text">$</label>
                                                </div>
                                            </div>

                                            <div class="mb-3 input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">Total</label>
                                                </div>
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" class="btn btn-danger w-md">Sell Coin</button>
                                        </div>
                                    </div>
                                </b-card-text>
                            </b-tab>
                        </b-tabs> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
