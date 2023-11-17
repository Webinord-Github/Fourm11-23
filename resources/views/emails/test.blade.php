

@extends('layouts.app')
@section('content')
<form id="send-email-form" method="post" action="{{ route('send.email') }}">
    @csrf
    <input type="text" name="email_body" placeholder="Enter email body">
    <button id="send-email-button" type="submit">Send Email</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#send-email-form').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var token = "{{ csrf_token() }}";
            var emailBody = $('input[name="email_body"]').val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('send.email') }}",
                data: {_token: token, email_body: emailBody},
                success: function(response) {
                    alert('Email sent successfully!');
                },
                error: function(xhr) {
                    // Handle error
                    alert('An error occurred while sending the email.');
                }
            });
        });
    });
</script>

@endsection