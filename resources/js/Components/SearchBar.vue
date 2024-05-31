<template>
    <div class="relative">
        <input
            type="text"
            v-model="query"
            @input="search"
            @keydown.down.prevent="navigateSuggestions('down')"
            @keydown.up.prevent="navigateSuggestions('up')"
            @keydown.enter.prevent="selectHighlightedSuggestion"
            placeholder="Search for a pornstar..."
            class="h-12 mb-4 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
            style="width: 100%"
        />
        <ul v-if="suggestions.length" class="absolute left-0 z-10 bg-white border border-gray-300 w-full max-h-250px overflow-y-auto">
            <li v-for="(suggestion, index) in suggestions"
                :key="suggestion.id"
                @click="selectSuggestion(suggestion)"
                :class="{'bg-gray-100': index === selectedIndex}"
                class="px-4 py-2 cursor-pointer hover:bg-gray-100">
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
        const selectedIndex = ref(-1);

        const search = () => {
            if (query.value.length < 3) {
                suggestions.value = [];
                selectedIndex.value = -1;
                return;
            }

            axios.get('/api/pornstars/search', { params: { query: query.value } })
                .then(response => {
                    suggestions.value = response.data;
                    selectedIndex.value = -1; // Reset selection when new suggestions are loaded
                })
                .catch(error => {
                    console.error(error);
                });
        };

        const selectSuggestion = (suggestion) => {
            Inertia.get(`/pornstars/${suggestion.id}`);
        };

        const navigateSuggestions = (direction) => {
            if (direction === 'down') {
                if (selectedIndex.value < suggestions.value.length - 1) {
                    selectedIndex.value += 1;
                }
            } else if (direction === 'up') {
                if (selectedIndex.value > 0) {
                    selectedIndex.value -= 1;
                }
            }
        };

        const selectHighlightedSuggestion = () => {
            if (selectedIndex.value !== -1) {
                selectSuggestion(suggestions.value[selectedIndex.value]);
            }
        };

        return { query, suggestions, search, selectSuggestion, navigateSuggestions, selectedIndex, selectHighlightedSuggestion };
    }
};
</script>

<style scoped>
.max-h-250px {
    max-height: 250px;
}
.bg-gray-100 {
    background-color: #f7fafc; /* Tailwind's gray-100 color */
}
</style>
