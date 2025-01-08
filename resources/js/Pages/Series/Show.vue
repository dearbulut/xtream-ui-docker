<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    series: Object,
});

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString() : '-';
};

const selectedSeason = ref(props.series.seasons?.[0] || null);
</script>

<template>
    <AppLayout>
        <Head :title="`Series - ${series.name}`" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Series Details
                </h2>

                <div class="flex items-center space-x-4">
                    <Button
                        :href="`/series/${series.id}/edit`"
                        size="sm"
                    >
                        Edit Series
                    </Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Series Header -->
                <div class="relative">
                    <div class="w-full h-96 overflow-hidden rounded-lg">
                        <img
                            :src="series.backdrop || '/default-backdrop.jpg'"
                            :alt="series.name"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0 w-48">
                                <img
                                    :src="series.poster || '/default-series.png'"
                                    :alt="series.name"
                                    class="w-full rounded-lg shadow-lg"
                                >
                            </div>
                            <div class="flex-1">
                                <h1 class="text-4xl font-bold">{{ series.name }}</h1>
                                <div class="mt-2 flex items-center space-x-4">
                                    <Badge>{{ series.category?.name || "Uncategorized" }}</Badge>
                                    <Badge variant="info">{{ series.seasons?.length || 0 }} Seasons</Badge>
                                    <Badge variant="success">{{ series.rating }}</Badge>
                                    <Badge :variant="series.is_active ? 'success' : 'danger'">
                                        {{ series.is_active ? "Active" : "Inactive" }}
                                    </Badge>
                                </div>
                                <p class="mt-4 text-lg">{{ series.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Series Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Series Information</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Release Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(series.release_date) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Director</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ series.director }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Cast</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ series.cast }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Genre</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ series.genre }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Media Information</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Logo URL</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ series.logo || '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Trailer URL</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ series.trailer_url || '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seasons & Episodes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Seasons List -->
                            <div class="space-y-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Seasons</h3>
                                <div
                                    v-for="season in series.seasons"
                                    :key="season.id"
                                    class="cursor-pointer"
                                    @click="selectedSeason = season"
                                >
                                    <div
                                        class="p-4 rounded-lg"
                                        :class="{
                                            'bg-primary-50 border-primary-500': selectedSeason?.id === season.id,
                                            'bg-gray-50 hover:bg-gray-100': selectedSeason?.id !== season.id,
                                        }"
                                    >
                                        <h4 class="font-medium">Season {{ season.season_number }}</h4>
                                        <p class="text-sm text-gray-500">{{ season.episodes?.length || 0 }} Episodes</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Episodes List -->
                            <div class="md:col-span-3">
                                <template v-if="selectedSeason">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ selectedSeason.name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ selectedSeason.episodes?.length || 0 }} Episodes
                                        </p>
                                    </div>

                                    <div class="space-y-4">
                                        <div
                                            v-for="episode in selectedSeason.episodes"
                                            :key="episode.id"
                                            class="bg-gray-50 rounded-lg p-4"
                                        >
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="font-medium">Episode {{ episode.episode_number }}: {{ episode.name }}</h4>
                                                    <p class="text-sm text-gray-500 mt-1">{{ episode.description }}</p>
                                                    <div class="mt-2 flex items-center space-x-4">
                                                        <Badge variant="info">{{ episode.duration }}</Badge>
                                                        <Badge>{{ formatDate(episode.air_date) }}</Badge>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <Badge v-if="episode.subtitles?.length">
                                                        {{ episode.subtitles.length }} Subtitles
                                                    </Badge>
                                                    <Badge v-if="episode.audio_tracks?.length" variant="info">
                                                        {{ episode.audio_tracks.length }} Audio Tracks
                                                    </Badge>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div v-else class="text-center text-gray-500">
                                    Select a season to view episodes
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>