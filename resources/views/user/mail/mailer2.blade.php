<x-mail::message>
# Layanan Helpdesk E-Service

Hallo <b>{{ $name }}</b>, untuk saat ini progres pengerjaan perangkat kamu ditoko kami reject atau mengalami kegagalan. kamu
bisa click tombol dibawah untuk diantarkan ke menu dashboard untuk detailnya.

<table border="1" style="border-collapse: collapse; width: 100%">
<tbody>
<tr>
<td colspan="2">tiket#{{ $ticket->id_ticket }}</td>
</tr>
<tr>
<td>Nama pengguna</td>
<td>{{ $name }}</td>
</tr>
<tr>
<td>Email</td>
<td>{{ $email }}</td>
</tr>
<tr>
<td>waktu dikerjakan</td>
<td>{{ $ticket->created_at }}</td>
</tr>
<tr>
<td>selesai</td>
<td>{{ $ticket->closed_at }}</td>
</tr>
<tr>
<td>Status</td>
<td>{{ $type }}</td>
</tr>
</tbody>
</table>

 <x-mail::button :url="route('dashboard')">
 Kunjungi dashboard
 </x-mail::button>

Atas informasi diatas perangkat anda sudah bisa diambil ditoko

Terima kasih atas perhatiannya<br>
Fitri, Helpdesk {{ config('app.name') }}
</x-mail::message>
