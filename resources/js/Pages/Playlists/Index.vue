<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    playlists: Object,
    filters: Object,
});

const selectedPlaylists = ref([]);

const togglePlaylist = (playlistId) => {
    const index = selectedPlaylists.value.indexOf(playlistId);
    if (index === -1) {
        selectedPlaylists.value.push(playlistId);
    } else {
        selectedPlaylists.value.splice(index, 1);
    }
};

const deleteSelected = () => {
    if (confirm(`Are you sure you want to delete ${selectedPlaylists.value.length} playlists?`)) {
        router.delete(route("playlists.destroy", { ids: selectedPlaylists.value }), {
            onSuccess: () => {
                selectedPlaylists.value = [];
            },
        });
    }
};

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString() : 'Never';
};
</script>

<template>
    <AppLayout>
        <Head title="Playlists" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Playlists
                </h2>

                <div class="flex items-center space-x-4">
                    <Button
                        v-if="selectedPlaylists.length > 0"
                        variant="danger"
                        size="sm"
                        @click="deleteSelected"
                    >
                        Delete Selected ({{ selectedPlaylists.length }})
                    </Button>

                    <Button
                        href="/playlists/create"
                        size="sm"
                    >
                        Add Playlist
                    </Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input
                                                type="checkbox"
                                                :checked="selectedPlaylists.length === playlists.data.length"
                                                :indeterminate="selectedPlaylists.length > 0 && selectedPlaylists.length < playlists.data.length"
                                                @change="$event.target.checked ? selectedPlaylists = playlists.data.map(p => p.id) : selectedPlaylists = []"
                                                class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                            >
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Content
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expires
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="playlist in playlists.data" :key="playlist.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input
                                                type="checkbox"
                                                :checked="selectedPlaylists.includes(playlist.id)"
                                                @change="togglePlaylist(playlist.id)"
                                                class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                            >
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ playlist.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ playlist.description }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ playlist.user?.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ playlist.user?.email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <Badge v-if="playlist.channels?.length">
                                                    {{ playlist.channels.length }} Channels
                                                </Badge>
                                                <Badge v-if="playlist.movies?.length" variant="info">
                                                    {{ playlist.movies.length }} Movies
                                                </Badge>
                                                <Badge v-if="playlist.series?.length" variant="success">
                                                    {{ playlist.series.length }} Series
                                                </Badge>
                                                <Badge v-if="playlist.bouquets?.length" variant="warning">
                                                    {{ playlist.bouquets.length }} Bouquets
                                                </Badge>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <Badge :variant="playlist.is_active ? 'success' : 'danger'">
                                                {{ playlist.is_active ? "Active" : "Inactive" }}
                                            </Badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatDate(playlist.expires_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <Link :href="`/playlists/${playlist.id}`" class="text-primary-600 hover:text-primary-900">
                                                View
                                            </Link>
                                            <Link :href="`/playlists/${playlist.id}/edit`" class="text-primary-600 hover:text-primary-900">
                                                Edit
                                            </Link>
                                            <Link :href="`/playlists/${playlist.id}/export`" class="text-primary-600 hover:text-primary-900">
                                                Export
                                            </Link>
                                            <button
                                                @click="() => router.delete(`/playlists/${playlist.id}`)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    <Link
                                        v-if="playlists.prev_page_url"
                                        :href="playlists.prev_page_url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Previous
                                    </Link>
                                    <Link
                                        v-if="playlists.next_page_url"
                                        :href="playlists.next_page_url"
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Next
                                    </Link>
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{ playlists.from }}</span>
                                            to
                                            <span class="font-medium">{{ playlists.to }}</span>
                                            of
                                            <span class="font-medium">{{ playlists.total }}</span>
                                            results
                                        </p>
                                    </div>
                                    <div>
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                            <Link
                                                v-if="playlists.prev_page_url"
                                                :href="playlists.prev_page_url"
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                            >
                                                <span class="sr-only">Previous</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </Link>

                                            <template v-for="(link, i) in playlists.links.slice(1, -1)" :key="i">
                                                <Link
                                                    :href="link.url"
                                                    :class="[
                                                        link.active
                                                            ? 'z-10 bg-primary-50 border-primary-500 text-primary-600'
                                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
                                                    ]"
                                                >
                                                    {{ link.label }}
                                                </Link>
                                            </template>

                                            <Link
                                                v-if="playlists.next_page_url"
                                                :href="playlists.next_page_url"
                                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                            >
                                                <span class="sr-only">Next</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </Link>
                                        </nav>
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