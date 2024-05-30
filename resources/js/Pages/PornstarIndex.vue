<template>
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-3/4 lg:w-1/2 xl:w-1/3 p-8">
                <div class="self-center">
                    <SearchBar></SearchBar>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import SearchBar from "@/Components/SearchBar.vue";

export default {
    components: {SearchBar},
};
</script>

<style scoped>
    search-bar {
        margin: auto;
        max-width: 400px;
    }
</style>
