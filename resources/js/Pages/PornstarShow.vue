<template>
    <div class="container mx-auto">
        <button @click="goToSearch" class="text-lg font-bold text-blue-500 hover:underline mt-5 mb-1 mx-auto block">&lt; Back to Search</button>
        <div class="flex justify-center">
            <div class="w-full md:w-3/4 lg:w-1/2 xl:w-1/3 bg-white p-8 rounded-lg shadow-lg">
                <img :src="imageUrl" alt="Pornstar Image" class="w-full h-auto rounded-lg mb-4" v-if="imageUrl" />
                <div v-else class="w-full h-64 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                    <p>Loading...</p>
                </div>
                <h1 class="text-3xl font-bold mb-2">{{ pornstar.name }}</h1>
                <p class="text-lg text-gray-700 mb-4">Aliases: {{ aliasNames }}</p>
                <div class="flex flex-wrap mb-4">
                    <div class="w-full lg:w-1/2 p-2">
                        <p class="text-lg font-bold">Attributes</p>
                        <ul>
                            <li>Hair Color: {{ pornstar.hairColor }}</li>
                            <li>Ethnicity: {{ pornstar.ethnicity }}</li>
                            <li>Tattoos: {{ pornstar.tattoos ? 'Yes' : 'No' }}</li>
                            <li>Piercings: {{ pornstar.piercings ? 'Yes' : 'No' }}</li>
                            <li>Breast Size: {{ pornstar.breastSize }}</li>
                            <li>Breast Type: {{ pornstar.breastType }}</li>
                            <li>Gender: {{ pornstar.gender }}</li>
                            <li>Orientation: {{ pornstar.orientation }}</li>
                            <li>Age: {{ pornstar.age }}</li>
                        </ul>
                    </div>
                    <div class="w-full lg:w-1/2 p-2">
                        <p class="text-lg font-bold">Stats</p>
                        <ul>
                            <li>Subscriptions: {{ pornstar.stats.subscriptions }}</li>
                            <li>Monthly Searches: {{ pornstar.stats.monthlySearches }}</li>
                            <li>Views: {{ pornstar.stats.views }}</li>
                            <li>Videos Count: {{ pornstar.stats.videosCount }}</li>
                            <li>Premium Videos Count: {{ pornstar.stats.premiumVideosCount }}</li>
                            <li>White Label Video Count: {{ pornstar.stats.whiteLabelVideoCount }}</li>
                            <li>Rank: {{ pornstar.stats.rank }}</li>
                            <li>Rank Premium: {{ pornstar.stats.rankPremium }}</li>
                            <li>Rank WL: {{ pornstar.stats.rankWl }}</li>
                        </ul>
                    </div>
                </div>
                <p class="text-lg font-bold">License: {{ pornstar.license }}</p>
                <p class="text-lg font-bold">White Label Status: {{ pornstar.wlStatus === '1' ? 'Yes' : 'No' }}</p>
                <a :href="pornstar.link" class="text-lg font-bold text-blue-500 hover:underline">View Profile</a>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { visit } from '@inertiajs/inertia';

export default {
    props: {
        pornstar: Object, // Pass the pornstar object as a prop
        image: String,    // Pass the image URL as a prop
    },
    setup(props) {
        const imageUrl = ref('');

        // Update the image URL if provided
        if (props.image) {
            imageUrl.value = `data:image/jpeg;base64,${props.image}`;
        }

        const aliasNames = props.pornstar.aliases.map(alias => alias.alias).join(', ');

        const goToSearch = () => {
            window.location.href = '/';
        };

        return { imageUrl, aliasNames, goToSearch };
    }
};
</script>

<style scoped>
</style>
