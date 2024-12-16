<script>
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";

export default {
  components: { Layout, PageHeader },
  data() {
    return {
      title: "File Manager",
      items: [
        {
          text: "Apps",
          href: "/",
        },
        {
          text: "File Manager",
          active: true,
        },
      ],
      series: [76],
      chartOptions: {
        chart: {
          height: 150,
          type: "radialBar",
          sparkline: {
            enabled: true,
          },
        },
        colors: ["#556ee6"],
        plotOptions: {
          radialBar: {
            startAngle: -90,
            endAngle: 90,
            track: {
              background: "#e7e7e7",
              strokeWidth: "97%",
              margin: 5, // margin is in pixels
            },
            hollow: {
              size: "60%",
            },

            dataLabels: {
              name: {
                show: false,
              },
              value: {
                offsetY: -2,
                fontSize: "16px",
              },
            },
          },
        },
        grid: {
          padding: {
            top: -10,
          },
        },
        stroke: {
          dashArray: 3,
        },
        labels: ["Storage"],
      },
    };
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="d-xl-flex">
      <div class="w-100">
        <div class="d-md-flex">
          <div class="card filemanager-sidebar me-md-2">
            <div class="card-body">
              <div class="d-flex flex-column h-100">
                <div class="mb-4">
                  <div class="mb-3 d-grid">
                    <b-dropdown toggle-class="w-100 btn-block" variant="light">
                      <template #button-content>
                        <i class="mdi mdi-plus me-1"></i> Create New
                      </template>

                      <b-dropdown-item href="#"><i class="bx bx-folder me-1"></i>
                        Folder</b-dropdown-item>
                      <b-dropdown-item href="#"><i class="bx bx-file me-1"></i> File</b-dropdown-item>
                    </b-dropdown>
                  </div>
                  <ul class="list-unstyled categories-list">
                    <li>
                      <div class="custom-accordion">
                        <a class="py-1 text-body fw-medium d-flex align-items-center" data-toggle="collapse"
                          v-b-toggle.categories-collapse role="button" aria-expanded="false"
                          aria-controls="categories-collapse">
                          <i class="mdi mdi-folder font-size-16 text-warning me-2"></i>
                          Files
                          <i class="mdi mdi-chevron-up accor-down-icon ms-auto"></i>
                        </a>
                        <b-collapse visible class="collapse show" id="categories-collapse">
                          <div class="mb-0 border-0 shadow-none card ps-2">
                            <ul class="mb-0 list-unstyled">
                              <li>
                                <a href="#" class="d-flex align-items-center"><span class="me-auto">Design</span></a>
                              </li>
                              <li>
                                <a href="#" class="d-flex align-items-center"><span class="me-auto">Development</span>
                                  <i class="mdi mdi-pin ms-auto"></i></a>
                              </li>
                              <li>
                                <a href="#" class="d-flex align-items-center"><span class="me-auto">Project A</span></a>
                              </li>
                              <li>
                                <a href="#" class="d-flex align-items-center"><span class="me-auto">Admin</span>
                                  <i class="mdi mdi-pin ms-auto"></i></a>
                              </li>
                            </ul>
                          </div>
                        </b-collapse>
                      </div>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-google-drive font-size-16 text-muted me-2"></i>
                        <span class="me-auto">Google Drive</span>
                      </a>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-dropbox font-size-16 me-2 text-primary"></i>
                        <span class="me-auto">Dropbox</span>
                      </a>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-share-variant font-size-16 me-2"></i>
                        <span class="me-auto">Shared</span>
                        <i class="mdi mdi-circle-medium text-danger ms-2"></i>
                      </a>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-star-outline text-muted font-size-16 me-2"></i>
                        <span class="me-auto">Starred</span>
                      </a>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-trash-can text-danger font-size-16 me-2"></i>
                        <span class="me-auto">Trash</span>
                      </a>
                    </li>
                    <li>
                      <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                        <i class="mdi mdi-cog text-muted font-size-16 me-2"></i>
                        <span class="me-auto">Setting</span><span class="badge bg-success rounded-pill ms-2">01</span>
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="mt-auto">
                  <div class="px-3 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="mb-3">
                      <i class="bx bxs-folder-open h1 text-success"></i>
                    </div>

                    <div>
                      <h5 class="text-success">Upgrade Features</h5>
                      <p>Cum sociis natoque penatibus et</p>
                      <div class="text-center">
                        <button type="button" class="btn btn-link text-decoration-none text-success">Upgrade <i
                            class="mdi mdi-arrow-right"></i></button>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
          <!-- filemanager-leftsidebar -->

          <div class="w-100">
            <div class="card">
              <div class="card-body">
                <div>
                  <div class="mb-3 row">
                    <div class="col-xl-3 col-sm-6">
                      <div class="mt-2">
                        <h5>My Files</h5>
                      </div>
                    </div>
                    <div class="col-xl-9 col-sm-6">
                      <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                        <div class="mb-2 search-box me-2">
                          <div class="position-relative">
                            <input type="text" class="rounded form-control bg-light border-light"
                              placeholder="Search..." />
                            <i class="bx bx-search-alt search-icon"></i>
                          </div>
                        </div>

                        <b-dropdown class="mb-0" toggle-class="btn btn-link text-muted" menu-class="dropdown-menu-end"
                          right variant="white">
                          <template #button-content>
                            <i class="mdi mdi-dots-vertical font-size-20"></i>
                          </template>
                          <b-dropdown-item href="#">Share Files</b-dropdown-item>
                          <b-dropdown-item href="#">Share with me</b-dropdown-item>
                          <b-dropdown-item href="#">Other Actions</b-dropdown-item>
                        </b-dropdown>
                      </form>
                    </div>
                  </div>
                </div>
                <hr class="mb-4" />
                <div>
                  <div class="row">
                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                                menu-class="dropdown-menu-end" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Design</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  12 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">6GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                                menu-class="dropdown-menu-end" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Development</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  20 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">8GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                                menu-class="dropdown-menu-end" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Project A</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  06 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">2GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                                menu-class="dropdown-menu-end" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Admin</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  08 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">4GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2"
                                menu-class="dropdown-menu-end" variant="white" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Sketch Design</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  12 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">6GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-sm-6">
                      <div class="border shadow-none card">
                        <div class="p-3 card-body">
                          <div class="">
                            <div class="float-end ms-2">
                              <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                                menu-class="dropdown-menu-end" right>
                                <template #button-content>
                                  <i class="mdi mdi-dots-horizontal"></i>
                                </template>

                                <b-dropdown-item href="#">Open</b-dropdown-item>
                                <b-dropdown-item href="#">Edit</b-dropdown-item>
                                <b-dropdown-item href="#">Rename</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item href="#">Remove</b-dropdown-item>
                              </b-dropdown>
                            </div>
                            <div class="mb-3 avatar-xs me-3">
                              <div class="bg-transparent rounded avatar-title">
                                <i class="bx bxs-folder font-size-24 text-warning"></i>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="overflow-hidden me-auto">
                                <h5 class="mb-1 font-size-14 text-truncate">
                                  <a href="javascript: void(0);" class="text-body">Applications</a>
                                </h5>
                                <p class="mb-0 text-muted text-truncate">
                                  20 Files
                                </p>
                              </div>
                              <div class="align-self-end ms-2">
                                <p class="mb-0 text-muted">8GB</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end col -->
                  </div>
                  <!-- end row -->
                </div>

                <div class="mt-4">
                  <div class="flex-wrap d-flex">
                    <h5 class="font-size-14 me-3">Recent Files</h5>

                    <div class="ms-auto">
                      <a href="javascript: void(0);">View All</a>
                    </div>
                  </div>
                  <hr class="mt-2" />

                  <div class="table-responsive">
                    <table class="table mb-0 table-centered table-nowrap table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">Date modified</th>
                          <th scope="col" colspan="2">Size</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-file-document font-size-16 text-primary me-2"></i>
                              index.html</a>
                          </td>
                          <td>12-10-2020, 09:45</td>
                          <td>09 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white"
                              menu-class="dropdown-menu-end" right>
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-folder-zip font-size-16 text-warning me-2"></i>
                              Project-A.zip</a>
                          </td>
                          <td>11-10-2020, 17:05</td>
                          <td>115 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" menu-class="dropdown-menu-end"
                              variant="white" right>
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-image font-size-16 text-muted me-2"></i>
                              Img-1.jpeg</a>
                          </td>
                          <td>11-10-2020, 13:26</td>
                          <td>86 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-text-box font-size-16 text-muted me-2"></i>
                              update list.txt</a>
                          </td>
                          <td>10-10-2020, 11:32</td>
                          <td>08 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-folder font-size-16 text-warning me-2"></i>
                              Project B</a>
                          </td>
                          <td>10-10-2020, 10:51</td>
                          <td>72 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-text-box font-size-16 text-muted me-2"></i>
                              Changes list.txt</a>
                          </td>
                          <td>09-10-2020, 17:05</td>
                          <td>07 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-image font-size-16 text-success me-2"></i>
                              Img-2.png</a>
                          </td>
                          <td>09-10-2020, 15:12</td>
                          <td>31 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle mdi mdi-folder font-size-16 text-warning me-2"></i>
                              Project C</a>
                          </td>
                          <td>09-10-2020, 10:11</td>
                          <td>20 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="javascript: void(0);" class="text-dark fw-medium"><i
                                class="align-middle bx bxs-file font-size-16 text-primary me-2"></i>
                              starter-page.html</a>
                          </td>
                          <td>08-10-2020, 03:22</td>
                          <td>11 KB</td>
                          <td>
                            <b-dropdown toggle-class="p-0 font-size-16 text-muted" variant="white" right
                              menu-class="dropdown-menu-end">
                              <template #button-content>
                                <i class="mdi mdi-dots-horizontal"></i>
                              </template>

                              <b-dropdown-item href="#">Open</b-dropdown-item>
                              <b-dropdown-item href="#">Edit</b-dropdown-item>
                              <b-dropdown-item href="#">Rename</b-dropdown-item>
                              <b-dropdown-divider></b-dropdown-divider>
                              <b-dropdown-item href="#">Remove</b-dropdown-item>
                            </b-dropdown>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- end card -->
          </div>
          <!-- end w-100 -->
        </div>
      </div>

      <div class="card filemanager-sidebar ms-lg-2">
        <div class="card-body">
          <div class="text-center">
            <h5 class="mb-4 font-size-15">Storage</h5>
            <apexchart class="apex-charts" type="radialBar" height="150" dir="ltr" :series="series"
              :options="chartOptions"></apexchart>

            <p class="mt-4 text-muted">48.02 GB (76%) of 64 GB used</p>
          </div>

          <div class="mt-4">
            <div class="mb-2 border shadow-none card">
              <a href="javascript: void(0);" class="text-body">
                <div class="p-2">
                  <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                      <div class="bg-transparent rounded avatar-title text-success font-size-20">
                        <i class="mdi mdi-image"></i>
                      </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                      <h5 class="mb-1 font-size-13 text-truncate">Images</h5>
                      <p class="mb-0 text-muted text-truncate">176 Files</p>
                    </div>

                    <div class="ms-2">
                      <p class="text-muted">6 GB</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="mb-2 border shadow-none card">
              <a href="javascript: void(0);" class="text-body">
                <div class="p-2">
                  <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                      <div class="bg-transparent rounded avatar-title text-danger font-size-20">
                        <i class="mdi mdi-play-circle-outline"></i>
                      </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                      <h5 class="mb-1 font-size-13 text-truncate">Video</h5>
                      <p class="mb-0 text-muted text-truncate">45 Files</p>
                    </div>

                    <div class="ms-2">
                      <p class="text-muted">4.1 GB</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="mb-2 border shadow-none card">
              <a href="javascript: void(0);" class="text-body">
                <div class="p-2">
                  <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                      <div class="bg-transparent rounded avatar-title text-info font-size-20">
                        <i class="mdi mdi-music"></i>
                      </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                      <h5 class="mb-1 font-size-13 text-truncate">Music</h5>
                      <p class="mb-0 text-muted text-truncate">21 Files</p>
                    </div>

                    <div class="ms-2">
                      <p class="text-muted">3.2 GB</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="mb-2 border shadow-none card">
              <a href="javascript: void(0);" class="text-body">
                <div class="p-2">
                  <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                      <div class="bg-transparent rounded avatar-title text-primary font-size-20">
                        <i class="mdi mdi-file-document"></i>
                      </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                      <h5 class="mb-1 font-size-13 text-truncate">Document</h5>
                      <p class="mb-0 text-muted text-truncate">21 Files</p>
                    </div>

                    <div class="ms-2">
                      <p class="text-muted">2 GB</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="border shadow-none card">
              <a href="javascript: void(0);" class="text-body">
                <div class="p-2">
                  <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                      <div class="bg-transparent rounded avatar-title text-warning font-size-20">
                        <i class="mdi mdi-folder"></i>
                      </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                      <h5 class="mb-1 font-size-13 text-truncate">Others</h5>
                      <p class="mb-0 text-muted text-truncate">20 Files</p>
                    </div>

                    <div class="ms-2">
                      <p class="text-muted">1.4 GB</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
