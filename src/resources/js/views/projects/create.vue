<script>
import DatePicker from "vue3-datepicker";

import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * Projects-create component
 */
export default {
  components: { DatePicker, Layout, PageHeader },
  data() {
    return {
      title: "Create New",
      items: [
        {
          text: "Projects",
          href: "/"
        },
        {
          text: "Create New",
          active: true
        }
      ],
      daterange: ""
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
          <div class="card-body">
            <h4 class="card-title mb-4">Create New Project</h4>
            <form>
              <div class="form-group row mb-4">
                <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                <div class="col-lg-10">
                  <input
                    id="projectname"
                    name="projectname"
                    type="text"
                    class="form-control"
                    placeholder="Enter Project Name..."
                  />
                </div>
              </div>
              <div class="form-group row mb-4">
                <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
                <div class="col-lg-10">
                  <textarea
                    id="projectdesc"
                    class="form-control"
                    rows="3"
                    placeholder="Enter Project Description..."
                  ></textarea>
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label col-lg-2">Project Date</label>
                <div class="col-lg-10">
                  <date-picker v-model="daterange" class="form-control" range append-to-body lang="en" confirm placeholder="Select date"></date-picker>
                </div>
              </div>

              <div class="form-group row mb-4">
                <label for="projectbudget" class="col-form-label col-lg-2">Budget</label>
                <div class="col-lg-10">
                  <input
                    id="projectbudget"
                    name="projectbudget"
                    type="text"
                    placeholder="Enter Project Budget..."
                    class="form-control"
                  />
                </div>
              </div>
            </form>
            <div class="row justify-content-end">
              <div class="col-lg-10">
                <button type="submit" class="btn btn-primary">Create Project</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>