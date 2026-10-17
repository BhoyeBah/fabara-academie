@extends('layouts.admin', ['title' => 'Réglages'])

@section('content')
<h1>Réglages</h1>
<form method="post" action="{{ route('admin.settings.update') }}" class="panel form">
    @csrf @method('put')
    <div class="f"><label for="brand">Nom de l'école</label><input id="brand" name="brand" value="{{ old('brand', setting('brand')) }}" required></div>
    <div class="f"><label for="city">Ville</label><input id="city" name="city" value="{{ old('city', setting('city')) }}"></div>
    <div class="f"><label for="whatsapp">Numéro WhatsApp Business</label><input id="whatsapp" name="whatsapp" value="{{ old('whatsapp', setting('whatsapp')) }}" required><small>Avec l'indicatif, ex. 224620000000.</small></div>
    <div class="f"><label for="contact_email">E-mail de contact</label><input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', setting('contact_email')) }}" required><small>Affiché dans la politique de confidentialité.</small></div>
    <div class="f full"><label for="payment_info">Instructions de paiement</label><textarea id="payment_info" name="payment_info">{{ old('payment_info', setting('payment_info')) }}</textarea><small>Affichées au client après sa commande (numéros Orange Money, MTN MoMo…).</small></div>
    <div class="f full"><button class="btn btn-main">Enregistrer</button></div>
</form>
@endsection
