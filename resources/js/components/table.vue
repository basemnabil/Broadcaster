<template>
    <b-button variant="link" @click="details_click()" v-b-toggle="'table-'+record_id" :id="'btn-details-' + record_id">
        {{ btnText }}
    </b-button>
    <span :id="'no-content-' + record_id"></span>
    <b-collapse :id="'table-' + record_id" accordion="my-accordion" role="tabpanel">
        <b-table id="details-table" :items="this.log_details" :per-page="perPage" :current-page="currentPage" v-slot:cell(status)="row">
            <!-- :per-page and :current-page not yet implemented, pagination currently doesn't work. It should work with stable BootstrapVue release -->
            <b-badge v-if="row.item.status" variant="success">
                Success
            </b-badge>
            <b-badge v-else variant="danger">
                Fail
            </b-badge>
        </b-table>
        <b-pagination :id="'paginate-' + record_id" pills size="sm" v-model="currentPage" :total-rows="rows" :per-page="perPage"
                      aria-controls="details-table"></b-pagination>
    </b-collapse>
</template>

<script>
import axios from "axios";

export default {
    name: "v-table",
    props: [
        'record_id',
    ],
    data: () => ({
        log_details: [],
        btnText: 'Details',
        currentPage: 1,
        perPage: 5,
    }),
    computed: {
        rows() {
            return this.log_details.length;
        }
    },
    methods:
        {
            details_click: async function () {
                if (this.log_details.length === 0) {
                    await axios.get("/broadcast/log/" + this.record_id).then(response => this.log_details = response['data']);
                    if (this.log_details.length === 0)
                    {
                        document.getElementById('no-content-' + this.record_id).hidden = false;
                        document.getElementById('no-content-' + this.record_id).innerHTML= 'No Recipients';
                        document.getElementById('btn-details-' + this.record_id).hidden = true;
                    }
                    else
                    this.btnText = 'Hide details';
                } else {
                    if (this.btnText === 'Show details')
                        this.btnText = 'Hide details';
                    else
                        this.btnText = 'Show details';
                }
                document.getElementById('paginate-' + this.record_id).hidden = this.rows <= this.perPage;
            }

        }
}
</script>

<style scoped>

</style>
