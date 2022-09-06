<template>
    <div id="alert" role="alert">
        {{ text }}
    </div>
</template>

<script>
export default {
    name: "alert",
    props:{
        status: String,
    },
    data: () => ({
        text: '',
    }),
    mounted:
      function () {
        if (this.status === "success")
        {
            document.getElementById('alert').setAttribute('class','alert alert-success');
            this.text="Broadcast sent successfully!";
        }
        else if (this.status === "error")
        {
            document.getElementById('alert').setAttribute('class','alert alert-danger');
            this.text="An error has occurred!";
        }
    }
}
</script>

<style scoped>

</style>
