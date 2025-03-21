<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Accordion, AccordionItem, AccordionTrigger, AccordionContent } from '@/components/ui/accordion';
import { ref, defineProps, onMounted } from "vue";
import { Input } from '@/components/ui/input';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;  // Get the user

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps({
  users: Array
});

const messages = ref([]);
const userMessage = ref('');
const receiver = ref(null);

const selectUser = async (friend) => {
  receiver.value = friend;

  try {
    const response = await fetch(`/load-chat?friend_id=${friend}`, {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Failed to load chat');
    }

    messages.value = await response.json();  // Store chat messages
  } catch (error) {
    console.error("Error loading chat:", error);
  }
};

const sendMessage = async () => {
  if (userMessage.value.trim() === "") return;

  const newMessage = {
    sender_id: user.id,
    receiver_id: receiver.id,
    message: userMessage.value
  };

  messages.value.push(newMessage);

  await fetch("/send-message", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    body: JSON.stringify(newMessage)
  });

  userMessage.value = "";
};

// Listen for real-time messages
// onMounted(() => {
//   window.Echo.private("chat.2") // Replace with actual user ID
//     .listen("MessageSent", (event) => {
//       messages.value.push(event);
//     });
// });
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <aside class="w-64 h-screen bg-white shadow-lg p-4 border-r">
                <h2 class="text-xl font-bold mb-4">Users</h2>
                <div class="space-y-2">
                  <button 
                    v-for="user in users" 
                    :key="user.id"
                    @click="selectUser(user)"
                    class="flex items-center p-2 w-full text-left rounded-lg transition 
                          hover:bg-gray-200"
                    :class="selectedUser?.id === user.id ? 'bg-gray-300' : ''"
                  >
                    <img src="https://i.pravatar.cc/40?img=2" class="w-8 h-8 rounded-full mr-2" alt="Avatar" />
                    <span class="text-gray-900">{{ user.name }}</span>
                  </button>
                </div>
            </aside>
        </div>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div>
                        <p>Welcome, {{ user?.name }}</p>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>

        <div class="fixed bottom-4 right-4 w-96">
            <Card>
              <CardContent class="p-4 h-96 overflow-y-auto">
                <div v-for="(msg, index) in messages" :key="index" class="mb-2">
                  <div :class="msg.sender_id === 1 ? 'text-right text-blue-600' : 'text-left text-gray-600'">
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
    </AppLayout>
</template>

