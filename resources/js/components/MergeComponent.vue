<template>
    <div>
        <AboutComponent />
        <FormTestComponent />
    </div>
</template>

<script>
import AboutComponent from "./AboutComponent";
import FormTestComponent from "./FormTestComponent";

export default {
    name: "MergeComponent.vue",
    components: {
        AboutComponent,
        FormTestComponent,
    }
}
</script>

<style scoped>

</style>
