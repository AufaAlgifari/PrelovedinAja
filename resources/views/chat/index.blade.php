@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-brand-900">
    <!-- Back to Checkout Banner (shown when coming from checkout page) -->
    <div id="checkout-return-banner" class="hidden mb-4 p-4 bg-[#7A4A10] text-[#FBF6EC] rounded-2xl flex items-center justify-between shadow-lg animate-pulse-once">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 0l3-3m-3 3l3 3M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            <span class="text-xs font-bold">Anda sedang dalam proses checkout. Selesaikan chat lalu kembali ke halaman pembayaran.</span>
        </div>
        <a id="checkout-return-link" href="#" class="shrink-0 px-5 py-2.5 bg-[#FBF6EC] text-[#7A4A10] font-extrabold text-xs rounded-xl hover:bg-white transition shadow-sm">
            ← Kembali ke Checkout
        </a>
    </div>

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
                    <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025 4.486 4.486 0 00-.471-3.06C3.766 14.44 3 13.3 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold font-heading">Silakan Pilih Percakapan</h4>
                        <p class="text-[10px] text-brand-600 font-medium">Mulai bernegosiasi COD aman di wilayah kampus</p>
                    </div>
                </div>
            </div>
 
             <!-- Messages Stream -->
             <div id="messages-container" class="flex-grow p-6 overflow-y-auto space-y-4 flex flex-col">
                 <div class="m-auto text-center space-y-3">
                     <div class="flex justify-center text-brand-500/40">
                         <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.1.103.147.25.124.393L4.85 20.5a.75.75 0 00.998.85l2.92-1.46c.117-.058.25-.063.37-.013A9.704 9.704 0 0012 20.25z" />
                         </svg>
                     </div>
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
    let activeChatRoomId = null;
    let activeContactId = null;
    let activeProductId = null;
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
                renderConversationsList(conversations);
                handleUrlParams(conversations);
            }
        } catch (error) {
            console.log('Conversations API offline, using local mock data.');
            const mockConvs = getMockConversations();
            renderConversationsList(mockConvs);
            handleUrlParams(mockConvs);
        }
    }

    function handleUrlParams(conversations) {
        const urlParams = new URLSearchParams(window.location.search);
        const contactId = urlParams.get('contact_id');
        const productId = urlParams.get('product_id');

        if (contactId) {
            const parsedContactId = parseInt(contactId);
            const parsedProductId = productId ? parseInt(productId) : null;

            // Find existing conversation in the list
            let existing = conversations.find(c => c.contact && c.contact.id === parsedContactId);
            
            if (existing) {
                const contactAvatar = existing.contact ? existing.contact.avatar_url : '';
                const productTitle = existing.product ? existing.product.title : 'Produk Preloved';
                selectConversation(existing.id, existing.contact.id, existing.contact.name, contactAvatar, productTitle);
            } else {
                const contactName = urlParams.get('contact_name') || 'Penjual';
                const contactAvatar = urlParams.get('contact_avatar') || '';
                const productTitle = urlParams.get('product_title') || 'Produk Preloved';

                addVirtualConversation(parsedContactId, contactName, contactAvatar, productTitle, parsedProductId);
            }
        }
    }

    function addVirtualConversation(contactId, contactName, avatar, productTitle, productId) {
        const listDiv = document.getElementById('chats-list');
        
        // Remove empty state message if it is there
        if (listDiv.innerText.includes('Belum ada obrolan aktif.')) {
            listDiv.innerHTML = '';
        }

        // Check if there is already a virtual card for this contact
        let existingVirtual = document.getElementById(`virtual-chat-${contactId}`);
        if (!existingVirtual) {
            const card = document.createElement('button');
            card.id = `virtual-chat-${contactId}`;
            card.onclick = () => selectVirtualConversation(contactId, contactName, avatar, productTitle, productId);
            card.className = `w-full text-left p-3.5 rounded-2xl border transition flex items-center gap-3 group relative bg-brand-50/50 border-brand-500/10 text-brand-900 hover:bg-brand-50`;

            const hasAvatar = avatar && avatar !== 'null' && avatar !== '';
            const avatarHtml = hasAvatar
                ? `<img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500/30 shrink-0" src="${avatar}" onerror="this.onerror=null; replaceWithEmptyAvatar(this);">`
                : getEmptyAvatarHtml();

            card.innerHTML = `
                ${avatarHtml}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-baseline">
                        <h4 class="text-xs font-black truncate font-heading">${contactName}</h4>
                        <span class="text-[8px] bg-brand-600 text-white px-1.5 py-0.5 rounded font-bold">Baru</span>
                    </div>
                    <p class="text-[9px] font-extrabold text-brand-600 truncate mt-0.5">${productTitle}</p>
                    <p class="text-[10px] text-brand-900/60 truncate mt-1">Mulai obrolan baru...</p>
                </div>
            `;
            listDiv.insertBefore(card, listDiv.firstChild);
        }

        // Auto select it!
        selectVirtualConversation(contactId, contactName, avatar, productTitle, productId);
    }

    function selectVirtualConversation(contactId, contactName, avatar, productTitle, productId) {
        activeChatRoomId = 'virtual';
        activeContactId = contactId;
        activeProductId = productId;

        // Hide sidebar on mobile
        if(window.innerWidth < 768) {
            document.getElementById('chat-sidebar').classList.add('hidden');
        }

        const hasAvatar = avatar && avatar !== 'null' && avatar !== '';
        const avatarHtml = hasAvatar
            ? `<img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500 shadow-sm shrink-0" src="${avatar}" onerror="this.onerror=null; replaceWithEmptyAvatar(this);">`
            : getEmptyAvatarHtml();

        const header = document.getElementById('active-contact-profile');
        header.innerHTML = `
            ${avatarHtml}
            <div>
                <h4 class="text-sm font-extrabold font-heading">${contactName}</h4>
                <p class="text-[10px] text-brand-600 font-bold uppercase">Hal: ${productTitle}</p>
            </div>
        `;

        document.getElementById('send-form-container').classList.remove('hidden');

        const container = document.getElementById('messages-container');
        container.innerHTML = `
            <div class="m-auto text-center py-10 text-xs text-brand-600">
                Belum ada riwayat pesan. Kirim pesan pertama untuk bernegosiasi!
            </div>
        `;

        if(pollInterval) clearInterval(pollInterval);
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
            const contactAvatar = c.contact ? c.contact.avatar_url : null;
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

            const hasAvatar = contactAvatar && contactAvatar !== 'null' && contactAvatar !== '';
            const avatarHtml = hasAvatar
                ? `<img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500/30 shrink-0" src="${contactAvatar}" onerror="this.onerror=null; replaceWithEmptyAvatar(this);">`
                : getEmptyAvatarHtml();

            card.innerHTML = `
                ${avatarHtml}
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
        activeProductId = null;

        // Hide sidebar on mobile
        if(window.innerWidth < 768) {
            document.getElementById('chat-sidebar').classList.add('hidden');
        }

        const hasAvatar = avatar && avatar !== 'null' && avatar !== '';
        const avatarHtml = hasAvatar
            ? `<img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500 shadow-sm shrink-0" src="${avatar}" onerror="this.onerror=null; replaceWithEmptyAvatar(this);">`
            : getEmptyAvatarHtml();

        // Set active header - REMOVED 🛒 emoji
        const header = document.getElementById('active-contact-profile');
        header.innerHTML = `
            ${avatarHtml}
            <div>
                <h4 class="text-sm font-extrabold font-heading">${contactName}</h4>
                <p class="text-[10px] text-brand-600 font-bold uppercase">Hal: ${productTitle}</p>
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
        activeProductId = null;
        if(pollInterval) clearInterval(pollInterval);
    }

    async function loadMessages() {
        if(!activeContactId || activeChatRoomId === 'virtual') return;
        const token = localStorage.getItem('preloved_token');

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
            const bodyData = {
                receiver_id: activeContactId,
                message: text
            };
            if (activeProductId) {
                bodyData.product_id = activeProductId;
            }

            const response = await fetch('/api/v1/chats', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(bodyData)
            });

            if (response.ok) {
                const result = await response.json();
                
                // Convert virtual conversation to real room
                if (activeChatRoomId === 'virtual') {
                    activeChatRoomId = result.chat ? result.chat.id : null;
                    activeProductId = null;
                    const vCard = document.getElementById(`virtual-chat-${activeContactId}`);
                    if (vCard) vCard.remove();
                }

                await loadConversations();
                loadMessages();
            }
        } catch (error) {
            console.log('Offline send simulation.');
        }
    }

    function getEmptyAvatarHtml() {
        return `
            <div class="h-10 w-10 rounded-full bg-brand-500/20 text-brand-900 flex items-center justify-center border-2 border-brand-500/30 font-bold shrink-0">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
        `;
    }

    function replaceWithEmptyAvatar(img) {
        const div = document.createElement('div');
        div.className = "h-10 w-10 rounded-full bg-brand-500/20 text-brand-900 flex items-center justify-center border-2 border-brand-500/30 font-bold shrink-0";
        div.innerHTML = `
            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        `;
        img.parentNode.replaceChild(div, img);
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

        // Show "Back to Checkout" banner if coming from checkout page
        const urlParams = new URLSearchParams(window.location.search);
        const returnTo = urlParams.get('return_to');
        const checkoutProductId = urlParams.get('checkout_product_id');
        if (returnTo === 'checkout' && checkoutProductId) {
            const banner = document.getElementById('checkout-return-banner');
            const link = document.getElementById('checkout-return-link');
            if (banner && link) {
                link.href = `/checkout/${checkoutProductId}`;
                banner.classList.remove('hidden');
            }
        }
    });
</script>
@endsection
