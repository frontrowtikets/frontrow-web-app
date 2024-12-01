<script>

import { VueDraggableNext } from 'vue-draggable-next'

import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";

import { upcomingTasks, progressTasks, completedTasks } from "./data-kanaban";

/**
 * Kanban-board component
 */
export default {
  components: { Layout, PageHeader, draggable: VueDraggableNext, },
  data() {
    return {
      upcomingTasks: upcomingTasks,
      progressTasks: progressTasks,
      completedTasks: completedTasks,
      title: "Kanban Board",
      items: [
        {
          text: "Tasks",
          href: "/"
        },
        {
          text: "Kanban Board",
          active: true
        }
      ]
    };
  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="drag-container">
      <div class="row drag-list">
        <div class="col-lg-4 drag-column">
          <div class="card">
            <div class="card-body">
              <!-- dropdown -->
              <b-dropdown right variant="white" class="float-end" toggle-class="p-0">
                <template #button-content>
                  <i class="m-0 mdi mdi-dots-vertical text-muted h5"></i>
                </template>
                <b-dropdown-item href="javascript: void(0);">Edit</b-dropdown-item>
                <b-dropdown-item href="javascript: void(0);">Delete</b-dropdown-item>
              </b-dropdown>
              <span class="drag-column-header">
                <h4 class="pb-1 mb-4 card-title">Upcoming</h4>
              </span>
              <draggable  class="list-group" group="tasks" :list="upcomingTasks">
                <div v-for="task in upcomingTasks" :key="task.id" class="card task-box">
                  <div class="card-body">
                    <div class="ml-2 float-end">
                      <span
                        class="badge rounded-pill font-size-12"
                        :class=" {
                            'badge-soft-secondary': `${task.task}` === 'Waiting',
                            'badge-soft-success': `${task.task}` === 'Complete',
                            'badge-soft-primary': `${task.task}` === 'Approved',
                            'badge-soft-warning': `${task.task}` === 'Pending' }"
                      >{{task.task}}</span>
                    </div>
                    <div>
                      <h5 class="font-size-15">
                        <a href="javascript: void(0);" class="text-dark">{{ task.title }}</a>
                      </h5>
                    </div>
                    <p class="mb-4 text-muted">{{ task.date }}</p>
                    <div class="float-left team">
                      <a href="javascript: void(0);" class="team-member d-inline-block">
                        <img :src="`${ task.user[0] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                      <a href="javascript: void(0);" v-if="task.user[1]" class="team-member d-inline-block">
                        <img :src="`${ task.user[1] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                    </div>
                    <div class="text-end">
                      <h5 class="mb-1 font-size-15">$ {{task.budget}}</h5>
                      <p class="mb-0 text-muted">Budget</p>
                    </div>
                  </div>
                </div>
              </draggable >
              <a href="javascript: void(0);" class="mt-3 btn btn-primary w-100">
                <i class="mr-1 mdi mdi-plus"></i> Add New
              </a>
            </div>
          </div>
        </div>
        <!-- end col-->

        <div class="col-lg-4 drag-column">
          <div class="card">
            <div class="card-body">
              <!-- dropdown -->
              <b-dropdown right variant="white" class="float-end" toggle-class="p-0">
                <template #button-content>
                  <i class="m-0 mdi mdi-dots-vertical text-muted h5"></i>
                </template>
                <b-dropdown-item href="javascript: void(0);">Edit</b-dropdown-item>
                <b-dropdown-item href="javascript: void(0);">Delete</b-dropdown-item>
              </b-dropdown>
              <span class="drag-column-header">
                <h4 class="pb-1 mb-4 card-title">In Progress</h4>
              </span>
              <draggable  class="list-group" group="tasks" :list="progressTasks">
                <div v-for="task in progressTasks" :key="task.id" class="card task-box">
                  <div class="card-body">
                    <div class="ml-2 float-end">
                      <span
                        class="badge rounded-pill font-size-12"
                        :class=" {
                            'badge-soft-secondary': `${task.task}` === 'Waiting',
                            'badge-soft-success': `${task.task}` === 'Complete',
                            'badge-soft-primary': `${task.task}` === 'Approved',
                            'badge-soft-warning': `${task.task}` === 'Pending' }"
                      >{{task.task}}</span>
                    </div>
                    <div>
                      <h5 class="font-size-15">
                        <a href="javascript: void(0);" class="text-dark">{{ task.title }}</a>
                      </h5>
                    </div>
                    <p class="mb-4 text-muted">{{ task.date }}</p>
                    <div class="float-left team">
                      <a href="javascript: void(0);" class="team-member d-inline-block">
                        <img :src="`${ task.user[0] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                      <a href="javascript: void(0);" v-if="task.user[1]" class="team-member d-inline-block">
                        <img :src="`${ task.user[1] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                    </div>
                    <div class="text-end">
                      <h5 class="mb-1 font-size-15">$ {{task.budget}}</h5>
                      <p class="mb-0 text-muted">Budget</p>
                    </div>
                  </div>
                </div>
              </draggable >
              <a href="javascript: void(0);" class="mt-3 btn btn-primary w-100">
                <i class="mr-1 mdi mdi-plus"></i> Add New
              </a>
            </div>
          </div>
        </div>
        <!-- end col-->

        <div class="col-lg-4 drag-column">
          <div class="card">
            <div class="card-body">
              <!-- dropdown -->
              <b-dropdown right variant="white" class="float-end" toggle-class="p-0">
                <template #button-content>
                  <i class="m-0 mdi mdi-dots-vertical text-muted h5"></i>
                </template>
                <b-dropdown-item href="javascript: void(0);">Edit</b-dropdown-item>
                <b-dropdown-item href="javascript: void(0);">Delete</b-dropdown-item>
              </b-dropdown>
              <span class="drag-column-header">
                <h4 class="pb-1 mb-4 card-title">Completed</h4>
              </span>
              <draggable  class="list-group" group="tasks" :list="completedTasks">
                <div v-for="task in completedTasks" :key="task.id" class="card task-box">
                  <div class="card-body">
                    <div class="ml-2 float-end">
                      <span
                        class="badge rounded-pill font-size-12"
                        :class=" {
                            'badge-soft-secondary': `${task.task}` === 'Waiting',
                            'badge-soft-success': `${task.task}` === 'Complete',
                            'badge-soft-primary': `${task.task}` === 'Approved',
                            'badge-soft-warning': `${task.task}` === 'Pending' }"
                      >{{task.task}}</span>
                    </div>
                    <div>
                      <h5 class="font-size-15">
                        <a href="javascript: void(0);" class="text-dark">{{ task.title }}</a>
                      </h5>
                    </div>
                    <p class="mb-4 text-muted">{{ task.date }}</p>
                    <div class="float-left team">
                      <a href="javascript: void(0);" class="team-member d-inline-block">
                        <img :src="`${ task.user[0] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                      <a href="javascript: void(0);" v-if="task.user[1]" class="team-member d-inline-block">
                        <img :src="`${ task.user[1] }`" class="m-1 rounded-circle avatar-xs" alt />
                      </a>
                    </div>
                    <div class="text-end">
                      <h5 class="mb-1 font-size-15">$ {{task.budget}}</h5>
                      <p class="mb-0 text-muted">Budget</p>
                    </div>
                  </div>
                </div>
              </draggable >
              <a href="javascript: void(0);" class="mt-3 btn btn-primary w-100">
                <i class="mr-1 mdi mdi-plus"></i> Add New
              </a>
            </div>
          </div>
        </div>
        <!-- end col-->
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
