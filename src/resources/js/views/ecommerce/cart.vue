<script>
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";

import img1 from '../../../images/product/img-1.png';
import img2 from '../../../images/product/img-2.png';
import img3 from '../../../images/product/img-3.png';
import img4 from '../../../images/product/img-4.png';
import img5 from '../../../images/product/img-5.png';
import img6 from '../../../images/product/img-6.png';

/**
 * Product-cart component
 */
export default {
  components: {
    Layout,
    PageHeader,
  },
  data() {
    return {
      title: "Cart",
      img1, img2, img3, img4, img5, img6,
      items: [
        {
          text: "Ecommerce",
          href: "/",
        },
        {
          text: "Cart",
          active: true,
        },
      ],
    };
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table
                class="table mb-0 align-middle table-centered table-nowrap"
              >
                <thead class="table-light">
                  <tr>
                    <th>Product</th>
                    <th>Product Desc</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th colspan="2">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <img
                        :src="img1"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Half sleeve T-shirt</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Maroon</span>
                      </p>
                    </td>
                    <td>$ 450</td>
                    <td>
                      <input
                        type="number"
                        value="2"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 900</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img
                        :src="img2"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Light blue T-shirt</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Light blue</span>
                      </p>
                    </td>
                    <td>$ 225</td>
                    <td>
                      <input
                        type="number"
                        value="1"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 225</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img
                        :src="img3"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Black Color T-shirt</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Black</span>
                      </p>
                    </td>
                    <td>$ 152</td>
                    <td>
                      <input
                        type="number"
                        value="2"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 304</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img
                        :src="img4"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Hoodie (Blue)</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Blue</span>
                      </p>
                    </td>
                    <td>$ 145</td>
                    <td>
                      <input
                        type="number"
                        value="2"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 290</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img
                        :src="img5"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Half sleeve T-Shirt</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Light orange</span>
                      </p>
                    </td>
                    <td>$ 138</td>
                    <td>
                      <input
                        type="number"
                        value="1"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 138</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img
                        :src="img6"
                        alt="product-img"
                        title="product-img"
                        class="avatar-md"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-14 text-truncate">
                        <a href="/ecommerce/product-detail" class="text-dark"
                          >Green color T-shirt</a
                        >
                      </h5>
                      <p class="mb-0">
                        Color :
                        <span class="fw-medium">Green</span>
                      </p>
                    </td>
                    <td>$ 152</td>
                    <td>
                      <input
                        type="number"
                        value="2"
                        name="demo_vertical"
                        class="form-control"
                        style="width: 120px"
                      />
                    </td>
                    <td>$ 304</td>
                    <td>
                      <a
                        href="javascript:void(0);"
                        class="action-icon text-danger"
                      >
                        <i class="mdi mdi-trash-can font-size-18"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4 row">
              <div class="col-sm-6">
                <a href="/ecommerce/product-detail" class="btn btn-secondary">
                  <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping
                </a>
              </div>
              <!-- end col -->
              <div class="col-sm-6">
                <div class="mt-2 text-sm-end mt-sm-0">
                  <a href="/ecommerce/checkout" class="btn btn-success">
                    <i class="mdi mdi-cart-arrow-right me-1"></i> Checkout
                  </a>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row-->
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h5 class="mb-4 card-title">Card Details</h5>

            <div class="mb-0 text-white card bg-primary visa-card">
              <div class="card-body">
                <div>
                  <i class="bx bxl-visa visa-pattern"></i>

                  <div class="float-end">
                    <i class="bx bxl-visa visa-logo display-3"></i>
                  </div>

                  <div>
                    <i class="bx bx-chip h1 text-warning"></i>
                  </div>
                </div>

                <div class="mt-5 row">
                  <div class="col-4">
                    <p>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                    </p>
                  </div>
                  <div class="col-4">
                    <p>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                    </p>
                  </div>
                  <div class="col-4">
                    <p>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                      <i class="m-1 fas fa-star-of-life"></i>
                    </p>
                  </div>
                </div>

                <div class="mt-5">
                  <h5 class="mb-0 text-white float-end">12/22</h5>
                  <h5 class="mb-0 text-white">Fredrick Taylor</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h4 class="mb-3 card-title">Order Summary</h4>

            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <td>Grand Total :</td>
                    <td>$ 1,857</td>
                  </tr>
                  <tr>
                    <td>Discount :</td>
                    <td>- $ 157</td>
                  </tr>
                  <tr>
                    <td>Shipping Charge :</td>
                    <td>$ 25</td>
                  </tr>
                  <tr>
                    <td>Estimated Tax :</td>
                    <td>$ 19.22</td>
                  </tr>
                  <tr>
                    <th>Total :</th>
                    <th>$ 1744.22</th>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- end table-responsive -->
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
