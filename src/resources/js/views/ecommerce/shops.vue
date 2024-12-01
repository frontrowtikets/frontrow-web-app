<script>
import Layout from '../../Layouts/main.vue'

import { shopsData } from './data-shops'

/**
 * Shops component
 */
export default {
  components: { Layout,  },
  data() {
    return {
      shopsData: shopsData,
      title: 'Shops',
      items: [
        {
          text: 'Ecommerce',
          href: '/',
        },
        {
          text: 'Shops',
          active: true,
        },
      ],
    }
  },
}
</script>

<template>
  <Layout>
    <div class="row">
      <div v-for="shops in shopsData" :key="shops.id" class="col-xl-4 col-sm-6">
        <div class="card">
          <div class="row">
            <div class="col-xl-5">
              <div class="p-4 text-center border-end">
                <div class="mx-auto mt-1 mb-3 avatar-sm">
                  <span
                    :class="`avatar-title rounded-circle bg-soft bg-${shops.color} text-${shops.color} font-size-16`"
                  >{{shops.avatar}}</span>
                </div>
                <h5 class="pb-1 text-truncate">{{shops.name}}</h5>
              </div>
            </div>

            <div class="col-xl-7">
              <div class="p-4 text-center text-xl-start">
                <div class="row">
                  <div class="col-sm-6">
                    <div>
                      <p class="mb-2 text-muted text-truncate">Products</p>
                      <h5>{{shops.products}}</h5>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div>
                      <p class="mb-2 text-muted text-truncate">Wallet Balance</p>
                      <h5>{{shops.balance}}</h5>
                    </div>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="#" class="text-decoration-underline text-reset">See Profile
                    <i class="mdi mdi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  end row -->

    <div class="row">
      <div class="col-12">
        <div class="my-3 text-center">
          <a href="javascript:void(0);" class="text-success">
            <i class="align-middle bx bx-loader bx-spin font-size-18 me-2"></i> Load more
          </a>
        </div>
      </div>
      <!-- end col-->
    </div>
    <!-- end row -->
  </Layout>
</template>
