<template>
    <div class="vstack">
        <label class="form-check-label" :for="texts" v-for="text in texts">
        <input class="form-check-input" type="radio" name="radio-input" :id="text" :value="text" required>
            {{ text }}
        </label>
    </div>
</template>

<script>
export default {
    name: 'radioButton',
    props: {
        texts: Array
    }
}
</script>
