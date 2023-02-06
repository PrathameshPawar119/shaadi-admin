<x-mail::message>
# Introduction

Hello! {{$data['name']}}. How are you.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
