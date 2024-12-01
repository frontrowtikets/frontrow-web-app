<script>
/**
 * Application Recevied Time
 */
export default {
  components: {
  },
  data() {
    return {
      series: [{
            name: 'Received Application',
            data: [34, 44, 54, 21, 12, 43, 33, 80, 66]
        }],
      chartOptions: {
        chart: {
            type: 'line',
            height: 378,
            toolbar: {
                show: false,
            },
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        labels: ['8 PM', '9 PM', '10 PM', '11 PM', '12 PM', '1 AM', '2 AM',
            '3 AM', '4 AM'
        ],
        dataLabels: {
            enabled: false
        },
        colors: ["#556ee6", "#34c38f", "#f1b44c", "#50a5f1"],
        markers: {
            hover: {
                sizeOffset: 4
            }
        }
      },
    };
  },
};
</script>
<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4 class="card-title">Applications Received Time</h4>
                <div class="dropdown ms-auto">
                    <a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>

            <apexchart class="apex-charts" type="line" dir="ltr" height="378" :series="series" :options="chartOptions">
            </apexchart>
        </div>
    </div>
</template>
