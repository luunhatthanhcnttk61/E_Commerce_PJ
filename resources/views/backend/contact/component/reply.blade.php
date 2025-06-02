@component('mail::message')
# Xin chào {{ $contact->name }}

Cảm ơn bạn đã liên hệ với chúng tôi. Dưới đây là phản hồi cho tin nhắn của bạn:

@component('mail::panel')
{{ $replyContent }}
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Truy cập website
@endcomponent

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent