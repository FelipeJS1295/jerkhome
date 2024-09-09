<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateUserPasswords extends Command
{
    protected $signature = 'update:user-passwords';
    protected $description = 'Actualizar las contraseñas de los usuarios para usar Bcrypt';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $plainPassword = '';

            switch ($user->email) {
                case 'felipesilva@jerkhome.cl':
                    $plainPassword = 'Memo2812**';
                    break;
                case 'gabriel.vargas@jerkhome.cl':
                    $plainPassword = 'Gabriel2024*';
                    break;
                case 'richardgormaz@jerkhome.cl':
                    $plainPassword = 'Richard2024*';
                    break;
                case 'raulvalenzuela@jerkhome.cl':
                    $plainPassword = 'Raul2024*';
                    break;
            }

            if (!empty($plainPassword)) {
                $user->password = Hash::make($plainPassword);
                $user->save();
                $this->info("Password for {$user->email} updated successfully.");
            }
        }

        $this->info('All user passwords updated successfully.');
    }
}
