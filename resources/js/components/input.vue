<template>
    <h6><strong>{{ text }}</strong></h6>
    <input v-model="data" class="form-control" :id="id" :name="name" :placeholder="text" required>
</template>

<script>
export default {
    name: 'vInput',
    props: {
        text: String,
        name: String,
        id: String,
        data: String,
    }
}
</script>
