<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import Datepicker from "vue3-datepicker";

/**
 * Starter component
 */
export default {
  page: {
    title: "Jobs List",
  },
  components: { Layout, PageHeader, Datepicker },
  data() {
    return {
      title: "Jobs List",
      listDeleteModal: false,
      items: [
        {
          text: "Jobs",
          href: "/"
        },
        {
          text: "Jobs List",
          active: true
        }
      ],
      datepickervalue: new Date(),
    };
  }
};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
              <h5 class="mb-0 card-title flex-grow-1">Jobs Lists</h5>
              <div class="flex-shrink-0">
                <a href="#!" class="btn btn-primary me-1">Add New Job</a>
                <a href="#!" class="btn btn-light me-1"><i class="mdi mdi-refresh"></i></a>
                <div class="dropdown d-inline-block">

                  <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body border-bottom">
            <div class="row g-3">
              <div class="col-xxl-4 col-lg-6">
                <input type="search" class="form-control" id="searchTableList" placeholder="Search for ...">
              </div>
              <div class="col-xxl-2 col-lg-6">
                <select class="form-select" id="idStatus" aria-label="Default select example">
                  <option value="all">Status</option>
                  <option value="Active">Active</option>
                  <option value="New">New</option>
                  <option value="Close">Close</option>
                </select>
              </div>
              <div class="col-xxl-2 col-lg-4">
                <select class="form-select" id="idType" aria-label="Default select example">
                  <option value="all">Select Type</option>
                  <option value="Full Time">Full Time</option>
                  <option value="Part Time">Part Time</option>
                </select>
              </div>
              <div class="col-xxl-2 col-lg-4">
                <div id="datepicker1">
                  <Datepicker placeholder="Select Date" class="form-control" :first-day-of-week="1" lang="en" confirm>
                  </Datepicker>
                </div>
              </div>
              <div class="col-xxl-2 col-lg-4">
                <button type="button" class="btn btn-secondary w-100"><i class="mdi mdi-filter-outline align-middle"></i>
                  Filter</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Experience</th>
                    <th scope="col">Position</th>
                    <th scope="col">Type</th>
                    <th scope="col">Posted Date</th>
                    <th scope="col">Last Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Magento Developer</td>
                    <td>Themesbrand</td>
                    <td>California</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-success">Full Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Product Designer</td>
                    <td>Web Technology pvt.ltd</td>
                    <td>California</td>
                    <td>1-2 Years</td>
                    <td>3</td>
                    <td><span class="badge badge-soft-danger">Part Time</span></td>
                    <td>15 June 2021</td>
                    <td>28 June 2021</td>
                    <td><span class="badge bg-info">New</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Marketing Director</td>
                    <td>Creative Agency</td>
                    <td>Phoenix</td>
                    <td>-</td>
                    <td>5</td>
                    <td><span class="badge badge-soft-success">Full Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge bg-danger">Close</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>HTML Developer</td>
                    <td>Web Technology pvt.ltd</td>
                    <td>California</td>
                    <td>0-4 Years</td>
                    <td>8</td>
                    <td><span class="badge badge-soft-success">Full Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Product Sales Specialist</td>
                    <td>Skote Technology pvt.Ltd</td>
                    <td>Louisiana</td>
                    <td>5+ Years</td>
                    <td>1</td>
                    <td><span class="badge badge-soft-danger">Part Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge bg-info">New</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">6</th>
                    <td>Magento Developer</td>
                    <td>New Technology pvt.ltd</td>
                    <td>Oakridge Lane Richardson</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-info">Freelance</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge text-bg-info">New</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">7</th>
                    <td>Business Associate</td>
                    <td>Web Technology pvt.ltd</td>
                    <td>California</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-success">Full Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">8</th>
                    <td>Magento Developer</td>
                    <td>Adobe Agency</td>
                    <td>California</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-success">Full Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge text-bg-danger">Close</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                        <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">9</th>
                    <td>HTML Developer</td>
                    <td>Web Technology pvt.ltd</td>
                    <td>California</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-danger">Part Time</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge text-bg-info">New</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                          <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">10</th>
                    <td>Marketing Director</td>
                    <td>Web Technology pvt.ltd</td>
                    <td>California</td>
                    <td>0-2 Years</td>
                    <td>2</td>
                    <td><span class="badge badge-soft-warning">Internship</span></td>
                    <td>02 June 2021</td>
                    <td>25 June 2021</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>
                      <ul class="list-unstyled hstack gap-1 mb-0">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                          <router-link to="/jobs/details" class="btn btn-sm btn-soft-primary"><i
                              class="mdi mdi-eye-outline"></i></router-link>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                          <a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
                          <b-button variant="soft-danger" class="btn-sm" @click="listDeleteModal = !listDeleteModal"><i
                              class="mdi mdi-delete-outline"></i></b-button>
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- end table -->
            </div>
            <div class="row justify-content-between align-items-center">
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
              </div>
              <!--end col-->
            </div>
            <!-- end table responsive -->
          </div>
          <!-- end card body -->
        </div><!--end card-->
      </div><!--end col-->
    </div>

    <!-- The modal -->
    <b-modal v-model="listDeleteModal" hide-footer title="Delete" class="v-modal-custom">
      <p class="text-muted font-size-16 mb-4">are you sure want to delete?</p>
      <div class="modal-footer v-modal-footer">
        <b-button type="button" variant="light" @click="listDeleteModal = false">Close
        </b-button>
        <b-button type="button" variant="success">Save Changes</b-button>
      </div>
    </b-modal>
  </Layout>
</template>