<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    movie: Object,
});

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString() : '-';
};
</script>

<template>
    <AppLayout>
        <Head :title="`Movie - ${movie.name}`" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Movie Details
                </h2>

                <div class="flex items-center space-x-4">
                    <Button
                        :href="`/movies/${movie.id}/edit`"
                        size="sm"
                    >
                        Edit Movie
                    </Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Movie Header -->
                <div class="relative">
                    <div class="w-full h-96 overflow-hidden rounded-lg">
                        <img
                            :src="movie.backdrop || '/default-backdrop.jpg'"
                            :alt="movie.name"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0 w-48">
                                <img
                                    :src="movie.poster || '/default-movie.png'"
                                    :alt="movie.name"
                                    class="w-full rounded-lg shadow-lg"
                                >
                            </div>
                            <div class="flex-1">
                                <h1 class="text-4xl font-bold">{{ movie.name }}</h1>
                                <div class="mt-2 flex items-center space-x-4">
                                    <Badge>{{ movie.category?.name || "Uncategorized" }}</Badge>
                                    <Badge variant="info">{{ movie.duration }}</Badge>
                                    <Badge variant="success">{{ movie.rating }}</Badge>
                                    <Badge :variant="movie.is_active ? 'success' : 'danger'">
                                        {{ movie.is_active ? "Active" : "Inactive" }}
                                    </Badge>
                                </div>
                                <p class="mt-4 text-lg">{{ movie.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Movie Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Movie Information</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Release Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(movie.release_date) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Director</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ movie.director }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Cast</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ movie.cast }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Genre</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ movie.genre }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Stream Information</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Stream URL</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ movie.stream_url }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Trailer URL</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ movie.trailer_url || '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subtitles & Audio -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Subtitles -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Subtitles</h3>
                                <div class="space-y-2">
                                    <div
                                        v-for="(subtitle, index) in movie.subtitles"
                                        :key="index"
                                        class="flex items-center justify-between p-2 bg-gray-50 rounded"
                                    >
                                        <div>
                                            <span class="font-medium">{{ subtitle.language }}</span>
                                            <span class="text-gray-500 ml-2">{{ subtitle.url }}</span>
                                        </div>
                                    </div>
                                    <div v-if="!movie.subtitles?.length" class="text-sm text-gray-500">
                                        No subtitles available
                                    </div>
                                </div>
                            </div>

                            <!-- Audio Tracks -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Audio Tracks</h3>
                                <div class="space-y-2">
                                    <div
                                        v-for="(track, index) in movie.audio_tracks"
                                        :key="index"
                                        class="flex items-center justify-between p-2 bg-gray-50 rounded"
                                    >
                                        <div>
                                            <span class="font-medium">{{ track.language }}</span>
                                            <span class="text-gray-500 ml-2">{{ track.url }}</span>
                                        </div>
                                    </div>
                                    <div v-if="!movie.audio_tracks?.length" class="text-sm text-gray-500">
                                        No additional audio tracks available
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>