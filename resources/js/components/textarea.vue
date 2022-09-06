<template>
    <h6><strong>{{ text }}</strong></h6>
    <textarea v-model="data" class="form-control w-100" rows="9" :id="id" :name="name" :placeholder="text" required></textarea>
</template>

<script>
export default {
    name: 'vTextarea',
    props: {
        text: String,
        id: String,
        name: String,
        data: String,
    }
}
</script>
