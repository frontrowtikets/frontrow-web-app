<script>
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";

import { tasksChart, tasks } from "./data-tasklist";
// import { required } from "vuelidate/lib/validators";

import avatar1 from '../../../images/users/avatar-1.jpg';
import avatar2 from '../../../images/users/avatar-2.jpg';
import avatar3 from '../../../images/users/avatar-3.jpg';
import avatar4 from '../../../images/users/avatar-4.jpg';
import avatar5 from '../../../images/users/avatar-5.jpg';
import avatar7 from '../../../images/users/avatar-7.jpg';
import avatar8 from '../../../images/users/avatar-8.jpg';

/**
 * Task-list component
 */
export default {
  components: { Layout, PageHeader },
  data() {
    return {
      avatar1, avatar2, avatar3, avatar4, avatar5, avatar7, avatar8,
      tasksChart: tasksChart,
      inprogressTasks: "",
      upcomingTasks: "",
      completedTasks: "",
      title: "Task List",
      items: [
        {
          text: "Tasks",
          href: "/",
        },
        {
          text: "Task List",
          active: true,
        },
      ],
       taskList: {
        name: "",
      },
      myFiles: [],
      selected: "",
      selected2: "",
      submitted: false,
      showModal: false,
    };
  },
  mounted() {
    this.isMountData();
    // all tasks
  },
  methods: {

    isMountData() {
      this.tasks = tasks;
      this.inprogressTasks = tasks.filter((t) => t.taskType === "inprogress");
      this.upcomingTasks = tasks.filter((t) => t.taskType === "upcoming");
      this.completedTasks = tasks.filter((t) => t.taskType === "completed");
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start">
              <h4 class="mb-4 card-title">Upcoming</h4>
            </div>
            <div class="mb-0 table-responsive">
              <table class="table mb-0 align-middle table-nowrap">
                <tbody>
                  <tr v-for="task of upcomingTasks" :key="task.index">
                    <td style="width: 40px">
                      <b-form-checkbox
                        class="form-check"
                        v-model="task.checked"
                      >
                      </b-form-checkbox>
                    </td>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="javascript: void(0);" class="text-dark">{{
                          task.name
                        }}</a>
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div
                          class="avatar-group-item"
                          v-for="(data, index) of task.images"
                          :key="index"
                        >
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="`${data}`"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <span
                          class="badge rounded-pill font-size-11"
                          :class="{
                            'badge-soft-success': task.status === 'Complete',
                            'badge-soft-warning': task.status === 'Pending',
                            'badge-soft-primary': task.status === 'Approved',
                            'badge-soft-secondary': task.status === 'Waiting',
                          }"
                          >{{ task.status }}</span
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start">
              <h4 class="mb-4 card-title">In Progress</h4>
            </div>
            <div class="mb-0 table-responsive">
              <table class="table table-nowrap table-centered">
                <tbody>
                  <tr v-for="task of inprogressTasks" :key="task.index">
                    <td style="width: 40px">
                       <b-form-checkbox
                        class="form-check" v-model="task.checked">
                      </b-form-checkbox>
                    </td>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="javascript: void(0);" class="text-dark">{{
                          task.name
                        }}</a>
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div
                          class="avatar-group-item"
                          v-for="(data, index) of task.images"
                          :key="index"
                        >
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="`${data}`"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <span
                          class="badge rounded-pill font-size-11"
                          :class="{
                            'badge-soft-success': task.status === 'Complete',
                            'badge-soft-warning': task.status === 'Pending',
                            'badge-soft-primary': task.status === 'Approved',
                            'badge-soft-secondary': task.status === 'Waiting',
                          }"
                          >{{ task.status }}</span
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start">
              <h4 class="mb-4 card-title">Completed</h4>
            </div>
            <div class="mb-0 table-responsive">
              <table class="table table-nowrap table-centered">
                <tbody>
                  <tr v-for="task of completedTasks" :key="task.index">
                    <td style="width: 40px">
                       <b-form-checkbox
                        class="form-check" v-model="task.checked">
                      </b-form-checkbox>
                    </td>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="javascript: void(0);" class="text-dark">{{
                          task.name
                        }}</a>
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div
                          class="avatar-group-item"
                          v-for="(data, index) of task.images"
                          :key="index"
                        >
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="`${data}`"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <span
                          class="badge rounded-pill font-size-11"
                          :class="{
                            'badge-soft-success': task.status === 'Complete',
                            'badge-soft-warning': task.status === 'Pending',
                            'badge-soft-primary': task.status === 'Approved',
                            'badge-soft-secondary': task.status === 'Waiting',
                          }"
                          >{{ task.status }}</span
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->

      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-3 card-title">Tasks</h4>

            <apexchart
              class="apex-charts"
              type="line"
              height="280"
              :series="tasksChart.series"
              :options="tasksChart.chartOptions"
            ></apexchart>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h4 class="mb-4 card-title">Recent Tasks</h4>

            <div class="table-responsive">
              <table class="table mb-0 align-middle table-nowrap">
                <tbody>
                  <tr>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="#" class="text-dark">Brand logo design</a>
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar4"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar5"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="#" class="text-dark"
                          >Create a Blog Template UI</a
                        >
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar1"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar2"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar3"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <div class="avatar-xs">
                              <span
                                class="text-white avatar-title rounded-circle bg-info font-size-16"
                              >
                                D
                              </span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5 class="m-0 text-truncate font-size-14">
                        <a href="#" class="text-dark"
                          >Redesign - Landing page</a
                        >
                      </h5>
                    </td>
                    <td>
                      <div class="avatar-group">
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar8"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <img
                              :src="avatar7"
                              alt=""
                              class="rounded-circle avatar-xs"
                            />
                          </a>
                        </div>
                        <div class="avatar-group-item">
                          <a href="javascript: void(0);" class="d-inline-block">
                            <div class="avatar-xs">
                              <span
                                class="text-white avatar-title rounded-circle bg-danger font-size-16"
                              >
                                P
                              </span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- end table responsive -->
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
