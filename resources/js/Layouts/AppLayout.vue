<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { Bars3Icon, XMarkIcon, UserIcon, CogIcon, ArrowLeftOnRectangleIcon } from "@heroicons/vue/24/outline";
import Toast from "@/Components/Toast.vue";

const navigation = [
    { name: "Dashboard", href: "/dashboard" },
    { name: "Channels", href: "/channels" },
    { name: "Movies", href: "/movies" },
    { name: "Series", href: "/series" },
    { name: "Categories", href: "/categories" },
    { name: "EPG", href: "/epg" },
    { name: "Bouquets", href: "/bouquets" },
    { name: "Playlists", href: "/playlists" },
];

const userNavigation = [
    { name: "Your Profile", href: "/profile", icon: UserIcon },
    { name: "Settings", href: "/settings", icon: CogIcon },
    { name: "Sign out", href: "/logout", icon: ArrowLeftOnRectangleIcon, method: "post" },
];

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Disclosure as="nav" class="bg-white shadow-sm" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <img class="block h-8 w-auto lg:hidden" src="/logo.svg" alt="Xtream Panel" />
                            <img class="hidden h-8 w-auto lg:block" src="/logo.svg" alt="Xtream Panel" />
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <Link v-for="item in navigation" :key="item.name" :href="item.href"
                                :class="[
                                    $page.url.startsWith(item.href)
                                        ? 'border-primary-500 text-gray-900'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                                ]">
                                {{ item.name }}
                            </Link>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <Menu as="div" class="relative ml-3">
                            <div>
                                <MenuButton
                                    class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" :src="$page.props.auth.user.avatar || '/default-avatar.png'"
                                        :alt="$page.props.auth.user.name" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-200"
                                enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <Link :href="item.href" :method="item.method || 'get'" as="button"
                                            :class="[
                                                active ? 'bg-gray-100' : '',
                                                'flex w-full items-center px-4 py-2 text-sm text-gray-700',
                                            ]">
                                            <component :is="item.icon"
                                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                            {{ item.name }}
                                        </Link>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <DisclosureButton
                            class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="sm:hidden">
                <div class="space-y-1 pb-3 pt-2">
                    <Link v-for="item in navigation" :key="item.name" :href="item.href" :class="[
                        $page.url.startsWith(item.href)
                            ? 'bg-primary-50 border-primary-500 text-primary-700'
                            : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
                        'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                    ]">
                        {{ item.name }}
                    </Link>
                </div>
                <div class="border-t border-gray-200 pb-3 pt-4">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="$page.props.auth.user.avatar || '/default-avatar.png'"
                                :alt="$page.props.auth.user.name" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <Link v-for="item in userNavigation" :key="item.name" :href="item.href" :method="item.method || 'get'"
                            :class="[
                                $page.url === item.href
                                    ? 'bg-primary-50 border-primary-500 text-primary-700'
                                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
                                'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                            ]">
                            {{ item.name }}
                        </Link>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <div class="py-10">
            <header v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
    <Toast />
</template>
