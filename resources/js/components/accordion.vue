<template>
    <div class="accordion" role="tablist" v-for="record in records">
        <b-card class="accordion-item mb-1" no-body>
            <b-card-header header-tag="header" class="p-2" role="tab" v-b-toggle="'accordion-'+record.id"
                           variant="info">
                <span>{{ record['subject'] }}</span>
                <span class="float-end">{{ record['created_at'] }}</span>
            </b-card-header>
            <b-collapse :id="'accordion-' + record.id" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text>{{ record['body'] }}</b-card-text>
                    <v-table :record_id="record['id']"></v-table>
                </b-card-body>
            </b-collapse>
        </b-card>
    </div>
</template>

<script>
import vTable from "./table.vue";

export default {
    name: "accordion",
    components: {vTable },
    props: [
        'records'
    ],
    data: () => ({
        log_details: [],
        currentPage: 1,
    }),
}
</script>

<style scoped>
</style>
