<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import Basic from "./basic.vue";
import Boundary from "./boundary.vue";
import Icons from "./icons.vue";
import Geometry from "./geometry.vue";
import Markers from "./markers.vue";

/**
 * Leaflet-map component
 */
export default {
  components: {
    Layout,
    PageHeader,
    Boundary,
    Icons,
    Basic,
    Geometry,
    Markers
  },
  data() {
    return {
      title: "Leaflet map",
      items: [
        {
          text: "Maps",
          href: "/"
        },
        {
          text: "Leaflet map",
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
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Example</h4>

            <Basic />

          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Fixed Bounds</h4>
            <Boundary />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Custom Icon Example</h4>
            <Icons />
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Geometry Example</h4>
            <Geometry />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Draggable marker</h4>
            <Markers />
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
