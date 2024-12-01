<script>
import DatePicker from 'vue3-datepicker'
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import Layout from '../../Layouts/main.vue'
import PageHeader from '../../Components/page-header.vue'

/**
 * Task-create component
 */
export default {
  components: { DatePicker, ckeditor: CKEditor.component, Layout, PageHeader },
  data() {
    return {
      title: 'Create Task',
      items: [
        {
          text: 'Tasks',
          href: '/',
        },
        {
          text: 'Create Task',
          active: true,
        },
      ],
      daterange: '',
      editor: ClassicEditor,
      teamMember: [{ id: 1 }],
    }
  },
  methods: {
    addMember() {
      this.teamMember.push({ name: '' })
    },
    deleteMember(index) {
      this.teamMember.splice(index, 1)
    },
  },
}
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-4 card-title">Create New Task</h4>
            <form class="outer-repeater">
              <div data-repeater-list="outer-group" class="outer">
                <div data-repeater-item class="outer">
                  <div class="mb-4 form-group row">
                    <label for="taskname" class="col-form-label col-lg-2">Task Name</label>
                    <div class="col-lg-10">
                      <input
                        id="taskname"
                        name="taskname"
                        type="text"
                        class="form-control"
                        placeholder="Enter Task Name..."
                      />
                    </div>
                  </div>
                  <div class="mb-4 form-group row">
                    <label class="col-form-label col-lg-2">Task Description</label>
                    <div class="col-lg-10">
                      <ckeditor :editor="editor"></ckeditor>
                    </div>
                  </div>

                  <div class="mb-4 form-group row">
                    <label class="col-form-label col-lg-2">Task Date</label>
                    <div class="col-lg-10">
                      <date-picker v-model="daterange" class="form-control" placeholder="Select date" range append-to-body lang="en" confirm></date-picker>
                    </div>
                  </div>

                  <div class="mb-4 inner-repeater">
                    <div class="mb-0 inner form-group row">
                      <label class="col-form-label col-lg-2">Add Team Member</label>
                      <div

                        class="inner col-lg-10 ml-md-auto"
                      >
                        <div class="mb-3 row align-items-center"   v-for="( member, index) in teamMember"
                        :key="member.id">
                          <div class="col-md-6">
                            <input
                              v-model="member.name"
                              type="text"
                              class="inner form-control"
                              placeholder="Enter Name..."
                            />
                          </div>
                          <div class="col-md-4">
                            <div class="mt-4 mt-md-0">
                              <input type="file" class="form-control" />
                            </div>
                          </div>
                          <div class="col-md-2">
                             <div class="mt-2 mt-md-0 d-grid">
                            <input
                              type="button"
                              class="btn btn-primary btn-block inner"
                              value="Delete"
                              @click="deleteMember(index)"
                            />
                             </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-end">
                      <div class="col-lg-10">
                        <input
                          type="button"
                          class="btn btn-success inner"
                          value="Add Member"
                          @click="addMember"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="mb-4 form-group row">
                    <label for="taskbudget" class="col-form-label col-lg-2">Budget</label>
                    <div class="col-lg-10">
                      <input
                        id="taskbudget"
                        name="taskbudget"
                        type="text"
                        placeholder="Enter Task Budget..."
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="row justify-content-end">
              <div class="col-lg-10">
                <button type="submit" class="btn btn-primary">Create Task</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
