@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <h1>Chat with {{ $user->name }}</h1>

    <div id="chat">
        <div v-for="message in messages" :key="message . id" class="message">
            <p>{{ $messages->content }}</p>
            <small>{{ $messages->created_at }}</small>
        </div>
    </div>

    <form @submit.prevent="sendMessage">
        <textarea v-model="newMessage" placeholder="Type your message..."></textarea>
        <button type="submit">Send</button>
    </form>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    const app = new Vue({
        el: '#app',
        data: {
            messages: @json($messages),
            newMessage: ''
        },
        methods: {
            sendMessage() {
                axios.post('{{ route('messages.store') }}', {
                    receiver_id: {{ $user->id }},
                    content: this.newMessage
                })
                    .then(response => {
                        console.log(response.data);
                        this.newMessage = ''; // Clear input after sending
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                    });
            }
        },
        mounted() {
            Echo.private(`messages.${{{ $user->id }}}`)
                .listen('NewMessage', (message) => {
                    this.messages.push(message);
                });
        }
    });
</script>
@endsection