<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3';

// Get current user from Inertia.js
const page = usePage();
const user = page.props.auth.user;

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

// Props
const props = defineProps({ users: Array });

// State variables
const messages = ref([]);
const receiver = ref(null);
const userMessage = ref('');

// Select user & fetch chat history
const selectUser = async (friend) => {
    receiver.value = friend;

    try {
        const response = await fetch(`/load-chat?receiver_id=${friend.id}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to load chat');

        const data = await response.json();

        messages.value = data.recent_chat;
    } catch (error) {
        console.error("Error loading chat:", error);
    }
};

// Send message
const sendMessage = async () => {
  if (!userMessage.value.trim()) return;

  const newMessage = {
    sender_id: user.id,
    receiver_id: receiver.value?.id, // Ensure receiver is selected
    message: userMessage.value
  };

  messages.value.push(newMessage); // No more "push is not a function" error

  try {
    await fetch("/send-message", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      body: JSON.stringify(newMessage)
    });

    userMessage.value = "";
  } catch (error) {
    console.error("Error sending message:", error);
  }
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex">
            <!-- Sidebar with Users -->
            <aside class="w-64 h-screen bg-white shadow-lg p-4 border-r">
                <h2 class="text-xl font-bold mb-4">Users</h2>
                <div class="space-y-2">
                    <button 
                        v-for="user in users" 
                        :key="user.id"
                        @click="selectUser(user)"
                        class="flex items-center p-2 w-full text-left rounded-lg transition hover:bg-gray-200"
                        :class="receiver?.id === user.id ? 'bg-gray-300' : ''"
                    >
                        <img :src="`https://i.pravatar.cc/40?img=${user.id}`" class="w-8 h-8 rounded-full mr-2" alt="Avatar" />
                        <span class="text-gray-900">{{ user.name }}</span>
                    </button>
                </div>
            </aside>

            <!-- Chat Box -->
            <div class="fixed bottom-4 right-4 w-96">
                <Card>
                    <CardContent class="p-4 h-96 overflow-y-auto">
                        <div v-for="(msg, index) in messages" :key="index" class="mb-2">
                            <div :class="msg.sender_id === user.id ? 'text-right text-blue-600' : 'text-left text-gray-600'">
                                {{ msg.message }}
                            </div>
                        </div>
                    </CardContent>
                    <div class="p-2 border-t flex items-center">
                        <Input v-model="userMessage" placeholder="Type a message..." class="flex-1 mr-2" @keyup.enter="sendMessage" />
                        <Button @click="sendMessage">Send</Button>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>


