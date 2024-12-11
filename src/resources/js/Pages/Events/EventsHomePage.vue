<script setup>
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
</script>
<template>
    <b-container class="mt-5">
        <HomeHeader />

        <div class="row" style="margin-top: 22vh;margin-bottom: 10vh;">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4 card-title">Filter</h4>

                        <div>
                            <h5 class="mb-3 font-size-14">Type</h5>
                            <ul class="list-unstyled product-list">
                                <li>
                                    <a href="javascript: void(0);"> <i class="mdi mdi-chevron-right me-1"></i> Physical Event </a>
                                </li>
                                <li>
                                    <a href="javascript: void(0);"> <i class="mdi mdi-chevron-right me-1"></i> Online Event </a>
                                </li>
                            </ul>
                        </div>
                        <div class="pt-3 mt-4">
                            <div class="form-check" v-for="(price, index) in prices" :key="index">
                                <input class="form-check-input" type="checkbox" :value="index" :id="'price' + index" v-model="selected.prices" />
                                <label class="form-check-label" :for="'price' + index"> {{ price.name }}{{ price.products_count }} </label>
                            </div>
                            <h5 class="mb-3 font-size-14">Price</h5>
                            <Slider v-model="sliderPrice" :min="0" :max="1000" @change="valuechange" />
                        </div>

                        <div class="pt-3 mt-4">
                            <h5 class="mb-3 font-size-14">Category</h5>

                            <b-form-checkbox id="productdiscountCheck1" value="accepted" unchecked-value="not_accepted" @change="discountLessFilter($event, 10)">Music</b-form-checkbox>

                            <b-form-checkbox id="productdiscountCheck2" value="accepted" unchecked-value="not_accepted" @change="discountMoreFilter($event, 10)">Arts & Culture</b-form-checkbox>

                            <b-form-checkbox id="productdiscountCheck3" value="accepted" unchecked-value="not_accepted" @change="discountMoreFilter($event, 20)">Food & Drink</b-form-checkbox>

                            <b-form-checkbox id="productdiscountCheck4" value="accepted" unchecked-value="not_accepted" @change="discountMoreFilter($event, 30)">Charity & Causes</b-form-checkbox>

                            <b-form-checkbox id="productdiscountCheck5" value="accepted" unchecked-value="not_accepted" @change="discountMoreFilter($event, 40)">Community</b-form-checkbox>

                            <b-form-checkbox id="productdiscountCheck6" value="accepted" unchecked-value="not_accepted" @change="discountMoreFilter($event, 50)">Film & Media</b-form-checkbox>
                        </div>

                        <div class="pt-3 mt-4">
                            <h5 class="mb-3 font-size-14">Region</h5>
                            <div>
                                <b-form-checkbox id="checkbox-1" name="checkbox-1" value="accepted" unchecked-value="not_accepted"> Central Region </b-form-checkbox>

                                <b-form-checkbox id="checkbox-2" name="checkbox-2" value="accepted" unchecked-value="not_accepted"> Western Region </b-form-checkbox>

                                <b-form-checkbox id="checkbox-3" name="checkbox-3" value="accepted" unchecked-value="not_accepted"> Eastern Region </b-form-checkbox>
                                <b-form-checkbox id="checkbox-4" name="checkbox-4" value="accepted" unchecked-value="not_accepted"> Eastern Region </b-form-checkbox>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="mb-3 row">
                    <div class="col-xl-4 col-sm-6">
                        <div class="mt-2">
                            <h5>Events</h5>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-6">
                        <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                            <!-- <div class="search-box me-2">
                                <div class="position-relative">
                                    <input type="text" class="border-0 form-control" placeholder="Search..." @input="searchFilter($event)" />
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div> -->
                            <ul class="nav nav-pills product-view-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript: void(0);">
                                        <i class="bx bx-grid-alt"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript: void(0);">
                                        <i class="bx bx-list-ul"></i>
                                    </a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <!-- <div v-for="(item, index) in clothsData" :key="index" class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-img position-relative">
                                <div v-if="item.discount" class="avatar-sm product-ribbon">
                                    <span class="avatar-title rounded-circle bg-primary">-{{ item.discount }}%</span>
                                </div>
                                <router-link to="/ecommerce/product-detail/">
                                    <img :src="`${item.product}`" alt class="mx-auto img-fluid d-block" />
                                </router-link>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3 text-truncate">
                                    <router-link class="text-dark" to="/ecommerce/product-detail">{{ item.name }}</router-link>
                                </h5>
                                <p class="text-muted">
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                </p>
                                <h5 class="my-0">
                                    <b>${{ item.newprice }}</b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div> -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <!-- <b-pagination  class="justify-content-center" pills v-model="currentPage" :total-rows="clothsData.length" :per-page="6" aria-controls="my-table"></b-pagination> -->
                    </div>
                </div>
            </div>
        </div>
    </b-container>
    <FooterSection />
</template>
