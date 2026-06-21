@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-brand-900">
    <div class="h-[75vh] bg-brand-100 rounded-3xl border border-brand-500/20 shadow-xl overflow-hidden flex flex-col md:flex-row relative">
        
        <!-- Left Side: Chat Rooms List -->
        <div id="chat-sidebar" class="w-full md:w-80 border-r border-brand-500/15 flex flex-col bg-brand-100/50 z-20">
            <div class="p-5 border-b border-brand-500/10 flex items-center justify-between">
                <h3 class="text-lg font-extrabold tracking-tight font-heading">Obrolan Kampus</h3>
                <span class="text-[10px] bg-brand-600 text-brand-50 font-bold px-2 py-0.5 rounded-full">In-App</span>
            </div>
            
            <div id="chats-list" class="flex-1 overflow-y-auto divide-y divide-brand-500/5 p-3 space-y-1.5">
                <!-- Dynamically populated via JS -->
            </div>
        </div>

        <!-- Right Side: Active Message Thread -->
        <div id="chat-thread-container" class="flex-1 flex flex-col bg-brand-50/45 relative z-10">
            
            <!-- Mobile Back Button and Header -->
            <div id="chat-header" class="p-4 border-b border-brand-500/10 flex items-center gap-3 bg-brand-100/30">
                <button onclick="backToSidebar()" class="md:hidden p-2 text-brand-600 hover:text-brand-900 focus:outline-none">
                    ←
                </button>
                <div class="flex items-center gap-3" id="active-contact-profile">
                    <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center font-bold">💬</div>
                    <div>
                        <h4 class="text-sm font-extrabold font-heading">Silakan Pilih Percakapan</h4>
                        <p class="text-[10px] text-brand-600 font-medium">Mulai bernegosiasi COD aman di wilayah kampus</p>
                    </div>
                </div>
            </div>

            <!-- Messages Stream -->
            <div id="messages-container" class="flex-grow p-6 overflow-y-auto space-y-4 flex flex-col">
                <div class="m-auto text-center space-y-2">
                    <span class="text-4xl">🤝</span>
                    <h4 class="font-bold text-sm text-brand-900/60 font-heading">Belum Ada Chat Terpilih</h4>
                    <p class="text-[10px] text-brand-600 max-w-xs leading-relaxed font-light">Pilih salah satu teman obrolan di samping kiri untuk melihat detail negosiasi barang preloved.</p>
                </div>
            </div>

            <!-- Message Send Form -->
            <div id="send-form-container" class="hidden p-4 border-t border-brand-500/10 bg-brand-100/40">
                <form onsubmit="handleSendMessage(event)" class="flex gap-2">
                    <input type="text" id="message-text" required placeholder="Ketik pesan negosiasi COD..." 
                           class="flex-1 px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:outline-none text-brand-900">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-brand-50 px-6 py-3 rounded-2xl font-bold text-xs uppercase shadow transition">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let querySeller = @json($seller ?? null);
    let queryProduct = @json($product ?? null);

    let activeChatRoomId = null;
    let activeContactId = null;
    let pollInterval = null;

    // Load active conversations on page open
    async function loadConversations() {
        const token = localStorage.getItem('preloved_token');
        if(!token) return;

        try {
            const response = await fetch('/api/v1/chats', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                const conversations = await response.json();

                // Add query parameter check
                if (querySeller && querySeller.id) {
                    const targetSellerId = parseInt(querySeller.id);
                    const targetProductId = queryProduct ? parseInt(queryProduct.id) : null;

                    let found = conversations.find(c => c.contact.id === targetSellerId && (!targetProductId || (c.product && c.product.id === targetProductId)));

                    if (!found) {
                        // Prepend a temporary conversation
                        const tempConv = {
                            id: 'new_temp',
                            contact: querySeller,
                            product: queryProduct,
                            latest_message: null
                        };
                        conversations.unshift(tempConv);
                    }
                }

                renderConversationsList(conversations);

                // Auto-select the conversation if query parameters exist
                if (querySeller && querySeller.id) {
                    const targetSellerId = parseInt(querySeller.id);
                    const targetProductId = queryProduct ? parseInt(queryProduct.id) : null;

                    let found = conversations.find(c => c.contact.id === targetSellerId && (!targetProductId || (c.product && c.product.id === targetProductId)));
                    if (found) {
                        const productTitle = found.product ? found.product.title : 'Produk Preloved';
                        const contactAvatar = found.contact.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
                        selectConversation(found.id, found.contact.id, found.contact.name, contactAvatar, productTitle);

                        // Clear variables so re-renders don't keep prepending
                        querySeller = null;
                        queryProduct = null;
                    }
                }
            }
        } catch (error) {
            console.log('Conversations API offline, using local mock data.');
            let conversations = getMockConversations();

            // Offline mock simulation for querySeller too
            if (querySeller && querySeller.id) {
                const targetSellerId = parseInt(querySeller.id);
                const targetProductId = queryProduct ? parseInt(queryProduct.id) : null;

                let found = conversations.find(c => c.contact.id === targetSellerId && (!targetProductId || (c.product && c.product.id === targetProductId)));
                if (!found) {
                    const tempConv = {
                        id: 'new_temp',
                        contact: querySeller,
                        product: queryProduct,
                        latest_message: null
                    };
                    conversations.unshift(tempConv);
                }
            }
            renderConversationsList(conversations);

            if (querySeller && querySeller.id) {
                const targetSellerId = parseInt(querySeller.id);
                const targetProductId = queryProduct ? parseInt(queryProduct.id) : null;

                let found = conversations.find(c => c.contact.id === targetSellerId && (!targetProductId || (c.product && c.product.id === targetProductId)));
                if (found) {
                    const productTitle = found.product ? found.product.title : 'Produk Preloved';
                    const contactAvatar = found.contact.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
                    selectConversation(found.id, found.contact.id, found.contact.name, contactAvatar, productTitle);

                    querySeller = null;
                    queryProduct = null;
                }
            }
        }
    }

    function renderConversationsList(conversations) {
        const listDiv = document.getElementById('chats-list');
        listDiv.innerHTML = '';

        if(conversations.length === 0) {
            listDiv.innerHTML = `
                <div class="text-center py-8 text-xs text-brand-600">
                    Belum ada obrolan aktif.
                </div>
            `;
            return;
        }

        conversations.forEach(c => {
            const contactName = c.contact ? c.contact.name : 'Mahasiswa Unsoed';
            const contactAvatar = c.contact ? c.contact.avatar_url : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
            const productTitle = c.product ? c.product.title : 'Produk Preloved';
            const lastText = c.latest_message ? c.latest_message.pesan : (c.message || 'Mulai obrolan baru...');
            const isUnread = c.latest_message && !c.latest_message.is_read && c.latest_message.sender_id !== getUserId();

            const card = document.createElement('button');
            card.onclick = () => selectConversation(c.id, c.contact.id, contactName, contactAvatar, productTitle);
            card.className = `w-full text-left p-3.5 rounded-2xl border transition flex items-center gap-3 group relative ${
                activeChatRoomId === c.id 
                    ? 'bg-brand-500 border-brand-500 text-brand-900 shadow-md' 
                    : 'bg-brand-50/50 border-brand-500/10 text-brand-900 hover:bg-brand-50'
            }`;

            card.innerHTML = `
                <img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500/30" src="${contactAvatar}">
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-baseline">
                        <h4 class="text-xs font-black truncate font-heading">${contactName}</h4>
                        ${isUnread ? '<span class="w-2 h-2 bg-rose-600 rounded-full"></span>' : ''}
                    </div>
                    <p class="text-[9px] font-extrabold text-brand-600 truncate mt-0.5">${productTitle}</p>
                    <p class="text-[10px] text-brand-900/60 truncate mt-1">${lastText}</p>
                </div>
            `;

            listDiv.appendChild(card);
        });
    }

    function getUserId() {
        const user = JSON.parse(localStorage.getItem('preloved_user') || '{}');
        return user.id || 0;
    }

    // Toggle views on mobile
    function selectConversation(chatId, contactId, contactName, avatar, productTitle) {
        activeChatRoomId = chatId;
        activeContactId = contactId;

        // Hide sidebar on mobile
        if(window.innerWidth < 768) {
            document.getElementById('chat-sidebar').classList.add('hidden');
        }

        // Set active header
        const header = document.getElementById('active-contact-profile');
        header.innerHTML = `
            <img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500 shadow-sm" src="${avatar}">
            <div>
                <h4 class="text-sm font-extrabold font-heading">${contactName}</h4>
                <p class="text-[10px] text-brand-600 font-bold uppercase">🛒 Hal: ${productTitle}</p>
            </div>
        `;

        document.getElementById('send-form-container').classList.remove('hidden');

        // Load Messages
        loadMessages();
        
        // Start polling for new messages every 3 seconds
        if(pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(loadMessages, 3000);
    }

    function backToSidebar() {
        document.getElementById('chat-sidebar').classList.remove('hidden');
        activeChatRoomId = null;
        activeContactId = null;
        if(pollInterval) clearInterval(pollInterval);
    }

    async function loadMessages() {
        if(!activeContactId) return;
        const token = localStorage.getItem('preloved_token');

        if (activeChatRoomId === 'new_temp') {
            const container = document.getElementById('messages-container');
            container.innerHTML = `
                <div class="m-auto text-center py-10 text-xs text-brand-600">
                    Belum ada riwayat pesan. Kirim pesan pertama untuk bernegosiasi!
                </div>
            `;
            return;
        }

        try {
            const response = await fetch(`/api/v1/chats/${activeContactId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                const result = await response.json();
                renderMessages(result.messages);
            }
        } catch (error) {
            console.log('Messages fetch offline, rendering fallback.');
        }
    }

    function renderMessages(messages) {
        const container = document.getElementById('messages-container');
        container.innerHTML = '';
        const myId = getUserId();

        if(!messages || messages.length === 0) {
            container.innerHTML = `
                <div class="m-auto text-center py-10 text-xs text-brand-600">
                    Belum ada riwayat pesan. Kirim pesan pertama untuk bernegosiasi!
                </div>
            `;
            return;
        }

        messages.forEach(m => {
            const isMe = m.sender_id === myId;
            const bubble = document.createElement('div');
            bubble.className = `flex ${isMe ? 'justify-end' : 'justify-start'} w-full`;

            bubble.innerHTML = `
                <div class="max-w-[70%] p-3.5 rounded-2xl border shadow-sm text-xs ${
                    isMe 
                        ? 'bg-brand-600 border-brand-600 text-brand-50 rounded-tr-none' 
                        : 'bg-brand-100 border-brand-500/10 text-brand-900 rounded-tl-none'
                }">
                    <p class="leading-relaxed whitespace-pre-wrap">${m.pesan || m.message}</p>
                    <span class="block text-[8px] mt-1.5 text-right opacity-70">${new Date(m.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
            `;

            container.appendChild(bubble);
        });

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }

    async function handleSendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('message-text');
        const text = input.value.trim();
        const token = localStorage.getItem('preloved_token');

        if(!text || !activeContactId) return;

        input.value = '';

        try {
            const body = {
                receiver_id: activeContactId,
                message: text
            };
            if (queryProduct) {
                body.product_id = queryProduct.id;
            }

            const response = await fetch('/api/v1/chats', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(body)
            });

            if (response.ok) {
                const result = await response.json();
                if (activeChatRoomId === 'new_temp') {
                    activeChatRoomId = result.chat.id;
                }
                loadMessages();
            }
        } catch (error) {
            console.log('Offline send simulation.');
            const container = document.getElementById('messages-container');
            if (container.querySelector('.m-auto')) {
                container.innerHTML = '';
            }
            const bubble = document.createElement('div');
            bubble.className = `flex justify-end w-full`;
            bubble.innerHTML = `
                <div class="max-w-[70%] p-3.5 rounded-2xl border shadow-sm text-xs bg-brand-600 border-brand-600 text-brand-50 rounded-tr-none">
                    <p class="leading-relaxed whitespace-pre-wrap">${text}</p>
                    <span class="block text-[8px] mt-1.5 text-right opacity-70">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
            `;
            container.appendChild(bubble);
            container.scrollTop = container.scrollHeight;
        }
    }

    // Mock Offline Conversations
    function getMockConversations() {
        return [
            {
                id: 1,
                contact: { id: 2, name: 'Fadhil FT Unsoed', avatar_url: 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80' },
                product: { title: 'Buku Kalkulus Purcell Ed. 9' },
                latest_message: { pesan: 'Bisa ketemuan jam 2 siang di Perpustakaan Pusat?', is_read: false, sender_id: 2, created_at: new Date() }
            },
            {
                id: 2,
                contact: { id: 3, name: 'Amelia FEB', avatar_url: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80' },
                product: { title: 'iPad Air 4 64GB WiFi' },
                latest_message: { pesan: 'Nego tipis 5,1 juta boleh tidak kak?', is_read: true, sender_id: 99, created_at: new Date() }
            }
        ];
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadConversations();
    });
</script>
@endsection
