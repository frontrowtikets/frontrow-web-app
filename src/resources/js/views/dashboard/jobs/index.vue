<script>
import Layout from "../../../layouts/main.vue";
import { SimpleBar } from "simplebar-vue3";
import StatisticsApplicationsChart from "./statistics-applications-chart.vue";
import ApplicationReceviedTime from "./application-recevied-time.vue";

import avatar1 from '../../../../images/users/avatar-1.jpg';
import avatar2 from '../../../../images/users/avatar-2.jpg';
import avatar3 from '../../../../images/users/avatar-3.jpg';
import avatar4 from '../../../../images/users/avatar-4.jpg';
import avatar5 from '../../../../images/users/avatar-5.jpg';
import jobs from '../../../../images/jobs.png';
import airbnb from '../../../../images/companies/airbnb.svg';
import mailchimp from '../../../../images/companies/mailchimp.svg';
import reddit from '../../../../images/companies/reddit.svg';
import amazon from '../../../../images/companies/amazon.svg';
import adobephoto from '../../../../images/companies/adobe-photoshop.svg';
import line from '../../../../images/companies/line.svg';
import wechat from '../../../../images/companies/wechat.svg';
import sass from '../../../../images/companies/sass.svg';
import adobe from '../../../../images/companies/adobe.svg';
import flutter from '../../../../images/companies/flutter.svg';
import spotify from '../../../../images/companies/spotify.svg';

/**
 * Starter component
 */
