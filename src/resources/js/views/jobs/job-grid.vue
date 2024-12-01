<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import Datepicker from "vue3-datepicker";

import adobe from '../../../images/companies/adobe.svg';
import adobephoto from '../../../images/companies/adobe-photoshop.svg';
import airbnb from '../../../images/companies/airbnb.svg';
import amazon from '../../../images/companies/amazon.svg';
import flutter from '../../../images/companies/flutter.svg';
import mailchimp from '../../../images/companies/mailchimp.svg';
import line from '../../../images/companies/line.svg';
import spotify from '../../../images/companies/spotify.svg';
import wordpress from '../../../images/companies/wordpress.svg';
import upwork from '../../../images/companies/upwork.svg';
import sass from '../../../images/companies/sass.svg';
import reddit from '../../../images/companies/reddit.svg';


/**
 * Starter component
 */
export default {
    page: {
        title: "Jobs Grid",
    },
    components: { Layout, PageHeader, Datepicker },
    data() {
        return {
            adobe, adobephoto, airbnb, amazon, flutter, mailchimp, line, spotify, wordpress, upwork, sass, reddit,
            title: "Jobs Grid",
            items: [
                {
                    text: "Jobs",
                    href: "/"
                },
                {
                    text: "Jobs Grid",
                    active: true
                }
            ],
        };
    }
};
</script>
<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card job-filter">
                    <div class="card-body p-3">
                        <form action="javascript:void(0);">
                            <div class="row g-3">
                                <div class="col-xxl-4 col-lg-4">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="searchJob" autocomplete="off"
                                            placeholder="Search your job">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-lg-4">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="locationInput" autocomplete="off"
                                            placeholder="San Francisco, LA">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-lg-4">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="jobCategories" autocomplete="off"
                                            placeholder="Job Categories">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-lg-6">
                                    <div class="position-relative">
                                        <div id="datepicker1">
                                            <Datepicker placeholder="Select Date" class="form-control"
                                                :first-day-of-week="1" lang="en" confirm></Datepicker>
                                        </div><!-- input-group -->
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-2 col-lg-6">
                                    <div class="position-relative h-100 hstack gap-3">
                                        <button type="submit" class="btn btn-primary h-100 w-100"><i
                                                class="bx bx-search-alt align-middle"></i> Find Jobs</button>
                                        <a href="#collapseExample" data-bs-toggle="collapse"
                                            class="btn btn-secondary h-100 w-100"><i
                                                class="bx bx-filter-alt align-middle"></i> Advance</a>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="collapse" id="collapseExample">
                                    <div class="pt-4">
                                        <div class="row g-3">
                                            <div class="col-xxl-4 col-lg-6">
                                                <div>
                                                    <label for="experience" class="form-label">Experience</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox1">All</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox2">Fresher</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        value="option2">
                                                    <label class="form-check-label" for="inlineCheckbox3">1-2</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        value="option2">
                                                    <label class="form-check-label" for="inlineCheckbox4">2-3</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        value="option3">
                                                    <label class="form-check-label" for="inlineCheckbox5">4+</label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-lg-6">
                                                <div>
                                                    <label for="jobType" class="form-label">Job Type</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                                        value="option3">
                                                    <label class="form-check-label" for="inlineCheckbox6">Full Time</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                                        value="option3">
                                                    <label class="form-check-label" for="inlineCheckbox7">Part Time</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox8"
                                                        value="option3">
                                                    <label class="form-check-label" for="inlineCheckbox8">Freelance</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox9"
                                                        value="option3">
                                                    <label class="form-check-label" for="inlineCheckbox9">Internship</label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-lg-4">
                                                <div class="position-relative">
                                                    <label for="qualificationInput" class="form-label">Qualification</label>
                                                    <input type="text" class="form-control" id="qualificationInput"
                                                        autocomplete="off" placeholder="Qualification">
                                                    <i class="ri-government-line filter-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row" id="jobgrid-list">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="adobe" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="adobephoto" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Product Designer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="airbnb" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Marketing Director</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="amazon" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Project Manager</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="flutter" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">HTML Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="mailchimp" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Business Associate</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="line" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Product Sales Specialist</a>
                            <small class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="spotify" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="wordpress" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="upwork" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="sass" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img :src="reddit" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="javascript:void(0);" class="text-dark">Magento Developer</a> <small
                                class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-1">Skote Technology Pvt.Ltd</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted fs-14 mb-0"><i class="uil uil-wallet"></i> $250 - $800 / month</p>
                            </li>
                        </ul>
                        <div class="mt-3 hstack gap-2">
                            <span class="badge rounded-1 badge-soft-success">Full Time</span>
                            <span class="badge rounded-1 badge-soft-warning">Urgent</span>
                            <span class="badge rounded-1 badge-soft-info">Private</span>
                        </div>
                        <div class="mt-4 hstack gap-2">
                            <router-link to="/jobs/details" class="btn btn-soft-success w-100">View Profile</router-link>
                            <a href="#" class="btn btn-soft-primary w-100">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div><!--end row-->

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-auto me-auto">
                <p class="text-muted mb-0">Showing <b>1</b> to <b>12</b> of <b>45</b> entries</p>
            </div>
            <div class="col-auto">
            <div class="card d-inline-block ms-auto mb-0">
                <div class="card-body p-2">
                    <nav aria-label="Page navigation example" class="mb-0">
                        <ul class="pagination mb-0">
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">12</a></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div><!--end col-->
    </div>

</Layout></template>