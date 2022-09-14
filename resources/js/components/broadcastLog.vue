<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0"><h4><strong>Broadcast Log</strong></h4></div>

                    <div class="card-body">
                        <accordion :records="this.log"></accordion>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import accordion from "./accordion.vue";

export default {
    name: "broadcastLog",
    components: {accordion},
    props: [
        'log'
    ],
    onMounted() {
        this.log = JSON.parse(this.log);
    }

}
</script>
