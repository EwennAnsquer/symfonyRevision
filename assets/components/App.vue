<template>
    <div>
        <h2>Welcome Home</h2>
        <button @click="counter++">Click Me {{ counter }}</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: 0
        };
    }
};
</script>

<style scoped>
</style>