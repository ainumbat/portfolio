<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { Toaster } from '@/components/ui/toast'
import { useToast } from '@/components/ui/toast/use-toast';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3';
import { onMounted, nextTick } from 'vue';
import moment from 'moment';
import { watchEffect } from "vue";
import '../echo';

const { toast } = useToast()
const message_received = new Audio('/sounds/message_received.mp3');
const message_sent = new Audio('/sounds/message_sent.wav');

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
const chatContainer = ref(null);

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

        nextTick(() => {
            chatContainer.value.$el.scrollTo({ top: chatContainer.value.$el.scrollHeight, behavior: 'smooth' });
            // if (chatContainer.value?.$el) {
            //     chatContainer.value.$el.scrollTop = chatContainer.value.$el.scrollHeight;
            // }
        });
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
    message_sent.play();

    nextTick(() => {
        if (chatContainer.value?.$el) {
            chatContainer.value.$el.scrollTop = chatContainer.value.$el.scrollHeight;
        }
    });
  } catch (error) {
    console.error("Error sending message:", error);
  }
};

const isTyping = ref(false);

watchEffect(() => {
    if (userMessage.value.trim()) {
        Echo.private(`chat.${receiver.value?.id}`).whisper('typing', { user: user.name });
        isTyping.value = true;
    } else {
        isTyping.value = false;
    }
});

// Function to show toast notification
const showToast = (sender: string, message: string) => {
    toast({
        title: "New Message from " + sender,
        description: message,
        duration: 3000, // Toast disappears after 3 seconds
    });
};

onMounted(() => {
    Echo.private(`chat.${user.id}`)
        .listen("MessageSent", (event) => {
            if (event.receiver_id == receiver.id) {
                messages.value.push(event);
            }
            message_received.play();
            nextTick(() => {
                chatContainer.value.$el.scrollTop = chatContainer.value.$el.scrollHeight;
            });
            showToast(event.sender.name, event.message);
            // console.log('Private message:', event);
        }).whisper('typing', (e) => {
            console.log(`User ${e.user} is typing...`);
        });
});

</script>

<template>
    <Head title="Dashboard" />
    <Toaster />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-[92vh]">
            <!-- Sidebar with Users -->
            <aside class="w-64 h-[92vh] bg-white shadow-lg p-4 border-r overflow-y-auto">
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
            <div class="flex flex-col flex-1 h-full">
                <Card class="flex flex-col h-[92vh]">  <!-- w-[50vw] h-[80vh] -->
                    <CardContent ref="chatContainer" class="p-4 flex-1 overflow-y-auto">
                        <div v-for="(msg, index) in messages" :key="index" class="mb-2 flex" 
                             :class="msg.sender_id === user.id ? 'justify-start' : 'justify-end'">
                            <div 
                                :class="msg.sender_id === user.id 
                                    ? 'bg-green-500 text-white rounded-lg p-2 max-w-xs relative' 
                                    : 'bg-blue-300 text-black rounded-lg p-2 max-w-xs relative'">
                                <span>{{ msg.message }}</span>
                                <span class="block text-xs text-gray-600 mt-1">{{ moment(msg.created_at).fromNow() }}</span>
                                <span 
                                    :class="msg.sender_id === user.id 
                                        ? 'absolute left-0 top-1/2 w-0 h-0 border-t-8 border-b-8 border-r-8 border-r-green-500 border-transparent' 
                                        : 'absolute right-0 top-1/2 w-0 h-0 border-t-8 border-b-8 border-l-8 border-l-blue-300 border-transparent'">
                                </span>
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


