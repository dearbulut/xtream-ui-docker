<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    playlist: Object,
});

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString() : 'Never';
};
</script>

<template>
    <AppLayout>
        <Head :title="`Playlist - ${playlist.name}`" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Playlist Details
                </h2>

                <div class="flex items-center space-x-4">
                    <Button
                        :href="`/playlists/${playlist.id}/export`"
                        variant="secondary"
                        size="sm"
                    >
                        Export M3U
                    </Button>

                    <Button
                        :href="`/playlists/${playlist.id}/edit`"
                        size="sm"
                    >
                        Edit Playlist
                    </Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ playlist.name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ playlist.description || 'No description' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">
                                            <Badge :variant="playlist.is_active ? 'success' : 'danger'">
                                                {{ playlist.is_active ? 'Active' : 'Inactive' }}
                                            </Badge>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Access Control</h3>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ playlist.user?.name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Expires At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(playlist.expires_at) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Max Connections</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ playlist.max_connections }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Allowed IPs</dt>
                                        <dd class="mt-1">
                                            <div class="flex flex-wrap gap-2">
                                                <Badge
                                                    v-for="ip in playlist.allowed_ips"
                                                    :key="ip"
                                                    variant="info"
                                                >
                                                    {{ ip }}
                                                </Badge>
                                                <span v-if="!playlist.allowed_ips?.length" class="text-sm text-gray-500">
                                                    No IP restrictions
                                                </span>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>

                        <!-- Channels -->
                        <div class="mb-8">
                            <h4 class="text-base font-medium text-gray-900 mb-4">
                                Channels ({{ playlist.channels?.length || 0 }})
                            </h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Stream Type
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="channel in playlist.channels" :key="channel.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" :src="channel.logo || '/default-channel.png'" :alt="channel.name">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ channel.name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <Badge>{{ channel.category?.name || "Uncategorized" }}</Badge>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <Badge variant="info">{{ channel.stream_type }}</Badge>
                                            </td>
                                        </tr>
                                        <tr v-if="!playlist.channels?.length">
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No channels in this playlist
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Movies -->
                        <div class="mb-8">
                            <h4 class="text-base font-medium text-gray-900 mb-4">
                                Movies ({{ playlist.movies?.length || 0 }})
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div
                                    v-for="movie in playlist.movies"
                                    :key="movie.id"
                                    class="relative group"
                                >
                                    <div class="aspect-w-2 aspect-h-3 rounded-lg overflow-hidden">
                                        <img
                                            :src="movie.poster || '/default-movie.png'"
                                            :alt="movie.name"
                                            class="object-cover"
                                        >
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <div class="font-medium">{{ movie.name }}</div>
                                                <div class="text-sm">{{ movie.duration }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="!playlist.movies?.length" class="col-span-full text-center text-sm text-gray-500">
                                    No movies in this playlist
                                </div>
                            </div>
                        </div>

                        <!-- Series -->
                        <div class="mb-8">
                            <h4 class="text-base font-medium text-gray-900 mb-4">
                                Series ({{ playlist.series?.length || 0 }})
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div
                                    v-for="series in playlist.series"
                                    :key="series.id"
                                    class="relative group"
                                >
                                    <div class="aspect-w-2 aspect-h-3 rounded-lg overflow-hidden">
                                        <img
                                            :src="series.poster || '/default-series.png'"
                                            :alt="series.name"
                                            class="object-cover"
                                        >
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <div class="font-medium">{{ series.name }}</div>
                                                <div class="text-sm">{{ series.seasons?.length || 0 }} Seasons</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="!playlist.series?.length" class="col-span-full text-center text-sm text-gray-500">
                                    No series in this playlist
                                </div>
                            </div>
                        </div>

                        <!-- Bouquets -->
                        <div>
                            <h4 class="text-base font-medium text-gray-900 mb-4">
                                Bouquets ({{ playlist.bouquets?.length || 0 }})
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <div
                                    v-for="bouquet in playlist.bouquets"
                                    :key="bouquet.id"
                                    class="bg-gray-50 rounded-lg p-4"
                                >
                                    <div class="font-medium text-gray-900">{{ bouquet.name }}</div>
                                    <div class="mt-2 text-sm text-gray-500">{{ bouquet.description }}</div>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <Badge>{{ bouquet.channels?.length || 0 }} Channels</Badge>
                                        <Badge variant="info">{{ bouquet.movies?.length || 0 }} Movies</Badge>
                                        <Badge variant="success">{{ bouquet.series?.length || 0 }} Series</Badge>
                                    </div>
                                </div>
                                <div v-if="!playlist.bouquets?.length" class="col-span-full text-center text-sm text-gray-500">
                                    No bouquets in this playlist
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div v-if="playlist.notes" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                        <div class="prose max-w-none">
                            {{ playlist.notes }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>