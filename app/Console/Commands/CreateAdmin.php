<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/**
 * Crée (ou promeut) le compte administrateur.
 * Le compte admin n'est jamais créé par le formulaire d'inscription public.
 */
#[Signature('app:create-admin {email?} {--name=Administrateur}')]
#[Description("Crée le compte administrateur de l'école")]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Adresse e-mail de l\'administrateur');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->forceFill(['is_admin' => true])->save();
            $this->info("Le compte {$email} est maintenant administrateur.");

            return self::SUCCESS;
        }

        $password = $this->secret('Mot de passe (12 caractères minimum)');
        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email'], 'password' => ['required', Password::min(12)->letters()->numbers()]]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = new User(['name' => $this->option('name'), 'email' => $email, 'password' => $password]);
        $user->forceFill(['is_admin' => true, 'email_verified_at' => now(), 'terms_accepted_at' => now(), 'terms_version' => config('legal.version')])->save();
        $this->info("Compte administrateur créé : {$email}");

        return self::SUCCESS;
    }
}