export default {
  page: {
    title: "Job Dashboard",
  },
  components: { Layout, StatisticsApplicationsChart, ApplicationReceviedTime, SimpleBar },
  data() {
    return {
      title: "Job Dashboard",
      avatar1,
      avatar2,
      avatar3,
      avatar4,
      avatar5,
      jobs,
      airbnb,
      mailchimp,
      reddit,
      amazon,
      adobephoto,
      line,
      wechat,
      sass,
      adobe,
      airbnb,
      flutter,
      spotify,
      jobWidgets: [
        {
          id: 1,
          label: "Job View",
          counter: "14,487",
          badge: "bx bx-trending-up",
          badgeColor: "success",
          percentage: "18.89%",
          chartsColor: "#34c38f",
          chartOptions: {
            chart: {
              width: "100%",
              height: 46,
              type: "area",
              sparkline: {
                enabled: true,
              },
              toolbar: {
                show: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            stroke: {
              curve: "smooth",
              width: 1.5,
            },
            fill: {
              type: "gradient",
              gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [50, 100, 100, 100],
              },
            },
            colors: ["#34c38f"],
          },
          series: [
            {
              name: "Job View",
              data: [36, 21, 65, 22, 35, 50, 87, 98],
            },
          ],
        },
        {
          id: 2,
          label: "New Application",
          counter: "7,402",
          badge: "bx bx-trending-up",
          badgeColor: "success",
          percentage: "24.07%",
          chartOptions: {
            chart: {
              width: "100%",
              height: 46,
              type: "area",
              sparkline: {
                enabled: true,
              },
              toolbar: {
                show: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            stroke: {
              curve: "smooth",
              width: 1.5,
            },
            fill: {
              type: "gradient",
              gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [50, 100, 100, 100],
              },
            },
            colors: ["#34c38f"],
          },
          series: [
            {
              name: "New Application",
              data: [36, 48, 10, 74, 35, 50, 70, 73],
            },
          ],
        },
        {
          id: 3,
          label: "Total Approved",
          counter: "12,487",
          badge: "bx bx-trending-up",
          badgeColor: "success",
          percentage: "8.41%",
          chartOptions: {
            chart: {
              width: "100%",
              height: 46,
              type: "area",
              sparkline: {
                enabled: true,
              },
              toolbar: {
                show: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            stroke: {
              curve: "smooth",
              width: 1.5,
            },
            fill: {
              type: "gradient",
              gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [50, 100, 100, 100],
              },
            },
            colors: ["#34c38f"],
          },
          series: [
            {
              name: "Total Approved",
              data: [60, 14, 5, 60, 30, 43, 65, 84],
            },
          ],
        },
        {
          id: 4,
          label: "Total Rejected",
          counter: "14,487",
          badge: "bx bx-trending-down",
          badgeColor: "danger",
          percentage: "20.63%",
          chartOptions: {
            chart: {
              width: "100%",
              height: 46,
              type: "area",
              sparkline: {
                enabled: true,
              },
              toolbar: {
                show: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            stroke: {
              curve: "smooth",
              width: 1.5,
            },
            fill: {
              type: "gradient",
              gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [50, 100, 100, 100],
              },
            },
            colors: ["#f46a6a"],
          },
          series: [
            {
              name: "Total Rejected",
              data: [32, 22, 7, 55, 20, 45, 36, 20],
            },
          ],
        },
      ]
    };

  }
};
</script>
<template>
  <Layout>
    <div class="row mb-4">
      <div class="col-lg-12">
        <div class="d-flex align-items-center">
          <img :src="avatar1" alt="" class="avatar-sm rounded">
          <div class="ms-3 flex-grow-1">
            <h5 class="mb-2 card-title">Hello, Henry Franklin</h5>
            <p class="text-muted mb-0">Ready to jump back in?</p>
          </div>
          <div>
            <a href="javascript:void(0);" class="btn btn-primary"><i class="bx bx-plus align-middle"></i> Add New
              Jobs</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-3 col-md-6" v-for="(item, index) of jobWidgets" :key="index">
        <div class="card mini-stats-wid">
          <div class="card-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="text-muted fw-medium">{{ item.label }}</p>
                <h4 class="mb-0">{{ item.counter }}</h4>
              </div>

              <div class="flex-shrink-0 align-self-center">
                <apexchart class="apex-charts" :options="item.chartOptions" width="130" height="46" dir="ltr"
                  :series="item.series.length > 0 ? item.series : []" :key="item.id"></apexchart>
              </div>
            </div>
          </div>
          <div class="card-body border-top py-3">
            <p class="mb-0"> <span :class="`badge badge-soft-${item.badgeColor} me-1`">
                <i :class="`${item.badge} align-bottom me-1`"></i> {{ item.percentage }}</span>
              {{ item.badgeColor == "success" ? 'Increase' : 'Decrease' }} last month
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-8">
        <StatisticsApplicationsChart />
      </div><!--end col-->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex">
              <div>
                <h4 class="card-title mb-3">Invite your friends to Skote</h4>
                <p class="text-muted">Nor again is there anyone who loves or pursues or desires to obtain pain of
                  itself, because it is pain, but because occasionally.</p>
                <div>
                  <a href="javascript:void(0);" class="btn btn-primary btn-sm"><i
                      class='bx bx-user-plus align-middle'></i> Invite Friends</a>
                </div>
              </div>
              <div>
                <img :src="jobs" alt="" height="130">
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-3">Popular Candidate</h4>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="3000">
                  <div class="bg-light p-3 d-flex mb-3 rounded">
                    <img :src="avatar4" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Stephen
                          Hadley</router-link> <span class="badge badge-soft-info">Freelance</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Germany</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton11"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="bg-light p-3 d-flex">
                    <img :src="avatar2" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Charles
                          Brown</router-link> <span class="badge badge-soft-success">Full Time</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Cambodia</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton12"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton12">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                  <div class="bg-light p-3 d-flex mb-3 rounded">
                    <img :src="avatar1" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Adam
                          Miller</router-link> <span class="badge badge-soft-warning">Internship</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Australia</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton13"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton13">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="bg-light p-3 d-flex">
                    <img :src="avatar3" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Keith
                          Gonzales</router-link> <span class="badge badge-soft-info">Freelance</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Belgium</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton14"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton14">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                  <div class="bg-light p-3 d-flex mb-3 rounded">
                    <img :src="avatar4" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Bonnie
                          Harney</router-link> <span class="badge badge-soft-success">Full Timer</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Syria</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton15"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton15">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="bg-light p-3 d-flex">
                    <img :src="avatar2" alt="" class="avatar-sm rounded me-3">
                    <div class="flex-grow-1">
                      <h5 class="font-size-15 mb-2"><router-link to="/jobs/candidate/overview" class="text-body">Dolores
                          Minter</router-link> <span class="badge badge-soft-danger">Part Time</span></h5>
                      <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> San Marino</p>
                    </div>
                    <div>
                      <div class="dropdown">
                        <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton16"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class='bx bx-dots-vertical-rounded'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton16">
                          <li><router-link class="dropdown-item" to="/jobs/candidate/overview">View Details</router-link></li>
                          <li><a class="dropdown-item" href="#">Download CV</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
    </div><!--end row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="d-flex">
          <h4 class="card-title mb-4 flex-grow-1">New Job Vacancy</h4>
          <div>
            <router-link to="/jobs/job-list" class="btn btn-primary btn-sm">View All <i class="bx bx-right-arrow-alt"></i></router-link>
          </div>
        </div>
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="airbnb" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Project Manager</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>

            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> California</p>
              <p class="mb-0 text-muted"><b>8</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="mailchimp" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Marketing Director</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>
            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> Danemark</p>
              <p class="mb-0 text-muted"><b>12</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="reddit" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Product Designer</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>
            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> France</p>
              <p class="mb-0 text-muted"><b>25</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="amazon" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Magento Developer</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>
            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> Hong-Kong</p>
              <p class="mb-0 text-muted"><b>8</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="adobephoto" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Product Sales Specialist</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>
            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> Louisiana</p>
              <p class="mb-0 text-muted"><b>1</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-2 col-md-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <img :src="line" alt="" class="avatar-sm">
              <router-link to="/jobs/details" class="text-body">
                <h5 class="mt-4 mb-2 font-size-15">Business Associate</h5>
              </router-link>
              <p class="mb-0 text-muted">Themesbrand</p>
            </div>
            <div class="d-flex">
              <p class="mb-0 flex-grow-1 text-muted"><i class="bx bx-map text-body"></i> Phoenix</p>
              <p class="mb-0 text-muted"><b>15</b> Vacancy</p>
            </div>
          </div>
        </div><!--end card-->
      </div><!--end col-->
    </div><!--end row-->

    <div class="row">
      <div class="col-xl-4">
        <ApplicationReceviedTime />
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Activity Feed</h4>
            <SimpleBar style="max-height: 376px;">
              <ul class="verti-timeline list-unstyled">
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <img :src="avatar5" alt="" class="avatar-xs rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <b>Charles Brown</b> applied for the job <b>Sr.frontend Developer</b>
                        <p class="mb-0 text-muted">3 min ago</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar-xs">
                        <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                          <i class='bx bx-revision font-size-14'></i>
                        </div>
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        Your subscription expires today <a href="javascript: void(0);">Renew Now</a>
                        <p class="text-muted mb-0">53 min ago</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar-xs">
                        <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                          JA
                        </div>
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <b>Jennifer Alexandar</b> created a new account as a <b>Freelance</b>.
                        <p class="text-muted mb-0">1 hrs ago</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <img :src="avatar2" alt="" class="avatar-xs rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <b>Mark Ellison</b> applied for the job <b>Project Manager</b>
                        <p class="mb-0 text-muted">3 hrs ago</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar-xs">
                        <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                          AZ
                        </div>
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <b>Acolin Zelton</b> created a new account as a <b>Freelance</b>.
                        <p class="text-muted mb-0">1 hrs ago</p>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="text-center mt-4"><a href="javascript: void(0);"
                  class="btn btn-primary waves-effect waves-light btn-sm">View More <i
                    class="mdi mdi-arrow-right ms-1"></i></a></div>
            </SimpleBar>
          </div>
        </div><!--end card-->
      </div><!--end col-->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Recent Added Jobs</h4>
            <SimpleBar data-simplebar style="max-height: 376px;">
              <div class="vstack gap-4">
                <div class="d-flex">
                  <img :src="wechat" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Marketing Director</router-link>
                    </h6>
                    <p class="text-muted mb-0">Themesbrand, USA - <b>53</b> sec ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>

                <div class="d-flex">
                  <img :src="sass" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Frontend Developer</router-link>
                    </h6>
                    <p class="text-muted mb-0">Themesbrand, Hong-Kong - <b>47</b> min ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>

                <div class="d-flex">
                  <img :src="adobe" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">React Developer</router-link>
                    </h6>
                    <p class="text-muted mb-0">Creative Agency, Danemark - <b>1</b> hrs ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
                <div class="d-flex">
                  <img :src="airbnb" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">NodeJs Developer</router-link>
                    </h6>
                    <p class="text-muted mb-0">Skote Themes, Louisiana - <b>2</b> hrs ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
                <div class="d-flex">
                  <img :src="flutter" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Digital Marketing</router-link>
                    </h6>
                    <p class="text-muted mb-0">Web Technology pvt.Ltd, Danemark - <b>8</b> hrs ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
                <div class="d-flex">
                  <img :src="mailchimp" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Marketing Director</router-link>
                    </h6>
                    <p class="text-muted mb-0">Skote Technology, Dominica - <b>1</b> days ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
                <div class="d-flex">
                  <img :src="spotify" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Business Associate</router-link>
                    </h6>
                    <p class="text-muted mb-0">Themesbrand, Russia - <b>2</b> days ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
                <div class="d-flex">
                  <img :src="reddit" alt="" height="40" class="rounded">
                  <div class="ms-2 flex-grow-1">
                    <h6 class="mb-1 font-size-15"><router-link to="/jobs/details" class="text-body">Backend Developer</router-link>
                    </h6>
                    <p class="text-muted mb-0">Adobe Agency, Malaysia - <b>3</b> days ago</p>
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                      <li><router-link class="dropdown-item" to="/jobs/details">View Details</router-link ></li>
                      <li><a class="dropdown-item" href="#">Apply Now</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </SimpleBar>
          </div>
        </div><!--end card-->
      </div><!--end col-->
    </div><!--end row-->
  </Layout>
</template>