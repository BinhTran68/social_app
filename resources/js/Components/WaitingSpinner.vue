<template>
    <div class="overlay">
        <div class="spinner-container">
            <v-progress-circular
                color="#0068FF"
                indeterminate
            ></v-progress-circular>
        </div>
    </div>
</template>

<style scoped>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.5);
    z-index: 9999;
}

.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
