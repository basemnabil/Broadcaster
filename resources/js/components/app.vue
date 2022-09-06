<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0"><h4><strong>Broadcast</strong></h4></div>
                    <form method="post" action="/broadcast">
                        <slot></slot>
                    <div class="card-body">
                        <div>
                            <Alert :status="this.status" id="alert"></Alert>
                        </div>
                        <radioButton v-model="fields.decision" :texts="options" id="radioButton" name="radioButton"></radioButton>

                        <div class="col-10 pt-3">
                            <v-input v-model:data="fields.subject" text="Subject" name="subject" id="subject"></v-input>
                        </div>
                        <div class="col-10 pt-3">
                            <v-textarea v-model:data="fields.body" text="Content" name="content" id="content"></v-textarea>
                        </div>
                    </div>
                        <div class="p-3 pt-0 float-end">
                            <input type="submit" class="btn btn-success" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import radioButton from "./radioButton.vue";
import VInput from "./input.vue";
import VTextarea from "./textarea.vue";
import Alert from "./alert.vue";


    export default {
        name: 'app',
        components: {Alert, VTextarea, VInput, radioButton},
        props:{
            'status': String,
        },
        data: () => ({
            options: ['Expired Projects', 'In Progress Projects', 'All'],
            fields: {
                decision: '',
                subject: '',
                body: '',
            },
            //csrf: document.querySelector('meta[name="csrf_token"]').getAttribute('content'),
        }),
        mounted() {
            console.log('Component mounted.')
            if (this.status !== '')
                document.getElementById('alert').style.display='block';
            else
                document.getElementById('alert').style.display='none';

        },
    }
</script>
n
