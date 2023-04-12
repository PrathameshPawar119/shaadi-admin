<x-mail::message>
# Congratulations {{$contractor->name}}! Company Created Successfully.

## {{$company->name}}

<x-mail::button :url="config('app.url').'/contractor/login'">
Company Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
