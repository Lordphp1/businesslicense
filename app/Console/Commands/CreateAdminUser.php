<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user {email? : Email address of the staff account} {--name= : Display name for a new account} {--password= : Password for a new account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a staff account or grant back-office access to an existing account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email address of the staff account');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('That is not a valid email address.');

            return self::FAILURE;
        }

        $existing = User::query()->where('email', $email)->first();

        if ($existing !== null) {
            if ($this->input->isInteractive() && ! $this->confirm("Grant back-office access to {$existing->name} <{$email}>?", true)) {
                $this->line('No changes made.');

                return self::SUCCESS;
            }

            $existing->forceFill(['is_admin' => true])->save();

            $this->info("Back-office access granted to {$email}.");

            return self::SUCCESS;
        }

        $name = $this->option('name') ?: $this->ask('Display name');
        $password = $this->option('password') ?: $this->secret('Password (min. 10 characters, letters and numbers)');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'password' => ['required', Password::min(10)->letters()->numbers()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $user->forceFill(['is_admin' => true])->save();

        $this->info("Staff account created for {$email}.");
        $this->line('Sign in at /login and you will be taken to the back office.');

        return self::SUCCESS;
    }
}
