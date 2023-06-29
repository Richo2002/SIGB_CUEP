@component('mail::message')
# Introduction

Bonjour {{  }},

Nous sommes ravis de vous informer que votre compte de bibliothécaire a été créé avec succès ! Vous pouvez maintenant accéder à notre plateforme de gestion de la bibliothèque. <br>

Veuillez cliquer sur le bouton ci-dessous pour définir votre mot de passe :

@component('mail::button', ['url' => ''])
Continuer
@endcomponent

<br>

Si vous avez des questions ou rencontrez des problèmes lors de la définition de votre mot de passe, n'hésitez pas à nous contacter à l'adresse *cuep@gmail.com*. <br>

Nous vous remercions d'avoir rejoint notre équipe de bibliothécaires et nous sommes impatients de collaborer avec vous.

Cordialement,
CUEP

Thanks,<br>
{{ config('app.name') }}
@endcomponent
