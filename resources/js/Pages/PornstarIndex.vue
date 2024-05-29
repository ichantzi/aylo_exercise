<template>
    <div class="relative">
        <input
            type="text"
            v-model="query"
            @input="search"
            placeholder="Search for a pornstar..."
            class="h-12 mb-4 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
            style="margin-top: 50px;"
        />
        <ul v-if="suggestions.length" class="absolute left-0 z-10 bg-white border border-gray-300 w-full max-h-400px overflow-y-auto">
            <li v-for="suggestion in suggestions" :key="suggestion.id" @click="selectSuggestion(suggestion)" class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                {{ suggestion.name }}
            </li>
        </ul>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

export default {
    setup() {
        const query = ref('');
        const suggestions = ref([]);

        const search = () => {
            if (query.value.length < 3) {
                suggestions.value = [];
                return;
            }

            axios.get('/api/pornstars/search', { params: { query: query.value } })
                .then(response => {
                    suggestions.value = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        };

        const selectSuggestion = (suggestion) => {
            Inertia.get(`/pornstars/${suggestion.id}`);
        };

        return { query, suggestions, search, selectSuggestion };
    }
};
</script>

<style scoped>
.max-h-400px {
    max-height: 400px;
}
</style>
