<script>
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";

import { clothsData } from "./data-products";

import avatar2 from '../../../images/users/avatar-2.jpg';
import avatar4 from '../../../images/users/avatar-4.jpg';
import avatar5 from '../../../images/users/avatar-5.jpg';
import img4 from '../../../images/product/img-4.png';
import img6 from '../../../images/product/img-6.png';
import img7 from '../../../images/product/img-7.png';

/**
 * Product detail component
 */
export default {
  components: { Layout, PageHeader },
  props: {
    id: {
      type: String,
      required: false,
    }
  },
  data() {
    return {
      avatar2, avatar4, avatar5, img4, img6, img7,
      productDetail: null,
      clothsData: clothsData,
      title: "Product Detail",
      items: [
        {
          text: "Ecommerce",
          href: "/",
        },
        {
          text: "Product Detail",
          active: true,
        },
      ],
    };
  },
  created() {
    this.productDetail = clothsData.filter((product) => {
      return product.id === parseInt(this.id || "1");
    });
  },
  methods: {
    /**
     * Selected image shows
     */
    imageShow(event) {
      const image = event.target.src;
      const expandImg = document.getElementById("expandedImg");
      expandImg.src = image;
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xl-6">
                <div class="product-detai-imgs">
                  <b-tabs pills vertical nav-wrapper-class="col-md-2 col-sm-3 col-4">
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[0]"
                          alt
                          class="mx-auto rounded img-fluid d-block tab-img"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[0]"
                          alt
                          class="mx-auto img-fluid d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[1]"
                          alt
                          class="mx-auto rounded img-fluid d-block tab-img"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[1]"
                          alt
                          class="mx-auto img-fluid d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[2]"
                          alt
                          class="mx-auto rounded img-fluid d-block tab-img"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[2]"
                          alt
                          class="mx-auto img-fluid d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[3]"
                          alt
                          class="mx-auto rounded img-fluid d-block tab-img"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[3]"
                          alt
                          class="mx-auto img-fluid d-block"
                        />
                      </div>
                    </b-tab>
                  </b-tabs>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="mt-3">
                  <h4 class="mt-1 mb-3">{{productDetail[0].name}}</h4>

                  <p class="float-left text-muted me-3">
                    <span class="bx bx-star text-warning"></span>
                    <span class="ml-1 bx bx-star text-warning"></span>
                    <span class="ml-1 bx bx-star text-warning"></span>
                    <span class="ml-1 bx bx-star text-warning"></span>
                    <span class="ml-1 bx bx-star"></span>
                  </p>
                  <p class="mb-4 text-muted">( 152 Customers Review )</p>

                  <h6 class="text-success text-uppercase">{{productDetail[0].discount}} Off</h6>
                  <h5 class="mb-4">
                    Price :
                    <span class="text-muted me-2">
                      <del>${{productDetail[0].oldprice}} USD</del>
                    </span>
                    <b>${{productDetail[0].newprice}} USD</b>
                  </h5>
                  <p
                    class="mb-4 text-muted"
                  >To achieve this, it would be necessary to have uniform grammar pronunciation and more common words If several languages coalesce</p>
                  <div class="mb-3 row">
                    <div class="col-md-6">
                      <div v-for="(item, index) in productDetail[0].feature" :key="index">
                        <p class="text-muted">
                          <i class="align-middle bx bx-unlink font-size-16 text-primary me-1"></i>
                          {{item}}
                        </p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div>
                        <p class="text-muted">
                          <i class="align-middle bx bx-user-voice font-size-16 text-primary me-1"></i> Bass
                        </p>
                        <p class="text-muted">
                          <i class="align-middle bx bx-cog font-size-16 text-primary me-1"></i> Warranty : 1 Year
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="product-color">
                    <h5 class="font-size-15">Color :</h5>
                    <a
                      href="javascript: void(0);"
                      class="active"
                      v-for="(item, index) in productDetail[0].colorVariant"
                      :key="index"
                    >
                      <div class="border rounded product-color-item">
                        <img :src="item.value" alt class="avatar-md" />
                      </div>
                      <p>{{item.key}}</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->

            <div class="mt-5">
              <h5 class="mb-3">Specifications :</h5>

              <div class="table-responsive">
                <table class="table mb-0 table-bordered">
                  <tbody>
                    <tr v-for="(i, index) in productDetail[0].specification" :key="index">
                      <th scope="row" style="width: 400px;">{{i.key}}</th>
                      <td>{{i.value}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end Specifications -->

            <div class="mt-5">
              <h5 class="mb-4">Reviews :</h5>

              <div class="py-3 d-flex border-bottom">
                <img
                  :src="avatar2"
                  class="avatar-xs me-3 rounded-circle"
                  alt="img"
                />
                <div class="flex-grow-1">
                  <h5 class="mt-0 font-size-15">Brian</h5>
                  <p
                    class="text-muted"
                  >If several languages coalesce, the grammar of the resulting language.</p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 5 hrs ago
                  </div>
                </div>
              </div>
              <div class="py-3 d-flex border-bottom">
                <img
                  :src="avatar4"
                  class="avatar-xs me-3 rounded-circle"
                  alt="img"
                />
                <div class="flex-grow-1">
                  <h5 class="mt-0 font-size-15">Denver</h5>
                  <p
                    class="text-muted"
                  >To an English person, it will seem like simplified English, as a skeptical Cambridge</p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 07 Oct, 2019
                  </div>
                  <div class="mt-4 d-flex">
                    <img
                      :src="avatar5"
                      class="avatar-xs me-3 rounded-circle"
                      alt="img"
                    />
                    <div class="flex-grow-1">
                      <h5 class="mt-0 font-size-15">Henry</h5>
                      <p
                        class="text-muted"
                      >Their separate existence is a myth. For science, music, sport, etc.</p>
                      <ul class="list-inline float-sm-end">
                        <li class="list-inline-item">
                          <a href="javascript: void(0);">
                            <i class="far fa-thumbs-up me-1"></i> Like
                          </a>
                        </li>
                        <li class="list-inline-item">
                          <a href="javascript: void(0);">
                            <i class="far fa-comment-dots me-1"></i> Comment
                          </a>
                        </li>
                      </ul>
                      <div class="text-muted">
                        <i class="far fa-calendar-alt text-primary me-1"></i> 08 Oct, 2019
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-3 d-flex border-bottom">
                <div class="avatar-xs me-3">
                  <span
                    class="avatar-title bg-soft bg-primary text-primary rounded-circle font-size-16"
                  >N</span>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mt-0 font-size-15">Neal</h5>
                  <p
                    class="text-muted"
                  >Everyone realizes why a new common language would be desirable.</p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 05 Oct, 2019
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <!-- end row -->

    <div class="mt-3 row">
      <div class="col-lg-12">
        <div>
          <h5 class="mb-3">Recent product :</h5>

          <div class="row">
            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        :src="img7"
                        alt
                        class="mx-auto img-fluid d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark">Wireless Headphone</a>
                        </h5>
                        <p class="text-muted">
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star"></i>
                        </p>
                        <h5 class="my-0">
                          <span class="text-muted me-2">
                            <del>$240</del>
                          </span>
                          <b>$225</b>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        :src="img4"
                        alt
                        class="mx-auto img-fluid d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark">Phone patterned cases</a>
                        </h5>
                        <p class="text-muted">
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star"></i>
                        </p>
                        <h5 class="my-0">
                          <span class="text-muted me-2">
                            <del>$150</del>
                          </span>
                          <b>$145</b>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        :src="img6"
                        alt
                        class="mx-auto img-fluid d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a
                            href="javascript: void(0);"
                            class="text-dark"
                          >Phone Dark Patterned cases</a>
                        </h5>
                        <p class="text-muted">
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star text-warning"></i>
                          <i class="bx bx-star"></i>
                        </p>
                        <h5 class="my-0">
                          <span class="text-muted me-2">
                            <del>$138</del>
                          </span>
                          <b>$135</b>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
